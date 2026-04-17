@extends('layouts.user')

@section('content')

<div class="bg-black text-white min-h-screen">

<!-- ================= HERO ================= -->
<div class="relative h-screen w-full">

    <!-- BACKGROUND -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('{{ asset('images/img_2.jpg') }}')"></div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- CONTENT HERO -->
    <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-4">

        <!-- LOGO -->
        <div class="mb-6">
            <img src="{{ asset('images/logo.jpeg') }}"
                 class="w-24 h-24 object-cover rounded-full border-2 border-yellow-500 shadow-lg">
        </div>

        <!-- TITLE -->
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-wide">
            EL JAWAWI BARBER
        </h1>

        <!-- DESC -->
        <p class="mt-4 max-w-xl text-gray-300 text-sm">
            Layanan potong rambut profesional sekaligus tempat kursus barber dengan sistem praktik langsung.
        </p>

        <!-- BUTTON -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('booking.create') }}"
               class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 text-sm uppercase tracking-widest text-black transition">
                Booking
            </a>

            <a href="#"
               class="border border-yellow-500 text-yellow-500 px-6 py-2 text-sm uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition">
                Daftar Kursus
            </a>
        </div>

    </div>

    <!-- FLOATING CARD -->
    <div class="absolute -bottom-16 left-0 w-full z-20 px-6">
        <div class="max-w-7xl mx-auto">

            <div class="grid md:grid-cols-4 gap-6">

                <div class="bg-gray-900/80 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition">
                    <p class="text-gray-400 text-sm">Status Booking</p>
                    <h3 class="font-bold mt-1">
                        {{ $bookingTerbaru->status ?? 'Belum Ada' }}
                    </h3>
                    @if($bookingTerbaru)
                    <button onclick="openDetailModal()"
                        class="mt-3 text-xs text-yellow-400 hover:underline">
                        Lihat Detail dan lakukan pembayaran →
                    </button>
                    @endif
                </div>

                <div class="bg-gray-900/80 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition">
                    <p class="text-gray-400 text-sm">Jadwal</p>
                    <h3 class="font-bold mt-1">
                        {{ $bookingTerbaru->tanggal ?? '-' }}
                    </h3>
                </div>

                <div class="bg-gray-900/80 backdrop-blur rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition">
                    <p class="text-gray-400 text-sm">Kursus</p>
                    <h3 class="font-bold mt-1">
                        {{ $kursusAktif ?? 'Belum Daftar' }}
                    </h3>
                </div>

                <!-- ANTRIAN -->
                <div class="bg-black border border-yellow-500 rounded-2xl shadow-xl p-5 text-center hover:-translate-y-2 transition">
                    <p class="text-gray-400 text-sm">Nomor Antrian</p>

                    <h1 class="text-3xl font-bold text-yellow-400 mt-1">
                        {{ $bookingTerbaru->nomor_antrian ?? '-' }}
                    </h1>

                    @if($antrianSekarang)
                    <p class="text-xs text-gray-400 mt-1">
                        Sedang diproses: #{{ $antrianSekarang->nomor_antrian }}
                    </p>
                    @endif

                    @if($posisiUser)
                    <p class="text-xs text-yellow-300 mt-1">
                        Posisi Anda: {{ $posisiUser }}
                    </p>
                    @endif

                    <span class="inline-block mt-2 bg-yellow-500 text-black px-3 py-1 rounded-full text-xs">
                        {{ $antrian->status ?? 'Tidak Ada' }}
                    </span>
                </div>



            </div>

        </div>
    </div>

</div>

<!-- ================= MODAL DETAIL BOOKING ================= -->
<div id="modalDetail"
     class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center px-4">

    <div
    class="bg-gray-900 text-white w-full max-w-md rounded-2xl shadow-xl relative
    max-h-[90vh] overflow-y-auto no-scrollbar p-6">

        <!-- CLOSE -->
        <button onclick="closeDetailModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-white text-lg">
            ✕
        </button>

        <h3 class="text-xl font-bold mb-6 text-center">
            Detail Booking
        </h3>

        @if($bookingTerbaru)

            <!-- ================= PAYMENT / QR ================= -->
            <div class="text-center mb-6">

                <!-- 🔥 INI PENTING (WRAPPER UNTUK UPDATE JS) -->
                <div id="paymentArea">

                    @if($bookingTerbaru->payment_status == 'pending')

                        <p class="text-sm text-yellow-400 mb-3">
                            Menunggu Pembayaran
                        </p>

                        <button onclick="bayar({{ $bookingTerbaru->id }})"
                            class="bg-yellow-500 hover:bg-yellow-600 text-black px-5 py-2 rounded-lg text-sm transition w-full">
                            Bayar Sekarang
                        </button>

                   @elseif($bookingTerbaru->payment_status == 'paid')

    <div class="text-center">

        <!-- TITLE -->
        <p class="text-sm font-semibold text-yellow-500 mb-1">
            QR Code Booking
        </p>

        <!-- DESKRIPSI -->
        <p class="text-xs text-gray-400 mb-3 leading-relaxed">
            Tunjukkan QR Code ini kepada kasir sebelum melakukan cukur.<br>
            QR ini akan digunakan untuk verifikasi booking Anda.
        </p>

        <!-- QR -->
        <div class="flex justify-center bg-white p-3 rounded-xl inline-block shadow-lg">
            {!! QrCode::size(160)->generate(url('/admin/scan/'.$bookingTerbaru->qr_code)) !!}
        </div>

        <!-- INFO TAMBAHAN -->
        <p class="text-[11px] text-gray-500 mt-3">
            Pastikan QR Code dapat dipindai dengan jelas
        </p>

        <!-- DOWNLOAD -->
        <a href="{{ url('/download-qr/'.$bookingTerbaru->id) }}"
           class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 text-xs rounded-lg transition">
            Download QR Code
        </a>

    </div>

@endif
                </div>

            </div>

            <!-- ================= DETAIL ================= -->
            <div class="space-y-4 text-sm">

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Layanan</span>
                    <span class="font-semibold">
                        {{ $bookingTerbaru->layananItem->nama ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Barber</span>
                    <span class="font-semibold">
                        {{ $bookingTerbaru->barber->nama ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Tanggal</span>
                    <span>
                        {{ $bookingTerbaru->tanggal ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Jam</span>
                    <span>{{ $bookingTerbaru->jam ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Antrian</span>
                    <span class="text-yellow-400 font-bold">
                        {{ $bookingTerbaru->nomor_antrian ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between border-b border-gray-700 pb-2">
                    <span class="text-gray-400">Status</span>
                    <span class="px-3 py-1 rounded-full text-xs
                        @if($bookingTerbaru->status == 'menunggu') bg-yellow-500 text-black
                        @elseif($bookingTerbaru->status == 'diproses') bg-blue-500 text-white
                        @elseif($bookingTerbaru->status == 'selesai') bg-green-500 text-white
                        @else bg-gray-500 text-white
                        @endif">
                        {{ ucfirst($bookingTerbaru->status) }}
                    </span>
                </div>

                <!-- 🔥 STATUS PEMBAYARAN -->
                <div class="flex justify-between">
                    <span class="text-gray-400">Pembayaran</span>

                    <span id="statusBayar"
                        class="px-3 py-1 rounded-full text-xs
                        @if($bookingTerbaru->payment_status == 'paid') bg-green-500 text-white
                        @else bg-yellow-500 text-black
                        @endif">
                        {{ $bookingTerbaru->payment_status }}
                    </span>
                </div>

            </div>

        @else

            <p class="text-center text-gray-400">
                Belum ada booking
            </p>

        @endif

    </div>

</div>

<!-- ================= ANTRIAN LIVE ================= -->
<div class="max-w-7xl mx-auto px-6 mt-24">

    <h3 class="text-xl font-bold mb-4 text-center">
        Antrian Hari Ini
    </h3>

    <div class="bg-gray-900 rounded-2xl p-6 shadow">

        <div id="antrianList" class="space-y-3">

           @foreach($antrianHariIni as $a)
<div class="flex items-center justify-between p-4 rounded-xl border border-gray-800
    @if($a->status == 'diproses')
        bg-yellow-500 text-black
    @elseif($a->status == 'menunggu')
        bg-gray-900
    @else
        bg-green-500 text-white
    @endif

    @if($a->user_id == auth()->id())
        ring-2 ring-yellow-400
    @endif
">

    <!-- LEFT -->
    <div class="flex items-center gap-4">

        <!-- NOMOR -->
        <div class="text-2xl font-bold w-14">
            #{{ str_pad($a->nomor_antrian, 2, '0', STR_PAD_LEFT) }}
        </div>

        <!-- INFO -->
        <div>
            <p class="font-semibold text-sm">
                {{ $a->layananItem->nama ?? '-' }}
            </p>

            <p class="text-xs text-gray-400">
                {{ $a->barber->nama ?? '-' }}
            </p>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="text-right">

        <!-- JAM -->
        <p class="text-sm font-semibold">
            {{ substr($a->jam,0,5) }}
        </p>

        <!-- STATUS -->
        <span class="text-xs px-2 py-1 rounded-full
            @if($a->status == 'diproses')
                bg-black text-yellow-400
            @elseif($a->status == 'menunggu')
                bg-gray-700 text-white
            @else
                bg-white text-green-600
            @endif
        ">
            {{ strtoupper($a->status) }}
        </span>

    </div>

</div>
@endforeach

@if($antrianHariIni->isEmpty())
    <p class="text-center text-gray-400 text-sm">
        Belum ada antrian hari ini
    </p>
@endif

        </div>

    </div>

</div>

<!-- SPACING -->
<div class="mt-32"></div>


<!-- ================= PRICE LIST ================= -->
<div class="relative py-20">

    <!-- BACKGROUND -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('{{ asset('images/hasil2.jpeg') }}')"></div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/90"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6">

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
            <div>

                <div class="flex items-center justify-between">
                    <h4 class="uppercase text-sm font-semibold">
                        {{ $item->nama }}
                    </h4>

                    <div class="flex-1 border-b border-dotted border-gray-600 mx-4"></div>

                    <span class="text-yellow-400 font-semibold text-sm">
                        Rp {{ number_format((int)$item->value,0,',','.') }}
                    </span>
                </div>

                <p class="text-gray-400 text-xs mt-1">
                    Layanan profesional dengan hasil maksimal
                </p>

                <a href="{{ route('booking.create', ['layanan' => $item->id]) }}"
                   class="inline-block mt-3 border border-yellow-500 text-yellow-500 px-4 py-1 text-xs uppercase hover:bg-yellow-500 hover:text-black transition">
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
<div class="bg-gradient-to-br from-black via-gray-900 to-black py-20">

    <div class="max-w-7xl mx-auto px-6">

        <h3 class="font-bold text-2xl mb-10 text-center">
            Paket Kursus Barber
        </h3>

        <div class="grid md:grid-cols-3 gap-8">

            @foreach ($kursus as $item)
            <div class="relative bg-gray-900 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition
                {{ $item->is_rekomendasi ? 'ring-2 ring-yellow-400' : '' }}">

                <!-- BADGE FIX -->
                @if ($item->is_rekomendasi)
                <div class="absolute top-3 left-3 bg-yellow-500 text-black text-xs px-3 py-1 rounded-full font-semibold z-10 shadow">
                    Rekomendasi
                </div>
                @endif

                <!-- IMAGE -->
                <div class="h-52 overflow-hidden">
                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/img_1.jpg') }}"
                         class="w-full h-full object-cover hover:scale-110 transition duration-500">
                </div>

                <!-- CONTENT -->
                <div class="p-6 text-center">

                    <h4 class="font-bold text-lg tracking-wide">
                        {{ strtoupper($item->nama_kursus) }}
                    </h4>

                    <p class="text-yellow-400 font-semibold mt-2">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    <ul class="mt-4 text-sm text-gray-300 space-y-2">
                        <li class="font-semibold">
                            {{ $item->jumlah_pertemuan }} Pertemuan
                        </li>
                    </ul>

                    <a href="#"
                       class="inline-block mt-6 bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-2 rounded-full text-sm transition">
                        Daftar
                    </a>

                </div>

            </div>
            @endforeach

        </div>

    </div>

</div>

</div>

<script>
function openDetailModal() {
    document.getElementById('modalDetail').classList.remove('hidden');
    document.getElementById('modalDetail').classList.add('flex');
}

function bayar(bookingId) {

    fetch('/user/payment/' + bookingId)
        .then(res => res.json())
        .then(data => {

            if (!data.snap_token) {
                alert("Snap token tidak ditemukan");
                return;
            }

            snap.pay(data.snap_token, {

                onSuccess: function(result){

                    // 🔥 tampil loading dulu
                    document.getElementById('paymentArea').innerHTML = `
                        <p class="text-yellow-400">Memproses pembayaran...</p>
                    `;

                    // 🔥 update status ke server
                    fetch('/user/payment/update/' + bookingId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(() => {

                        // 🔥 update badge status
                        const status = document.getElementById('statusBayar');
                        if (status) {
                            status.innerText = 'paid';
                            status.className = 'px-3 py-1 rounded-full text-xs bg-green-500 text-white';
                        }

                        // 🔥 tampil QR langsung TANPA reload
                        document.getElementById('paymentArea').innerHTML = `
                            <p class="text-xs text-gray-400 mb-2">
                                QR Booking
                            </p>

                            <div class="flex justify-center bg-white p-3 rounded-xl inline-block">
                                <img src="/download-qr/${bookingId}" class="w-40">
                            </div>

                            <a href="/download-qr/${bookingId}"
                               class="block mt-3 bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 text-xs rounded-lg transition">
                               Download QR Code
                            </a>
                        `;

                    });

                },

                onPending: function(result){
                    alert("Menunggu pembayaran");
                },

                onError: function(result){
                    alert("Pembayaran gagal");
                }

            });

        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan");
        });

}

function closeDetailModal() {
    document.getElementById('modalDetail').classList.add('hidden');
    document.getElementById('modalDetail').classList.remove('flex');
}

setInterval(() => {
    fetch('/api/antrian')
        .then(res => res.json())
        .then(data => {

            let html = '';

            data.forEach(a => {

                let bg = 'bg-gray-900';
                let badge = 'bg-gray-700 text-white';

                if (a.status === 'diproses') {
                    bg = 'bg-yellow-500 text-black';
                    badge = 'bg-black text-yellow-400';
                }

                let highlight = '';
                if (a.user_id == {{ auth()->id() }}) {
                    highlight = 'ring-2 ring-yellow-400';
                }

                html += `
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-800 ${bg} ${highlight}">

                    <div class="flex items-center gap-4">
                        <div class="text-2xl font-bold w-14">
                            #${String(a.nomor_antrian).padStart(2,'0')}
                        </div>

                        <div>
                            <p class="font-semibold text-sm">
                                ${a.layanan_item?.nama ?? '-'}
                            </p>

                            <p class="text-xs text-gray-400">
                                ${a.barber?.nama ?? '-'}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-sm font-semibold">
                            ${a.jam ? a.jam.substring(0,5) : '-'}
                        </p>

                        <span class="text-xs px-2 py-1 rounded-full ${badge}">
                            ${a.status.toUpperCase()}
                        </span>
                    </div>

                </div>
                `;
            });

            document.getElementById('antrianList').innerHTML = html;

        });

}, 5000);

document.addEventListener('DOMContentLoaded', function () {

    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');

    if (openModal) {
        openDetailModal();
    }

});
</script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.clientKey') }}">
</script>





@endsection
