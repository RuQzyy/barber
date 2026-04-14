<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User - EL Jawawi Barber</title>

    @vite('resources/css/app.css')

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<!-- ================= NAVBAR ================= -->
<nav id="navbar"
     class="fixed top-0 left-0 w-full z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">

        <!-- LOGO -->
        <a href="#" class="text-white font-bold text-xl tracking-widest">
            EL JAWAWI<span class="text-yellow-500">.</span>
        </a>

        <!-- MENU -->
        <div class="hidden md:flex items-center gap-10 text-xs uppercase tracking-[2px]">

            <a href="#" class="text-yellow-500">Home</a>
            <a href="#" class="text-white hover:text-yellow-500">Booking</a>
            <a href="#" class="text-white hover:text-yellow-500">Kursus</a>

        </div>

        <div class="hidden md:flex items-center gap-4 text-white">

    <span class="text-sm opacity-70">
        {{ auth()->user()->name }}
    </span>

    <form method="POST" action="/logout">
        @csrf
        <button
            class="border border-yellow-500 text-yellow-500 px-4 py-1 text-xs uppercase tracking-widest hover:bg-yellow-500 hover:text-white transition">
            Logout
        </button>
    </form>

</div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="pt-0">
    @yield('content')
</div>


<!-- ================= SCRIPT ================= -->
<script>
    const navbar = document.getElementById("navbar");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            navbar.classList.add("bg-black/80", "backdrop-blur-md", "shadow-lg");
        } else {
            navbar.classList.remove("bg-black/80", "backdrop-blur-md", "shadow-lg");
        }
    });
</script>

</body>
</html>
