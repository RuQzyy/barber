<!DOCTYPE html>
<html lang="en">

<style>
#reader {
    position: relative;
}

/* kotak guide */
#reader::after {
    content: "";
    position: absolute;
    inset: 25%;
    border: 3px solid white;
    border-radius: 10px;
    pointer-events: none;
}
</style>

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')

</head>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="bg-[#f4f6f9]">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#0f3d2e] text-white flex flex-col justify-between">

            <div>
                <!-- LOGO -->
                <div class="p-6 flex items-center gap-3 border-b border-white/10">
                    <img src="{{ asset('images/logo.jpeg') }}" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-sm">EL JAWAWI</p>
                        <p class="text-xs opacity-70">Admin Panel</p>
                    </div>
                </div>

                <!-- MENU -->
                <nav class="px-4 space-y-2 text-sm">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.booking') }}"
   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
    Booking
</a>

                    <a href="{{ route('admin.layanan.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        Layanan
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        Barber
                    </a>

                    <a href="{{ route('admin.kursus.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        Kursus
                    </a>

                    <a href="{{ route('admin.galeri.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        Galeri
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#1c5c45]">
                        User
                    </a>

                </nav>
            </div>

            <!-- BOTTOM -->
            <div class="p-4">


                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 transition text-white py-2 rounded-lg text-sm font-semibold shadow">

                        <!-- ICON -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7" />
                        </svg>

                        Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 p-6 overflow-y-auto">

            <!-- TOPBAR -->
            <div class="flex justify-between items-center mb-6">

                <input type="text" placeholder="Search..."
                    class="bg-white px-4 py-2 rounded-full w-1/3 shadow text-sm">

                <div class="flex items-center gap-3">
                    <img
                        src="{{ asset('images/logo.jpeg') }}"class="w-10 h-10 rounded-full object-cover border-2 border-white shadow">
                    <div>
                        <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">Barbershop</p>
                    </div>
                </div>

            </div>

            <!-- CONTENT DINAMIS -->
            @yield('content')

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                </script>
            @endif

        </div>

    </div>

</body>

</html>
