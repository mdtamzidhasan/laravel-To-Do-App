@extends("layouts.auth")

@section("style")
<style>
html,
body {
    height: 100%;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    align-items: center;
    justify-content: center;
}

.reset-wrapper {
    width: 100%;
    max-width: 420px;
    padding: 30px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.reset-wrapper h3 {
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
}

.form-floating input {
    border-radius: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #2c5364, #203a43);
    border-radius: 8px;
    padding: 10px;
    font-weight: 500;
    transition: 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
}

.footer-text {
    font-size: 14px;
    text-align: center;
    margin-top: 15px;
}
</style>
@endsection


@section('content')
<div class="reset-wrapper">

    <h3>Reset Your Password</h3>

    @if(session()->has("success"))
    <div class="alert alert-success">
        {{ session("success") }}
    </div>
    @endif
    @if(session()->has("error"))
    <div class="alert alert-danger">
        {{ session("error") }}
    </div>
    @endif
    <form method="POST" action="{{ route('reset.password.post') }}">
        @csrf
        <input type="text" name="token" hidden value="{{ $token }}">
        <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required>
            <label for="floatingInput">Email address</label>

            @error("email")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>


        <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                id="floatingInput" placeholder="name@example.com" value="{{ old('password') }}" required>
            <label for="floatingInput">Enter new Password</label>

            @error("password")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>


        <div class="form-floating mb-3">
            <input name="password_confirmation" type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror" id="floatingInput"
                placeholder="name@example.com" value="{{ old('password_confirmation') }}" required>
            <label for="floatingInput">Confirm New Password</label>

            @error("password_confirmation")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">
            Submit
        </button>
    </form>

    <div class="footer-text">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>

</div>
@endsection