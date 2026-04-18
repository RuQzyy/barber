@extends('admin.layout')

@section('content')
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Kursus</h1>
            <p class="text-sm text-gray-500">Kelola data kursus barber</p>
        </div>

        <button onclick="openModal()" class="bg-[#0f3d2e] hover:bg-[#145c44] text-white px-4 py-2 rounded-lg text-sm shadow">
            + Tambah Kursus
        </button>
    </div>

    <!-- SEARCH -->
    <div class="mb-4">
        <input type="text" id="search" placeholder="Cari kursus..."
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-green-400">
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-center">Harga</th>
                    <th class="px-6 py-3 text-center">Pertemuan</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach ($kursus as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $item->nama_kursus }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->jumlah_pertemuan }}x</td>
                        <td class="text-center">
                            @if ($item->is_rekomendasi)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Rekomendasi</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-full text-xs">Biasa</span>
                            @endif
                        </td>
                        <td class="text-right px-6 space-x-2">
                            <button onclick='editData(@json($item))'
                                class="text-blue-600 text-xs">Edit</button>

                            <button onclick="hapusData({{ $item->id }})" class="text-red-500 hover:underline">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4 text-center text-sm text-gray-500">
        (Pagination nanti bisa pakai Laravel paginate)
    </div>

    <div class="mt-10 bg-white rounded-2xl shadow overflow-hidden">

    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold">Peserta Kursus</h2>
        <p class="text-sm text-gray-500">Data semua pendaftar kursus</p>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">No HP</th>
                <th class="px-4 py-3 text-left">Kursus</th>
                <th class="px-4 py-3 text-center">Kelas</th>
                <th class="px-4 py-3 text-center">Mentor</th>
                <th class="px-4 py-3 text-center">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($peserta as $p)
                <tr class="border-b hover:bg-gray-50">

                    <!-- NAMA -->
                    <td class="px-4 py-3 font-medium">
                        {{ $p->nama_peserta }}
                    </td>

                    <!-- NO HP -->
                    <td class="px-4 py-3 text-gray-600">
                        {{ $p->no_hp }}
                    </td>

                    <!-- KURSUS -->
                    <td class="px-4 py-3">
                        {{ $p->kursus->nama_kursus ?? '-' }}
                    </td>

                    <!-- TIPE -->
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $p->tipe_kelas == 'private' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($p->tipe_kelas) }}
                        </span>
                    </td>

                    <!-- MENTOR -->
                    <td class="px-4 py-3 text-center">
                        {{ $p->mentor->nama ?? '-' }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-4 py-3 text-center">
                        @if ($p->payment_status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Pending
                            </span>
                        @elseif($p->payment_status == 'paid')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Paid
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">
                                Unknown
                            </span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">
                        Belum ada peserta
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 transition">

        <div id="modalBox"
            class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 scale-90 opacity-0 transition-all duration-300">

            <h2 class="text-lg font-semibold mb-4">Form Kursus</h2>

            <form id="formKursus" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="method">

                <!-- NAMA -->
                <input type="text" name="nama_kursus" id="nama_kursus" placeholder="Nama Kursus"
                    class="w-full border rounded-lg px-3 py-2 mb-3 text-sm">

                <!-- HARGA -->
                <input type="text" id="harga_view" placeholder="Rp 0"
                    class="w-full border rounded-lg px-3 py-2 mb-3 text-sm">
                <input type="hidden" name="harga" id="harga">

                <!-- PERTEMUAN -->
                <input type="number" name="jumlah_pertemuan" id="jumlah_pertemuan" placeholder="Jumlah Pertemuan"
                    class="w-full border rounded-lg px-3 py-2 mb-3 text-sm">

                <!-- DESKRIPSI -->
                <textarea name="deskripsi" id="deskripsi" class="w-full border rounded-lg px-3 py-2 mb-3 text-sm"
                    placeholder="Deskripsi"></textarea>

                <textarea name="materi" id="materi"
                class="w-full border rounded-lg px-3 py-2 mb-3 text-sm"
                placeholder="Materi (pisahkan dengan enter)
                Contoh:
                - Pengenalan alat
                - Teknik dasar
                - Praktek langsung"></textarea>

                <input type="text" name="wa_group" id="wa_group"
                class="w-full border rounded-lg px-3 py-2 mb-3 text-sm"
                placeholder="Link WhatsApp Group (https://chat.whatsapp.com/...)">

                <!-- DRAG DROP -->
                <div id="dropArea"
                    class="border-2 border-dashed rounded-lg p-4 text-center text-sm text-gray-500 mb-3 cursor-pointer">
                    Drag & Drop gambar atau klik
                    <input type="file" name="gambar" id="gambar" class="hidden">
                </div>

                <!-- PREVIEW -->
                <img id="preview" class="hidden w-full h-32 object-cover rounded mb-3">

                <!-- CHECKBOX -->
                <label class="flex items-center gap-2 mb-4 text-sm">
                    <input type="checkbox" name="is_rekomendasi" id="is_rekomendasi">
                    Rekomendasi
                </label>

                <!-- BUTTON -->
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg text-sm">Batal</button>

                    <button class="px-4 py-2 bg-[#0f3d2e] text-white rounded-lg text-sm">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // MODAL ANIMATION
        function openModal() {
            const modal = document.getElementById('modal');
            const box = document.getElementById('modalBox');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                box.classList.remove('scale-90', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.getElementById('formKursus').reset();
            document.getElementById('formKursus').action = "{{ route('admin.kursus.store') }}";
            document.getElementById('method').value = '';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            const box = document.getElementById('modalBox');

            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-90', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // EDIT
        function editData(data) {
            openModal();

            let form = document.getElementById('formKursus');
            form.action = '/admin/kursus/' + data.id;
            document.getElementById('method').value = 'PUT';

            document.getElementById('nama_kursus').value = data.nama_kursus;
            document.getElementById('harga').value = data.harga;
            document.getElementById('harga_view').value = formatRupiah(data.harga.toString());
            document.getElementById('jumlah_pertemuan').value = data.jumlah_pertemuan;
            document.getElementById('deskripsi').value = data.deskripsi ?? '';
            document.getElementById('is_rekomendasi').checked = data.is_rekomendasi;
            document.getElementById('materi').value = data.materi ?? '';
            document.getElementById('wa_group').value = data.wa_group ?? '';
        }

        // FORMAT RUPIAH
        function formatRupiah(angka) {
            return 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        document.getElementById('harga_view').addEventListener('keyup', function() {
            let val = this.value.replace(/[^0-9]/g, '');
            document.getElementById('harga').value = val;
            this.value = val ? formatRupiah(val) : '';
        });

        // PREVIEW GAMBAR
        document.getElementById('gambar').addEventListener('change', function(e) {
            let file = e.target.files[0];
            let reader = new FileReader();

            reader.onload = function() {
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

        // SEARCH
        document.getElementById('search').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });

        function hapusData(id) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/kursus/' + id;

                    let token = document.createElement('input');
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';

                    let method = document.createElement('input');
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(token);
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        document.getElementById('formKursus').addEventListener('submit', function() {
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        });
    </script>
@endsection
