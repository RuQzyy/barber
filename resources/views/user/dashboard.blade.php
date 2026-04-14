@extends('layouts.user')

@section('content')

<!-- ================= HERO ================= -->
<div class="relative h-screen w-full">

    <!-- BACKGROUND -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('{{ asset('images/img_2.jpg') }}')"></div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- CONTENT HERO -->
    <div class="relative z-10 h-full flex flex-col justify-center items-center text-center text-white px-4">

        <!-- LOGO -->
        <div class="mb-6">
            <img src="{{ asset('images/logo.jpeg') }}"
                 class="w-24 h-24 object-cover rounded-full border-2 border-white shadow-lg">
        </div>

        <!-- TITLE -->
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-wide">
            EL JAWAWI BARBER
        </h1>

        <!-- DESC -->
        <p class="mt-4 max-w-xl text-gray-300 text-sm">
            Layanan potong rambut profesional sekaligus tempat kursus barber dengan sistem praktik langsung untuk pemula hingga mahir.
        </p>

        <!-- BUTTON -->
        <div class="mt-6 flex gap-4">
            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 text-sm uppercase tracking-widest transition">
                Booking
            </a>

            <a href="#" class="border border-white px-6 py-2 text-sm uppercase tracking-widest hover:bg-white hover:text-black transition">
                Daftar Kursus
            </a>
        </div>

    </div>

    <!-- FLOATING CARD (OVERLAP HERO) -->
    <div class="absolute -bottom-16 left-0 w-full z-20 px-6">

        <div class="max-w-7xl mx-auto">

            <div class="grid md:grid-cols-4 gap-6">

                <!-- STATUS -->
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition duration-300">
                    <p class="text-gray-500 text-sm">Status Booking</p>
                    <h3 class="font-bold mt-1">
                        {{ $bookingTerbaru->status ?? 'Belum Ada' }}
                    </h3>
                </div>

                <!-- JADWAL -->
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition duration-300">
                    <p class="text-gray-500 text-sm">Jadwal</p>
                    <h3 class="font-bold mt-1">
                        {{ $bookingTerbaru->tanggal ?? '-' }}
                    </h3>
                </div>

                <!-- KURSUS -->
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition duration-300">
                    <p class="text-gray-500 text-sm">Kursus</p>
                    <h3 class="font-bold mt-1">
                        {{ $kursusAktif ?? 'Belum Daftar' }}
                    </h3>
                </div>

                <!-- ANTRIAN -->
                <div class="bg-black text-white rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition duration-300">
                    <p class="text-gray-400 text-sm">Nomor Antrian</p>

                    <h1 class="text-3xl font-bold text-yellow-400 mt-1">
                        {{ $antrian->nomor_antrian ?? '-' }}
                    </h1>

                    <span class="inline-block mt-2 bg-yellow-400 text-black px-3 py-1 rounded-full text-xs">
                        {{ $antrian->status ?? 'Tidak Ada' }}
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- ================= SPACING AGAR TIDAK KETUTUP ================= -->
<div class="mt-32"></div>


<!-- ================= PRICE LIST ================= -->
<div class="relative py-20">

    <!-- BACKGROUND -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('{{ asset('images/hasil2.jpeg') }}')"></div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/80"></div>

    <!-- CONTENT -->
    <div class="relative z-10 max-w-6xl mx-auto px-6 text-white">

        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold tracking-wide">
                PRICE LIST
            </h2>
            <p class="text-gray-400 text-sm mt-2">
                Layanan terbaik dengan kualitas premium
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-10">

            @forelse($layanans as $item)
            <div class="mb-6">

                <div class="flex items-center justify-between">
                    <h4 class="uppercase tracking-wider text-sm font-semibold">
                        {{ $item->nama }}
                    </h4>

                    <div class="flex-1 border-b border-dotted border-gray-500 mx-4"></div>

                    <span class="text-yellow-500 font-semibold text-sm">
                        @if(is_numeric($item->value))
                            Rp {{ number_format($item->value,0,',','.') }}
                        @else
                            {{ $item->value }}
                        @endif
                    </span>
                </div>

                <p class="text-gray-400 text-xs mt-1">
                    Layanan profesional dengan hasil maksimal
                </p>

                <a href="#"
                   class="inline-block mt-3 border border-yellow-500 text-yellow-500 px-4 py-1 text-xs uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition">
                    Booking
                </a>

            </div>
            @empty
            <p class="text-gray-400">Belum ada layanan</p>
            @endforelse

        </div>

    </div>

</div>


<!-- ================= KURSUS ================= -->
<div class="max-w-7xl mx-auto px-6 py-20">

    <h3 class="font-bold text-2xl mb-8">Paket Kursus Barber</h3>

    <div class="grid md:grid-cols-3 gap-6">

        @forelse($kursus as $item)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">

            <div class="h-48 overflow-hidden">
                <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('images/img_1.jpg') }}"
                     class="w-full h-full object-cover hover:scale-110 transition duration-500">
            </div>

            <div class="p-5 text-center">

                @if($item->is_rekomendasi)
                    <span class="inline-block bg-yellow-400 text-black text-xs px-3 py-1 rounded-full mb-2">
                        ⭐ Rekomendasi
                    </span>
                @endif

                <h4 class="font-bold text-lg">{{ $item->nama_kursus }}</h4>

                <p class="text-green-600 font-semibold mt-1">
                    Rp {{ number_format($item->harga,0,',','.') }}
                </p>

                <p class="text-gray-500 text-sm mt-1">
                    {{ $item->jumlah_pertemuan }} Pertemuan
                </p>

                <p class="text-gray-500 text-sm mt-2">
                    {!! Str::limit($item->deskripsi, 80) !!}
                </p>

                <a href="#"
                   class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-full text-sm transition">
                    Daftar
                </a>

            </div>

        </div>
        @empty
        <p class="text-gray-500">Belum ada kursus</p>
        @endforelse

    </div>

</div>

@endsection
