@extends('admin.layout')

@section('content')

<div class="grid grid-cols-3 gap-6">

    <!-- LEFT -->
    <div class="col-span-2 space-y-6">

        <div class="grid grid-cols-2 gap-6">

            <div class="bg-white p-5 rounded-2xl shadow">
                <p class="text-sm text-gray-400">Hari ini</p>
                <h2 class="text-xl font-semibold">Senin</h2>

                <div class="flex items-center justify-between mt-4">
                    <div>
                        <p class="text-3xl font-bold">29°C</p>
                        <p class="text-xs text-gray-400">Cerah</p>
                    </div>

                    <div class="w-20 h-20 rounded-full border-8 border-green-400 flex items-center justify-center">
                        25%
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow">
                <p class="text-sm text-gray-400">Aktivitas</p>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span>Booking</span>
                        <span>12</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kursus</span>
                        <span>5</span>
                    </div>
                    <div class="flex justify-between">
                        <span>User Baru</span>
                        <span>8</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Statistik Booking</h3>

            <div class="h-64 flex items-end gap-3">
                <div class="bg-green-200 w-6 h-20 rounded"></div>
                <div class="bg-green-400 w-6 h-32 rounded"></div>
                <div class="bg-green-300 w-6 h-24 rounded"></div>
                <div class="bg-green-500 w-6 h-40 rounded"></div>
                <div class="bg-green-200 w-6 h-28 rounded"></div>
                <div class="bg-green-400 w-6 h-36 rounded"></div>
            </div>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="space-y-6">

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <img src="{{ asset('images/img_1.jpg') }}" class="w-full h-40 object-cover">
            <div class="p-4">
                <h3 class="font-semibold">Barber Activity</h3>
                <p class="text-sm text-gray-500">Monitoring aktivitas barber</p>
            </div>
        </div>

        <div class="bg-[#0f3d2e] text-white p-5 rounded-2xl">
            <h3 class="font-semibold mb-2">Barbershop Info</h3>
            <p class="text-sm opacity-80">
                Kelola booking, kursus, dan user dalam satu dashboard modern.
            </p>
            <button class="mt-4 bg-lime-400 text-black px-4 py-2 rounded-lg text-sm">
                Lihat Detail
            </button>
        </div>

    </div>

</div>

@endsection
