@extends('admin.layout')

@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Laporan Pendapatan</h1>

        <a href="{{ route('admin.laporan.export', ['start_date'=>$start,'end_date'=>$end]) }}"
            class="bg-green-500 text-white px-4 py-2 rounded text-sm">
            Download Excel
        </a>
    </div>

    <!-- FILTER -->
    <form class="flex gap-2 mb-6">
        <input type="date" name="start_date" value="{{ $start }}"
            class="border px-3 py-2 rounded">

        <input type="date" name="end_date" value="{{ $end }}"
            class="border px-3 py-2 rounded">

        <button class="bg-blue-500 text-white px-4 rounded">
            Filter
        </button>
    </form>

    <!-- SUMMARY -->
    <div class="grid md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Booking</p>
            <h2 class="text-lg font-bold">
                Rp {{ number_format($totalBooking,0,',','.') }}
            </h2>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Kursus</p>
            <h2 class="text-lg font-bold">
                Rp {{ number_format($totalKursus,0,',','.') }}
            </h2>
        </div>

        <div class="bg-green-500 text-white p-4 rounded shadow">
            <p class="text-sm">Total</p>
            <h2 class="text-lg font-bold">
                Rp {{ number_format($totalSemua,0,',','.') }}
            </h2>
        </div>

    </div>

    <!-- DETAIL -->
    <div class="bg-white rounded shadow p-4">

        <h2 class="font-semibold mb-3">Detail Kursus</h2>

        <table class="w-full text-sm">
            <tr class="bg-gray-100">
                <th class="p-2">Nama</th>
                <th>Kursus</th>
                <th>Harga</th>
            </tr>

            @foreach($kursus as $k)
            <tr class="border-b">
                <td class="p-2">{{ $k->nama_peserta }}</td>
                <td>{{ $k->kursus->nama_kursus ?? '-' }}</td>
                <td>Rp {{ number_format($k->kursus->harga ?? 0,0,',','.') }}</td>
            </tr>
            @endforeach
        </table>

    </div>

</div>

@endsection
