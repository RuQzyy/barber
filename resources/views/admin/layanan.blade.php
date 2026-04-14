@extends('admin.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Layanan</h1>
        <p class="text-sm text-gray-500">Barbershop, Kursus & Fasilitas</p>
    </div>

    <button onclick="openModal()"
        class="bg-[#0f3d2e] text-white px-4 py-2 rounded-lg text-sm">
        + Tambah
    </button>
</div>

<div class="grid md:grid-cols-3 gap-6">
@foreach($layanans as $layanan)
<div class="bg-white rounded-xl shadow">

    <div class="bg-[#0f3d2e] text-white px-4 py-3">
        {{ $layanan->judul }}
    </div>

    <div class="p-4 space-y-2">
        @forelse($layanan->items as $item)
        <div class="flex justify-between text-sm">
            <span>{{ $item->nama }}</span>
            <span>{{ $item->value_formatted }}</span>
        </div>
        @empty
        <span class="text-gray-400 text-sm">Kosong</span>
        @endforelse
    </div>

    <div class="flex justify-between px-4 pb-3 text-xs">
        <button onclick='editData(@json($layanan))' class="text-blue-600">Edit</button>
        <button onclick="hapusData({{ $layanan->id }})" class="text-red-600">Hapus</button>
    </div>

</div>
@endforeach
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div class="bg-white w-full max-w-md p-6 rounded-xl">

        <form id="formLayanan" method="POST">
            @csrf
            <input type="hidden" name="_method" id="method">

            <select name="kategori" id="kategori" onchange="handleKategori()"
                class="w-full border mb-3 px-3 py-2">
                <option value="">Kategori</option>
                <option value="barbershop">Barbershop</option>
                <option value="kursus">Kursus</option>
                <option value="fasilitas">Fasilitas</option>
            </select>

            <input type="text" name="judul" id="judul"
                class="w-full border mb-3 px-3 py-2" placeholder="Judul">

            <div id="itemsWrapper"></div>

            <button type="button" onclick="addItem()"
                class="text-green-600 text-sm mb-3">
                + Item
            </button>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()">Batal</button>
                <button class="bg-[#0f3d2e] text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>

    </div>
</div>

<script>

let itemIndex = 0;

function openModal(){
    modal.classList.remove('hidden')
    modal.classList.add('flex')

    formLayanan.reset()
    formLayanan.action = "{{ route('admin.layanan.store') }}"
    method.value = ''

    itemsWrapper.innerHTML = ''
    itemIndex = 0
    addItem()
}

function closeModal(){
    modal.classList.add('hidden')
}

function handleKategori(){
    itemsWrapper.innerHTML = ''
    itemIndex = 0
    addItem()
}

function addItem(nama='', value=''){
    let kategori = document.getElementById('kategori').value

    let inputValue = kategori === 'barbershop'
        ? `<input type="text" name="items[${itemIndex}][value]" value="${value}"
           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
           class="w-1/2 border px-2 py-1">`
        : `<input type="text" name="items[${itemIndex}][value]" value="${value}"
           class="w-1/2 border px-2 py-1">`

    let div = document.createElement('div')
    div.className = "flex gap-2 mb-2"

    div.innerHTML = `
        <input type="text" name="items[${itemIndex}][nama]" value="${nama}"
            class="w-1/2 border px-2 py-1">

        ${inputValue}

        <button onclick="this.parentElement.remove()" type="button">x</button>
    `

    itemsWrapper.appendChild(div)
    itemIndex++
}

function editData(data){
    openModal()

    formLayanan.action = '/admin/layanan/'+data.id
    method.value = 'PUT'

    kategori.value = data.kategori
    judul.value = data.judul

    itemsWrapper.innerHTML = ''
    itemIndex = 0

    data.items.forEach(item=>{
        addItem(item.nama, item.value)
    })
}

function hapusData(id){
    if(confirm('Hapus data?')){
        let form = document.createElement('form')
        form.method='POST'
        form.action='/admin/layanan/'+id
        form.innerHTML = `
            <input name="_token" value="{{ csrf_token() }}">
            <input name="_method" value="DELETE">
        `
        document.body.appendChild(form)
        form.submit()
    }
}

</script>

@endsection
