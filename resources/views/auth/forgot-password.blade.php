<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - EL JAWAWI</title>
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

        .forgot-card {
            backdrop-filter: blur(15px);
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            width: 350px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .forgot-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .forgot-card p {
            font-size: 13px;
            color: #ddd;
            text-align: center;
            margin-bottom: 20px;
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

        .btn-submit {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            border: none;
            background: #7c2d12;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #5c1f0d;
        }

        .extra-links {
            text-align: center;
            margin-top: 15px;
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

<div class="forgot-card">

    <h2>Reset Password</h2>

    <p>
        Masukkan email kamu, nanti kami kirim link untuk reset password.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-3 text-green-400 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <input id="email" type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Email"
               required autofocus
               class="form-control">

        <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mb-2" />

        <!-- Button -->
        <button type="submit" class="btn-submit">
            Kirim Link Reset
        </button>

        <!-- Back -->
        <div class="extra-links">
            <a href="{{ route('login') }}">
                Kembali ke Login
            </a>
        </div>

    </form>

</div>

</body>
</html>
