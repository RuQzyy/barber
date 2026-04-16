@extends('admin.layout')

@section('content')

<div class="bg-white rounded-2xl shadow p-6">

    <h2 class="text-xl font-semibold mb-4">Data Booking</h2>

    <!-- FILTER -->
    <form method="GET" class="mb-4 flex gap-3">
        <input type="date" name="tanggal"
            class="border px-3 py-2 rounded-lg text-sm">

        <button class="bg-[#0f3d2e] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#145c44] transition">
            Filter
        </button>
    </form>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Layanan</th>
                    <th class="p-3">Barber</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Jam</th>
                    <th class="p-3">Antrian</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($bookings as $item)
                <tr class="border-b">

                    <td class="p-3">{{ $item->user->name }}</td>
                    <td class="p-3">{{ $item->layananItem->nama }}</td>
                    <td class="p-3">{{ $item->barber->nama }}</td>
                    <td class="p-3">{{ $item->tanggal }}</td>
                    <td class="p-3">{{ $item->jam }}</td>

                    <td class="p-3 font-semibold text-yellow-500">
                        {{ $item->nomor_antrian }}
                    </td>

                    <td class="p-3">
                        <form method="POST" action="/admin/booking/{{ $item->id }}/status">
                            @csrf

                            <select name="status"
                                onchange="this.form.submit()"
                                class="px-2 py-1 rounded-lg text-xs
                                @if($item->status=='menunggu') bg-yellow-400 text-black
                                @elseif($item->status=='diproses') bg-blue-500 text-white
                                @elseif($item->status=='selesai') bg-green-500 text-white
                                @endif">

                                <option value="menunggu" {{ $item->status=='menunggu'?'selected':'' }}>Menunggu</option>
                                <option value="diproses" {{ $item->status=='diproses'?'selected':'' }}>Diproses</option>
                                <option value="selesai" {{ $item->status=='selesai'?'selected':'' }}>Selesai</option>

                            </select>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>


<!-- ================= SCAN SECTION ================= -->
<div class="bg-white rounded-2xl shadow p-6 mt-6 flex items-center justify-between">

    <div>
        <h2 class="text-lg font-semibold">Scan QR Booking</h2>
        <p class="text-sm text-gray-500">Gunakan kamera atau upload gambar QR</p>
    </div>

    <button onclick="openScanModal()"
        class="bg-[#0f3d2e] text-white px-5 py-2 rounded-lg text-sm hover:bg-[#145c44] transition">
        Scan QR
    </button>

</div>


<!-- ================= MODAL ================= -->
<div id="scanModal"
    class="fixed inset-0 bg-black/0 hidden z-50 flex items-center justify-center transition duration-300">

    <div id="scanContent"
        class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative
        transform scale-95 opacity-0 transition duration-300">

        <!-- CLOSE -->
        <button onclick="closeScanModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-black">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-4 text-center">
            Scan QR Booking
        </h3>

        <!-- MODE -->
        <div class="grid grid-cols-2 gap-2 mb-4">
            <button onclick="startScanner()"
                class="bg-[#0f3d2e] text-white py-2 rounded-lg text-sm">
                Kamera
            </button>

            <button onclick="document.getElementById('qrFile').click()"
                class="border border-gray-300 py-2 rounded-lg text-sm">
                Upload
            </button>
        </div>

        <!-- CAMERA -->
        <div id="reader" class="hidden rounded-lg overflow-hidden border"></div>

        <!-- FILE -->
        <input type="file" id="qrFile" accept="image/*" class="hidden">

    </div>
</div>


<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let scanner;

// OPEN MODAL
function openScanModal() {
    const modal = document.getElementById('scanModal');
    const content = document.getElementById('scanContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('bg-black/50');
        content.classList.remove('scale-95','opacity-0');
        content.classList.add('scale-100','opacity-100');
    }, 10);
}

// CLOSE MODAL
function closeScanModal() {
    const modal = document.getElementById('scanModal');
    const content = document.getElementById('scanContent');

    content.classList.remove('scale-100','opacity-100');
    content.classList.add('scale-95','opacity-0');
    modal.classList.remove('bg-black/50');

    setTimeout(() => {
        modal.classList.add('hidden');

        if (scanner) {
            scanner.stop().catch(()=>{});
            scanner = null;
        }

        document.getElementById('reader').classList.add('hidden');
        document.getElementById('scanInfo').classList.add('hidden');

    }, 200);
}

// START CAMERA
function startScanner() {

    const reader = document.getElementById('reader');
    reader.classList.remove('hidden');

    if (scanner) return;

    scanner = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {

        if (!devices.length) {
            alert("Kamera tidak ditemukan");
            return;
        }

        let cameraId = devices[0].id; // kamera depan

        scanner.start(
            cameraId,
            {
                fps: 20, // 🔥 lebih cepat

                // 🔥 PERBESAR AREA SCAN (INI KUNCI)
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                    let size = Math.floor(minEdge * 0.8); // 80% layar
                    return { width: size, height: size };
                },

                aspectRatio: 1.0,

                // 🔥 WAJIB
                disableFlip: false,

                // 🔥 bantu deteksi QR
                formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],

                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                }
            },

            (decodedText) => {
                console.log("BERHASIL:", decodedText);

                scanner.stop().then(() => {
                    window.location.href = decodedText;
                });
            },

            (errorMessage) => {
                // biarkan kosong (jangan spam log)
            }
        );

    }).catch(err => {
        console.error(err);
        alert("Kamera tidak dapat diakses");
    });
}

// UPLOAD QR
document.getElementById('qrFile').addEventListener('change', function(e){

    const file = e.target.files[0];
    if (!file) return;

    const html5QrCode = new Html5Qrcode("reader");

    html5QrCode.scanFile(file, true)
        .then(decodedText => {
            window.location.href = decodedText;
        })
        .catch(() => {
            alert("QR tidak terbaca");
        });

});
</script>

@endsection
