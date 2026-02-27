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
    margin-bottom: 25px;
}

.form-floating {
    margin-bottom: 18px;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    border-color: #667eea;
}

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

.position-absolute {
    font-size: 18px;
    color: #888;
}

.position-absolute:hover {
    color: #333;
}
</style>
@endsection
@section("content") <main class="form-signin w-100 m-auto">
    <form method="POST" action="{{ route('login.post')}}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating"> <input name="email" type=" email" class="form-control" id="floatingInput"
                placeholder="name@example.com"> <label for="floatingInput">Email address</label>
            @error("email")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-floating" style="margin-bottom: 10px"> <input name="password" type="password"
                class="form-control" id="floatingPassword" placeholder="Password"> <label
                for="floatingPassword">Password</label>

            <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor:pointer;"
                onclick="togglePassword()">
                👁
            </span>


            @error("password")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-check text-start my-3"> <input class="form-check-input" type="checkbox" name="remember" value="
                remember-me" id="checkDefault"> <label class="form-check-label" for="checkDefault">
                Remember me
            </label> </div>
        @if(session()->has("success"))
        <div class="alert alert-success">
            {{ session()->get("success") }}
        </div>
        @endif

        @if(session()->has("error"))
        <div class="alert alert-danger">
            {{ session("error") }}
        </div>
        @endif
        <a href="{{ route('forget.password') }}" class="text-decoration-none">Forget Password?</a>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        <a href="{{ route('register') }}" class="text-center">Create New Account</a>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2026</p>
    </form>
</main>
@endsection
@section("script")
<script>
function togglePassword() {
    const passwordField = document.getElementById("floatingPassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>

@endsection