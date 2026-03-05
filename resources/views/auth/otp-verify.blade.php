@extends("layouts.auth")

@section("style")
<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    font-family: 'Segoe UI', sans-serif;
}

.form-signin {
    width: 100%;
    max-width: 420px;
    padding: 40px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transition: 0.3s ease;
}

.form-signin:hover {
    transform: translateY(-3px);
}

.form-signin h1 {
    font-weight: 600;
    text-align: center;
    margin-bottom: 8px;
}

.form-signin .subtitle {
    text-align: center;
    color: #888;
    font-size: 14px;
    margin-bottom: 28px;
}

/* ── OTP Boxes ── */
.otp-wrapper {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 24px;
}

.otp-box {
    width: 52px;
    height: 56px;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    border: 1.5px solid #dee2e6;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    color: #2c5364;
}

.otp-box:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.otp-box.filled {
    border-color: #2c5364;
    background: #f0f4ff;
}

/* ── Timer ── */
.otp-timer {
    text-align: center;
    font-size: 13px;
    color: #888;
    margin-bottom: 18px;
}

.otp-timer span {
    font-weight: 600;
    color: #2c5364;
}

.otp-timer span.expired {
    color: #dc3545;
}

/* ── Buttons ── */
.btn-primary {
    background: linear-gradient(135deg, #2c5364, #203a43);
    border: none;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.btn-primary:disabled {
    opacity: 0.55;
    transform: none;
    cursor: not-allowed;
}

.btn-resend {
    background: none;
    border: none;
    color: #667eea;
    font-weight: 500;
    font-size: 14px;
    padding: 0;
    cursor: pointer;
    display: block;
    margin: 0 auto;
    transition: 0.2s;
}

.btn-resend:hover:not(:disabled) {
    text-decoration: underline;
}

.btn-resend:disabled {
    color: #aaa;
    cursor: not-allowed;
}

a {
    display: block;
    text-align: center;
    margin-top: 12px;
    color: #667eea;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

.alert {
    font-size: 14px;
    padding: 8px 12px;
    border-radius: 6px;
}

/* ── Success flash ── */
.otp-icon {
    text-align: center;
    font-size: 40px;
    margin-bottom: 10px;
}
</style>
@endsection

@section("content")
<main class="form-signin w-100 m-auto">

    <form method="POST" action="{{ route('otp.verify') }}" id="otp-form">
        @csrf

        <div class="otp-icon">🔐</div>
        <h1 class="h3 mb-1 fw-normal">OTP Verification</h1>
        <p class="subtitle">Otp Code Send to your email, Please Check you email.</p>

        {{-- Alerts --}}
        @if(session()->has('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
        @endif

        @if(session()->has('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        {{-- 6 OTP input boxes --}}
        <div class="otp-wrapper">
            @for($i = 0; $i < 6; $i++) <input type="text" inputmode="numeric" maxlength="1" class="otp-box"
                data-index="{{ $i }}" autocomplete="off">
                @endfor
        </div>


        <input type="hidden" name="otp" id="otp-hidden">


        <p class="otp-timer">
            মেয়াদ শেষ হবে: <span id="countdown">05:00</span>
        </p>

        <button class="btn btn-primary w-100 py-2 mb-3" type="submit" id="verify-btn">
            Verify OTP
        </button>
    </form>


    <form method="POST" action="{{ route('otp.resend') }}" id="resend-form">
        @csrf
        <button type="submit" class="btn-resend" id="resend-btn" disabled>
            OTP পাইনি? Send Again
        </button>
    </form>

    <a href="{{ route('login') }}" class="text-decoration-none mt-3">← Back to Login page</a>

    <p class="mt-4 mb-0 text-body-secondary text-center" style="font-size:13px;">&copy; 2026</p>
</main>
@endsection

@section("script")
<script>
document.addEventListener('DOMContentLoaded', function() {

            // OTP Box Logic 
            const boxes = document.querySelectorAll('.otp-box');
            const hiddenInput = document.getElementById('otp-hidden');
            const verifyBtn = document.getElementById('verify-btn');

            function syncHidden() {
                hiddenInput.value = [...boxes].map(b => b.value).join('');
            }

            boxes.forEach((box, index) => {

                // sudhu number nibe
                box.addEventListener('input', (e) => {
                    box.value = box.value.replace(/\D/g, '').slice(-1);
                    box.classList.toggle('filled', box.value !== '');
                    syncHidden();
                    if (box.value && index < boxes.length - 1) {
                        boxes[index + 1].focus();
                    }
                });

                // Backspace e ager box e jabe
                box.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !box.value && index > 0) {
                        boxes[index - 1].focus();
                        boxes[index - 1].value = '';
                        boxes[index - 1].classList.remove('filled');
                        syncHidden();
                    }

                    // Paste korle sob gula box e fill kore debe
                    box.addEventListener('paste', (e) => {
                        e.preventDefault();
                        const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(
                            0, 6);
                        [...pasted].forEach((char, i) => {
                            if (boxes[i]) {
                                boxes[i].value = char;
                                boxes[i].classList.add('filled');
                            }
                        });
                        syncHidden();
                        const next = Math.min(pasted.length, 5);
                        boxes[next].focus();
                    });
                });

                boxes[0].focus();


                const countdownEl = document.getElementById('countdown');
                const resendBtn = document.getElementById('resend-btn');
                let totalSeconds = 5 * 60;

                const timer = setInterval(() => {
                    totalSeconds--;

                    const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
                    const secs = String(totalSeconds % 60).padStart(2, '0');
                    countdownEl.textContent = `${mins}:${secs}`;

                    if (totalSeconds <= 0) {
                        clearInterval(timer);
                        countdownEl.textContent = 'Expired';
                        countdownEl.classList.add('expired');
                        verifyBtn.disabled = true;
                        resendBtn.disabled = false;
                    }
                }, 1000);

                // ── Form Submit Validation ─────────────────────────
                document.getElementById('otp-form').addEventListener('submit', function(e) {
                    syncHidden();
                    if (hiddenInput.value.length !== 6) {
                        e.preventDefault();
                        alert('৬ সংখ্যার OTP দিন।');
                        boxes[0].focus();
                    }
                });
            });
</script>
@endsection