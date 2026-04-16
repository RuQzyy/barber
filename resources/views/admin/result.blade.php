@extends('admin.layout')

@section('content')

<div class="bg-white rounded-2xl shadow p-6 max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-6 text-center">
        Hasil Scan QR
    </h2>

    <div class="space-y-4 text-sm">

        <div class="flex justify-between border-b pb-2">
            <span>Nama</span>
            <span class="font-semibold">{{ $booking->user->name }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Layanan</span>
            <span>{{ $booking->layananItem->nama }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Barber</span>
            <span>{{ $booking->barber->nama }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Tanggal</span>
            <span>{{ $booking->tanggal }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Jam</span>
            <span>{{ $booking->jam }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Antrian</span>
            <span class="text-yellow-500 font-bold">
                {{ $booking->nomor_antrian }}
            </span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span>Status</span>

            <span class="px-3 py-1 rounded-full text-xs
                @if($booking->status=='menunggu') bg-yellow-400 text-black
                @elseif($booking->status=='diproses') bg-blue-500 text-white
                @elseif($booking->status=='selesai') bg-green-500 text-white
                @endif">
                {{ ucfirst($booking->status) }}
            </span>
        </div>

    </div>

    <!-- BUTTON AKSI -->
    <div class="mt-6">

        <form method="POST" action="/admin/booking/{{ $booking->id }}/status">
            @csrf

            <input type="hidden" name="status" value="diproses">

            <button
                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-semibold">
                Mulai Cukur
            </button>
        </form>

    </div>

</div>

@endsection
