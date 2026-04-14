@extends('admin.layout')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Galeri</h1>
        <p class="text-sm text-gray-500">Kelola foto kegiatan & hasil barber</p>
    </div>

    <button onclick="openModal()"
        class="bg-[#0f3d2e] hover:bg-[#145c44] text-white px-5 py-2 rounded-lg text-sm shadow">
        + Tambah Foto
    </button>
</div>

<!-- EMPTY -->
@if($galeri->isEmpty())
<div class="bg-white p-10 rounded-xl text-center text-gray-400 shadow">
    Belum ada data galeri
</div>
@endif

<!-- GRID -->
<div class="grid md:grid-cols-3 gap-8">

    @foreach($galeri as $item)
    <div class="group">

        <!-- IMAGE -->
        <div class="overflow-hidden rounded-xl shadow">
            <img src="{{ asset('storage/'.$item->gambar) }}"
                class="w-full h-56 object-cover transition duration-300 group-hover:scale-105">
        </div>

        <!-- CONTENT -->
        <div class="mt-4">
            <h3 class="font-semibold text-lg text-gray-800">
                {{ $item->judul }}
            </h3>

            <p class="text-sm text-gray-500 mt-1 leading-relaxed whitespace-pre-line">
                {{ Str::limit($item->deskripsi, 80) }}
            </p>

            <!-- ACTION -->
            <div class="flex gap-4 mt-3 text-sm">
                <button onclick='editData(@json($item))'
                    class="text-blue-600 hover:underline">
                    Edit
                </button>

                <button onclick="hapusData({{ $item->id }})"
                    class="text-red-500 hover:underline">
                    Hapus
                </button>
            </div>
        </div>

    </div>
    @endforeach

</div>

<!-- MODAL -->
<div id="modal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div id="modalBox"
        class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 scale-90 opacity-0 transition-all duration-300">

        <h2 class="text-lg font-semibold mb-4">Form Galeri</h2>

        <form id="formGaleri" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="method">

            <input type="text" name="judul" id="judul"
                placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 mb-3 text-sm">

            <textarea name="deskripsi" id="deskripsi"
                placeholder="Deskripsi"
                class="w-full border rounded-lg px-3 py-2 mb-3 text-sm"></textarea>

            <!-- DROP -->
            <div id="dropArea"
                class="border-2 border-dashed rounded-lg p-5 text-center text-sm text-gray-500 mb-3 cursor-pointer">
                Drag & Drop atau klik upload
                <input type="file" name="gambar" id="gambar" class="hidden">
            </div>

            <img id="preview"
                class="hidden w-full h-40 object-cover rounded mb-3">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm">
                    Batal
                </button>

                <button class="px-4 py-2 bg-[#0f3d2e] text-white rounded-lg text-sm">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ================= MODAL =================
function openModal() {
    const modal = document.getElementById('modal');
    const box = document.getElementById('modalBox');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        box.classList.remove('scale-90','opacity-0');
        box.classList.add('scale-100','opacity-100');
    }, 10);

    document.getElementById('formGaleri').reset();
    document.getElementById('formGaleri').action = "{{ route('admin.galeri.store') }}";
    document.getElementById('method').value = '';
}

// CLOSE
function closeModal() {
    const modal = document.getElementById('modal');
    const box = document.getElementById('modalBox');

    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-90','opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

// EDIT
function editData(data) {
    openModal();

    document.getElementById('formGaleri').action = '/admin/galeri/' + data.id;
    document.getElementById('method').value = 'PUT';

    document.getElementById('judul').value = data.judul;
    document.getElementById('deskripsi').value = data.deskripsi ?? '';
}

// DELETE
function hapusData(id) {
    Swal.fire({
        title: 'Hapus data?',
        text: 'Tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/galeri/' + id;

            form.innerHTML = `
                <input name="_token" value="{{ csrf_token() }}">
                <input name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();
        }
    });
}

// LOADING
document.getElementById('formGaleri').addEventListener('submit', function() {
    Swal.fire({
        title: 'Menyimpan...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
});

// PREVIEW
document.getElementById('gambar').addEventListener('change', function(e){
    let file = e.target.files[0];
    let reader = new FileReader();

    reader.onload = function(){
        let preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.classList.remove('hidden');
    }

    reader.readAsDataURL(file);
});

// DRAG DROP
let dropArea = document.getElementById('dropArea');
let inputFile = document.getElementById('gambar');

dropArea.addEventListener('click', () => inputFile.click());

dropArea.addEventListener('dragover', e => {
    e.preventDefault();
    dropArea.classList.add('bg-gray-100');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('bg-gray-100');
});

dropArea.addEventListener('drop', e => {
    e.preventDefault();
    inputFile.files = e.dataTransfer.files;
    inputFile.dispatchEvent(new Event('change'));
});

</script>

@endsection
