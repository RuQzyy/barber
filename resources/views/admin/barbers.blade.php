@extends('admin.layout')

@section('content')

<div class="bg-white rounded-2xl shadow p-6">

    <h2 class="text-xl font-semibold mb-4">Data Barber</h2>

    <!-- BUTTON TAMBAH -->
    <button onclick="openModal()"
        class="mb-4 bg-[#0f3d2e] text-white px-4 py-2 rounded-lg text-sm">
        + Tambah Barber
    </button>

    <!-- LIST -->
    <div class="grid md:grid-cols-4 gap-6">

        @foreach($barbers as $item)
        <div class="bg-gray-100 rounded-xl p-4 text-center">

            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/150' }}"
                 class="w-full h-40 object-cover rounded-lg mb-3">

            <h4 class="font-semibold">{{ $item->nama }}</h4>

            <div class="flex justify-center gap-2 mt-3">

                <button onclick="editBarber({{ $item->id }}, '{{ $item->nama }}')"
                    class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                    Edit
                </button>

                <form action="{{ route('admin.barbers.destroy',$item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                        Hapus
                    </button>
                </form>

            </div>
        </div>
        @endforeach

    </div>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center">

    <div class="bg-white p-6 rounded-xl w-96">

        <h3 class="font-semibold mb-4">Form Barber</h3>

        <form id="formBarber" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" id="method" name="_method">

            <input type="text" name="nama" id="nama"
                class="w-full border px-3 py-2 mb-3 rounded" placeholder="Nama">

            <input type="file" name="foto" class="w-full mb-3">

            <button class="w-full bg-green-500 text-white py-2 rounded">
                Simpan
            </button>
        </form>

        <button onclick="closeModal()" class="mt-3 text-sm text-gray-500">
            Tutup
        </button>

    </div>

</div>

<script>

function openModal() {
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('formBarber').action = "/admin/barbers";
    document.getElementById('method').value = "";
    document.getElementById('nama').value = "";
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function editBarber(id, nama) {

    openModal();

    document.getElementById('formBarber').action = "/admin/barbers/" + id;
    document.getElementById('method').value = "PUT";
    document.getElementById('nama').value = nama;
}

</script>

@endsection
