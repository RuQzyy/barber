<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User - EL Jawawi Barber</title>

    @vite('resources/css/app.css')

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* 🔥 Hilangkan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE & Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

    <style>
        /* SCROLL MODAL */
        #modalContent::-webkit-scrollbar {
            width: 6px;
        }

        #modalContent::-webkit-scrollbar-track {
            background: transparent;
        }

        #modalContent::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        #modalContent::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Firefox */
        #modalContent {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }
    </style>


</head>

<!-- 🔥 FULL DARK DISINI -->

<body class="bg-black text-white">

    <!-- ================= NAVBAR ================= -->
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300">

        <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">

            <!-- LOGO -->
            <a href="#" class="text-white font-bold text-xl tracking-widest">
                EL JAWAWI<span class="text-yellow-500">.</span>
            </a>

            <!-- MENU -->
            <div class="hidden md:flex items-center gap-10 text-xs uppercase tracking-[2px]">

                <a href="{{ route('user.dashboard') }}"
                    class="{{ request()->routeIs('user.dashboard') ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-500' }}">
                    Home
                </a>

                <a href="{{ route('booking.create') }}"
                    class="{{ request()->routeIs('booking.*') ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-500' }}">
                    Booking
                </a>

                 <a href="{{ route('user.kursus.index') }}"
                    class="{{ request()->routeIs('kursus.*') ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-500' }}">
                    Kursus
                </a>

            </div>

            <!-- USER -->
            <div class="hidden md:flex items-center gap-4">

                <span class="text-sm text-gray-400">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button
                        class="border border-yellow-500 text-yellow-500 px-4 py-1 text-xs uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </nav>

    <!-- ================= CONTENT ================= -->
    <div class="min-h-screen">
        @yield('content')
    </div>

    <!-- ================= SCRIPT ================= -->
    <script>
        const navbar = document.getElementById("navbar");

        window.addEventListener("scroll", function() {
            if (window.scrollY > 50) {
                navbar.classList.add("bg-black/80", "backdrop-blur-md", "shadow-lg");
            } else {
                navbar.classList.remove("bg-black/80", "backdrop-blur-md", "shadow-lg");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#eab308',
                background: '#111827',
                color: '#fff'
            });
        </script>
    @endif

</body>

</html>
