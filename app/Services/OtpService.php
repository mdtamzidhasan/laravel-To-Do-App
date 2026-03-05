<?php
// app/Services/OtpService.php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    private const OTP_EXPIRY_MINUTES = 5;
    private const OTP_LENGTH = 6;

    public function generate(User $user): OtpVerification
    {
        // আগের unused OTP গুলো invalidate করো
        OtpVerification::where('user_id', $user->id)
            ->where('is_used', false)
            ->delete();

        $otp = str_pad(random_int(0, 999999), self::OTP_LENGTH, '0', STR_PAD_LEFT);

        $otpRecord = OtpVerification::create([
            'user_id'    => $user->id,
            'otp'        => bcrypt($otp), // Hash করে store করো
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
        ]);

        $this->sendOtp($user, $otp);

        return $otpRecord;
    }

    public function verify(User $user, string $inputOtp): bool
    {
        $otpRecord = OtpVerification::where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (! $otpRecord || ! $otpRecord->isValid()) {
            return false;
        }

        if (! Hash::check($inputOtp, $otpRecord->otp)) {
            return false;
        }

        $otpRecord->update(['is_used' => true]);

        return true;
    }

    private function sendOtp(User $user, string $otp): void
    {
        Mail::send('email.otp', ['otp' => $otp, 'user' => $user], function ($mail) use ($user) {
            $mail->to($user->email)
                 ->subject('Your OTP Code - Todo App');
        });
    }
}