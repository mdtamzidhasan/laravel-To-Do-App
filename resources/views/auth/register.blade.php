@extends("layouts.auth")
@section("style")
<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-signin {
    width: 100%;
    max-width: 420px;
    padding: 40px 35px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    animation: fadeIn 0.6s ease-in-out;
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
    border-radius: 10px;
    height: 50px;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #2c5364;
    box-shadow: 0 0 0 0.2rem rgba(44, 83, 100, 0.2);
}

.btn-primary {
    background: linear-gradient(135deg, #2c5364, #203a43);
    border: none;
    border-radius: 10px;
    height: 50px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.text-danger {
    font-size: 13px;
}

a {
    display: block;
    margin-top: 15px;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
}

a:hover {
    text-decoration: underline;
}

.alert {
    border-radius: 10px;
    font-size: 14px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
@section("content") <main class="form-signin w-100 m-auto">
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Create Your Account</h1>
        <div class="form-floating"> <input name="name" type="text" class="form-control" id="floatingInput"
                placeholder="Enter full name" value="{{ old('name') }}"> <label for="floatingInput">Full Name</label>
            @error("name")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating"> <input name="email" type="email" class="form-control" id="floatingInput"
                placeholder="name@example.com" value="{{ old('email') }}"> <label for="floatingInput">Email
                address</label>
            @error("email")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating" style="margin-bottom: 10px"> <input name="password" type="password"
                class="form-control" id="floatingPassword" placeholder="Password"><label
                for="floatingPassword">Password</label>
            @error("password")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating" style="margin-bottom: 10px"> <input name="password_confirmation" type="password"
                class="form-control" id="floatingPassword" placeholder="Password"><label for="floatingPassword">
                Confirm Password</label>
            @error("password_confirmation")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
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

        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
        <a href="{{ route('login') }}" class="text-center">Already have an account? Login</a>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2026</p>
    </form>
</main>
@endsection