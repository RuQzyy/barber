<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - EL JAWAWI</title>
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

        .register-card {
            backdrop-filter: blur(15px);
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            width: 350px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .register-card h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 12px;
            border-radius: 30px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            border: none;
            background: #7c2d12;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #5c1f0d;
        }

        .extra-links {
            text-align: center;
            margin-top: 12px;
            font-size: 12px;
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

<div class="register-card">

    <h2>Sign Up</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <input id="name" type="text" name="name"
               value="{{ old('name') }}"
               placeholder="Full Name"
               required autofocus
               class="form-control">
        <x-input-error :messages="$errors->get('name')" class="text-red-400 text-sm mb-2" />

        <!-- Email -->
        <input id="email" type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Email"
               required
               class="form-control">
        <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mb-2" />

        <!-- Password -->
        <input id="password" type="password" name="password"
               placeholder="Password"
               required
               class="form-control">
        <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm mb-2" />

        <!-- Confirm Password -->
        <input id="password_confirmation" type="password"
               name="password_confirmation"
               placeholder="Confirm Password"
               required
               class="form-control">
        <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-400 text-sm mb-2" />

        <!-- Button -->
        <button type="submit" class="btn-register">
            REGISTER
        </button>

        <!-- Link -->
        <div class="extra-links">
            <a href="{{ route('login') }}">
                Already have an account? Login
            </a>
        </div>

    </form>

</div>

</body>
</html>
