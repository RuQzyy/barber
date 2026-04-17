@extends('admin.layout')

@section('content')

<div class="space-y-8">

    <h2 class="text-2xl font-bold text-gray-800">
        Manajemen Jadwal Barber
    </h2>

    @foreach($barbers as $barber)

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-700">
                {{ $barber->nama }}
            </h3>

            <span class="text-xs bg-gray-100 px-3 py-1 rounded-full text-gray-500">
                Jadwal Mingguan
            </span>
        </div>

        @php
        $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];
        @endphp

        <!-- ================= TABLE ================= -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm border rounded-xl overflow-hidden">

                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">Hari</th>
                        <th class="p-3">Jam Mulai</th>
                        <th class="p-3">Jam Selesai</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($hariList as $hari)

                    @php
                    $jadwal = $barber->jadwal->firstWhere('hari', $hari);
                    @endphp

                    <tr class="border-t hover:bg-gray-50 transition">

                        <form action="{{ route('admin.jadwal.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="barber_id" value="{{ $barber->id }}">
                            <input type="hidden" name="hari" value="{{ $hari }}">

                            <!-- HARI -->
                            <td class="p-3 font-medium capitalize text-gray-700">
                                {{ $hari }}
                            </td>

                            <!-- JAM MULAI -->
                            <td class="p-2 text-center">
                                <input type="time"
                                    name="jam_mulai"
                                    value="{{ $jadwal->jam_mulai ?? '' }}"
                                    class="border rounded-lg px-2 py-1 text-sm w-28 focus:ring-2 focus:ring-green-500">
                            </td>

                            <!-- JAM SELESAI -->
                            <td class="p-2 text-center">
                                <input type="time"
                                    name="jam_selesai"
                                    value="{{ $jadwal->jam_selesai ?? '' }}"
                                    class="border rounded-lg px-2 py-1 text-sm w-28 focus:ring-2 focus:ring-green-500">
                            </td>

                            <!-- STATUS -->
                            <td class="p-2 text-center">
                                <label class="flex items-center justify-center gap-2">

                                    <input type="checkbox"
                                        name="libur"
                                        class="toggle-libur"
                                        {{ isset($jadwal) && $jadwal->libur ? 'checked' : '' }}>

                                    <span class="text-xs px-2 py-1 rounded-full
                                        {{ isset($jadwal) && $jadwal->libur ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ isset($jadwal) && $jadwal->libur ? 'Libur' : 'Aktif' }}
                                    </span>

                                </label>
                            </td>

                            <!-- BUTTON -->
                            <td class="p-2 text-center">
                                <button
                                    class="bg-[#0f3d2e] text-white px-3 py-1 rounded-lg text-xs hover:bg-[#145c44] transition">
                                    Simpan
                                </button>
                            </td>

                        </form>

                    </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

        <!-- ================= LIBUR KHUSUS ================= -->
        <div class="mt-8">

            <h4 class="font-semibold text-gray-700 mb-3">
                Hari Libur Khusus
            </h4>

            <!-- FORM -->
            <form action="{{ route('admin.jadwal.libur') }}" method="POST" class="flex gap-3 mb-4">
                @csrf

                <input type="hidden" name="barber_id" value="{{ $barber->id }}">

                <input type="date" name="tanggal"
                    class="border rounded-lg px-3 py-2 text-sm w-40">

                <input type="text" name="keterangan"
                    placeholder="Keterangan"
                    class="border rounded-lg px-3 py-2 text-sm flex-1">

                <button class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600">
                    Tambah
                </button>

            </form>

            <!-- TABLE LIBUR -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm border">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Keterangan</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($barber->libur as $l)
                        <tr class="border-t text-center">
                            <td class="p-2">{{ $l->tanggal }}</td>
                            <td class="p-2">{{ $l->keterangan ?? '-' }}</td>
                            <td class="p-2">

                                <form action="{{ route('admin.jadwal.libur.delete', $l->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-500 text-xs hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 p-3">
                                Tidak ada hari libur
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>

    @endforeach

</div>

@endsection
