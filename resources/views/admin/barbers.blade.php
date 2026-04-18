@extends('admin.layout')

@section('content')

<div class="bg-white rounded-2xl shadow p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Data Barber</h2>

        <button onclick="openModal()"
            class="bg-[#0f3d2e] hover:bg-[#0c2f24] text-white px-4 py-2 rounded-lg text-sm shadow">
            + Tambah Barber
        </button>
    </div>

    <!-- LIST -->
    <div class="grid md:grid-cols-4 gap-6">

        @foreach($barbers as $item)
        <div class="bg-white border rounded-2xl p-4 shadow-sm hover:shadow-lg transition">

            <!-- FOTO -->
            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/150' }}"
                class="w-full h-40 object-cover rounded-xl mb-4">

            <!-- NAMA -->
            <h4 class="font-semibold text-gray-800 text-center">
                {{ $item->nama }}
            </h4>

            <!-- NO HP -->
            <p class="text-xs text-gray-500 text-center mt-1">
                {{ $item->no_hp ?? '-' }}
            </p>

            <!-- STATUS -->
            <div class="flex justify-center mt-2">
                @if($item->is_mentor)
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                        Mentor
                    </span>
                @else
                    <span class="text-xs bg-gray-200 text-gray-600 px-3 py-1 rounded-full">
                        Barber
                    </span>
                @endif
            </div>

            <!-- ACTION -->
            <div class="flex flex-col gap-2 mt-4">

                <!-- CHAT WA -->
                @if($item->no_hp)
                <a href="https://wa.me/{{ $item->no_hp }}?text=Halo {{ $item->nama }}, saya dari admin ingin menghubungi Anda"
                    target="_blank"
                    class="text-center bg-green-500 hover:bg-green-600 text-white py-1.5 rounded-lg text-xs">
                    Chat WhatsApp
                </a>
                @endif

                <div class="flex gap-2">

                    <!-- EDIT -->
                    <button onclick="editBarber(
                        {{ $item->id }},
                        '{{ $item->nama }}',
                        '{{ $item->no_hp }}',
                        {{ $item->is_mentor ? 'true' : 'false' }}
                    )"
                        class="w-1/2 bg-blue-500 hover:bg-blue-600 text-white py-1.5 rounded-lg text-xs">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <form action="{{ route('admin.barbers.destroy',$item->id) }}" method="POST" class="w-1/2">
                        @csrf
                        @method('DELETE')

                        <button class="w-full bg-red-500 hover:bg-red-600 text-white py-1.5 rounded-lg text-xs">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

        </div>
        @endforeach

    </div>
</div>

<!-- ================= MODAL ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center">

    <div class="bg-white p-6 rounded-2xl w-96 shadow-xl">

        <h3 class="font-semibold mb-4 text-gray-800">Form Barber</h3>

        <form id="formBarber" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" id="method" name="_method">

            <!-- NAMA -->
            <input type="text" name="nama" id="nama"
                class="w-full border px-3 py-2 mb-3 rounded-lg text-sm"
                placeholder="Nama">

            <!-- NO HP -->
            <input type="text" name="no_hp" id="no_hp"
                class="w-full border px-3 py-2 mb-3 rounded-lg text-sm"
                placeholder="Nomor WhatsApp (628xxx)">

            <!-- FOTO -->
            <input type="file" name="foto" class="w-full mb-3 text-sm">

            <!-- MENTOR -->
            <label class="flex items-center gap-2 mb-4 text-sm text-gray-700">
                <input type="checkbox" name="is_mentor" id="is_mentor" value="1">
                Jadikan sebagai Mentor
            </label>

            <!-- BUTTON -->
            <button class="w-full bg-[#0f3d2e] hover:bg-[#0c2f24] text-white py-2 rounded-lg text-sm">
                Simpan
            </button>
        </form>

        <button onclick="closeModal()" class="mt-3 text-sm text-gray-500">
            Tutup
        </button>

    </div>

</div>

<script>

// ================= OPEN =================
function openModal() {

    modal.classList.remove('hidden');

    formBarber.action = "/admin/barbers";
    method.value = "";

    nama.value = "";
    no_hp.value = "";
    is_mentor.checked = false;
}

// ================= CLOSE =================
function closeModal() {
    modal.classList.add('hidden');
}

// ================= EDIT =================
function editBarber(id, namaVal, hpVal, mentorVal) {

    openModal();

    formBarber.action = "/admin/barbers/" + id;
    method.value = "PUT";

    nama.value = namaVal;
    no_hp.value = hpVal ?? '';
    is_mentor.checked = mentorVal;
}

</script>

@endsection
