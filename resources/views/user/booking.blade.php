@extends('layouts.user')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black text-white">

    <div class="max-w-7xl mx-auto px-6 py-24">

        <!-- TITLE -->
        <div class="text-center mb-14">
            <h2 class="text-4xl font-bold tracking-wide">
                Booking Layanan
            </h2>
            <p class="text-gray-400 text-sm mt-2">
                Pilih layanan terbaik dan booking sekarang
            </p>
        </div>

        <!-- LIST LAYANAN -->
        <div class="grid md:grid-cols-3 gap-8">

            @foreach($layanans as $item)
            <div
                class="relative h-72 rounded-2xl overflow-hidden group shadow-lg cursor-pointer transform hover:scale-105 transition duration-500"
                style="background-image: url('/images/img_2.jpg'); background-size: cover; background-position: center;"
            >

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/60 group-hover:bg-black/40 transition duration-300"></div>

                <!-- CONTENT -->
                <div class="absolute bottom-0 p-6 text-white z-10">

                    <!-- ICON -->
                    <div class="w-10 h-10 bg-yellow-500 text-black flex items-center justify-center rounded-full mb-3 text-sm font-bold">
                        B
                    </div>

                    <!-- TITLE -->
                    <h3 class="text-lg font-bold tracking-wide uppercase">
                        {{ $item->nama }}
                    </h3>

                    <!-- DESC -->
                    <p class="text-sm text-gray-300 mt-2">
                        Layanan profesional dengan hasil maksimal untuk penampilan terbaik Anda.
                    </p>

                    <!-- HARGA -->
                    <p class="text-yellow-400 mt-2 font-semibold">
                        @if(is_numeric($item->value))
                            Rp {{ number_format($item->value,0,',','.') }}
                        @else
                            {{ $item->value }}
                        @endif
                    </p>

                    <!-- BUTTON -->
                    <button
                        onclick="openModal({{ $item->id }}, '{{ $item->nama }}')"
                        class="mt-4 px-4 py-2 bg-yellow-500 text-black text-xs uppercase tracking-widest rounded hover:bg-yellow-400 transition"
                    >
                        Booking
                    </button>

                </div>

            </div>
            @endforeach

        </div>

    </div>
</div>

<!-- ================= BARBER LIST (DISPLAY ONLY) ================= -->
<div class="max-w-7xl mx-auto px-6 pb-24">

    <div class="text-center mb-12">
        <h3 class="text-3xl font-bold tracking-wide">
            Tukang Cukur Kami
        </h3>
        <p class="text-gray-400 text-sm mt-2">
            Tim barber profesional dengan pengalaman terbaik
        </p>
    </div>

    <div class="bg-gradient-to-br from-black via-gray-900 to-black py-24">

    <div class="max-w-7xl mx-auto px-6">

        <!-- TITLE -->
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold tracking-wide text-white">
                Tukang Cukur Kami
            </h3>
            <p class="text-gray-400 text-sm mt-2">
                Tim barber profesional dengan pengalaman terbaik
            </p>
        </div>

      <div class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto">

    @foreach($barbers as $barber)
    <div class="w-64 relative bg-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 group hover:-translate-y-2">

        <!-- FOTO -->
        <div class="h-56 overflow-hidden relative">
            <img src="{{ $barber->foto ? asset('storage/'.$barber->foto) : asset('images/img_1.jpg') }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition"></div>
        </div>

        <!-- CONTENT -->
        <div class="p-5 text-center">
            <h4 class="font-bold text-lg tracking-wide text-white">
                {{ $barber->nama }}
            </h4>

            <p class="text-yellow-400 text-sm mt-1 font-medium">
                {{ $barber->spesialis ?? 'Barber Profesional' }}
            </p>

            <p class="text-gray-400 text-xs mt-2">
                Berpengalaman & siap memberikan hasil terbaik untuk gaya rambut Anda.
            </p>
        </div>

    </div>
    @endforeach

</div>

    </div>

</div>

</div>


<!-- ================= MODAL ================= -->
<div id="modal" class="fixed inset-0 bg-black/70 hidden z-50 overflow-y-auto">

    <div id="modalContent"
     class="bg-gray-900 text-white w-full max-w-md rounded-2xl shadow-xl p-6 relative mx-auto my-10 max-h-[90vh] overflow-y-auto
     transform scale-95 opacity-0 transition duration-300">

        <!-- CLOSE -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-white">
            ✕
        </button>

        <h3 class="text-xl font-bold mb-4 text-center">
            Form Booking
        </h3>

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <!-- LAYANAN -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Layanan</label>
                <input type="text" id="nama_layanan"
                    class="w-full border border-gray-700 bg-gray-800 text-white rounded-lg px-3 py-2 mt-1"
                    disabled>

                <input type="hidden" name="layanan_item_id" id="layanan_id">
            </div>

            <!-- BARBER -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Pilih Barber</label>
                <select name="barber_id"
                    class="w-full border border-gray-700 bg-gray-800 text-white rounded-lg px-3 py-2 mt-1" required>
                    <option value="">-- Pilih Barber --</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}">
                            {{ $barber->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TANGGAL -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Tanggal</label>
                <input type="date" name="tanggal"
                    class="w-full border border-gray-700 bg-gray-800 text-white rounded-lg px-3 py-2 mt-1"
                    required>
            </div>

            <!-- JAM -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Jam</label>
                <div class="mb-4">
                    <label class="text-sm font-semibold">Pilih Jam</label>

                    <div id="jamWrapper" class="grid grid-cols-3 gap-2 mt-2">
                        <!-- SLOT JAM AKAN DIISI JS -->
                    </div>

                    <input type="hidden" name="jam" id="jamInput" required>
                </div>
            </div>

            <!-- BUTTON -->
            <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-black py-2 rounded-lg mt-4 font-semibold">
                Konfirmasi Booking
            </button>

        </form>

    </div>

</div>


<!-- ================= SCRIPT ================= -->
<script>
const existingBookings = @json($bookings ?? []);
function generateJam() {

    const wrapper = document.getElementById('jamWrapper');
    wrapper.innerHTML = '';

    const selectedTanggal = document.querySelector('input[name="tanggal"]').value;
    const barberId = document.querySelector('select[name="barber_id"]').value;

    if (!selectedTanggal || !barberId) return;

    let start = 10;
    let end = 20;

    let slots = [];

    for (let h = start; h < end; h++) {
        slots.push(`${h.toString().padStart(2,'0')}:00`);
        slots.push(`${h.toString().padStart(2,'0')}:30`);
    }

    slots.forEach(jam => {

        let disabled = false;

        existingBookings.forEach(b => {

            if (b.tanggal === selectedTanggal && b.barber_id == barberId) {

                let booked = b.jam.substring(0,5);

                let selisih = Math.abs(toMinutes(jam) - toMinutes(booked));

                // 🔥 BLOK JIKA KURANG DARI 30 MENIT
                if (selisih < 30) {
                    disabled = true;
                }
            }

        });

        let btn = document.createElement('button');
        btn.type = 'button';
        btn.innerText = jam;

        btn.className = `
            py-2 rounded-lg text-sm transition
            ${disabled
                ? 'bg-gray-700 text-gray-500 cursor-not-allowed'
                : 'bg-gray-800 hover:bg-yellow-500 hover:text-black'}
        `;

        if (!disabled) {
            btn.onclick = () => {

                document.getElementById('jamInput').value = jam;

                document.querySelectorAll('#jamWrapper button').forEach(b => {
                    b.classList.remove('bg-yellow-500','text-black');
                    b.classList.add('bg-gray-800');
                });

                btn.classList.add('bg-yellow-500','text-black');
            };
        } else {
            // 🔥 biar benar-benar tidak bisa diklik
            btn.disabled = true;
        }

        wrapper.appendChild(btn);
    });
}

// helper
function toMinutes(time) {
    let [h, m] = time.split(':').map(Number);
    return h * 60 + m;
}

function openModal(id, nama) {
    const modal = document.getElementById('modal');
    const content = document.getElementById('modalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // delay kecil biar animasi jalan
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.getElementById('layanan_id').value = id;
    document.getElementById('nama_layanan').value = nama;
}

function closeModal() {
    const modal = document.getElementById('modal');
    const content = document.getElementById('modalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}


// AUTO OPEN JIKA DARI DASHBOARD
document.addEventListener('DOMContentLoaded', function () {

    const urlParams = new URLSearchParams(window.location.search);
    const layananId = urlParams.get('layanan');

    if (layananId) {

        let layanan = @json($layanans);

        let selected = layanan.find(item => item.id == layananId);

        if (selected) {
            openModal(selected.id, selected.nama);
        }
    }

});
document.querySelector('input[name="tanggal"]').addEventListener('change', generateJam);
document.querySelector('select[name="barber_id"]').addEventListener('change', generateJam);

</script>


@endsection
