<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - EL JAWAWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            background: url('/images/hero_2.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            backdrop-filter: blur(15px);
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            width: 350px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 30px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            border: none;
            background: #7c2d12;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #5c1f0d;
        }

        .extra-links {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 10px;
        }

        .extra-links a {
            color: #ddd;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">

    <h2>Welcome</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-3 text-green-400" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <input id="email" type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Email"
               required autofocus
               class="form-control">

        <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mb-2" />

        <!-- Password -->
        <input id="password" type="password" name="password"
               placeholder="Password"
               required
               class="form-control">

        <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm mb-2" />

        <!-- Remember -->
        <div class="flex items-center mb-3 text-sm">
            <input id="remember_me" type="checkbox" name="remember" class="mr-2">
            <label for="remember_me">Remember me</label>
        </div>

        <!-- Button -->
        <button type="submit" class="btn-login">
            LOGIN
        </button>

        <!-- Links -->
        <div class="extra-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            @endif

            <a href="{{ route('register') }}">
                Sign Up
            </a>
        </div>

    </form>

</div>

</body>
</html>
