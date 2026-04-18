@extends('layouts.user')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black text-white p-10">

        <h2 class="text-3xl font-bold mb-10 text-center">Kursus</h2>

        <!-- ================= RIWAYAT ================= -->
        @if ($riwayat->count())
            <div class="mb-12 bg-gray-900 p-6 rounded-2xl shadow">

                <h3 class="mb-4 font-semibold text-lg">Kursus Anda</h3>

                @foreach ($riwayat as $r)
                    <div class="flex justify-between items-center mb-3 bg-gray-800 p-4 rounded-lg">

                        <div>
                            <p class="font-semibold">{{ $r->kursus->nama_kursus }}</p>
                            <p class="text-xs text-gray-400">
                                {{ ucfirst($r->tipe_kelas) }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                No HP: {{ $r->no_hp ?? '-' }}
                                </p>
                        </div>

                        <div>
                            @if ($r->payment_status == 'pending')
                                <button onclick="bayar({{ $r->id }})"
                                    class="bg-yellow-500 text-black px-3 py-1 rounded text-xs">
                                    Bayar
                                </button>
                            @elseif($r->payment_status == 'paid')
                               @if ($r->tipe_kelas == 'private')

                           <a href="https://wa.me/{{ $r->mentor?->no_hp }}?text={{ urlencode('Halo kak 🙌 saya '.$r->nama_peserta.' ('.$r->no_hp.') ingin mengikuti kursus private '.$r->kursus->nama_kursus) }}"
                            target="_blank"
                            class="bg-green-500 px-3 py-1 rounded text-xs">
                            Chat Mentor
                            </a>

                            @else

                            <a href="{{ $r->kursus->wa_group }}?text={{ urlencode('Halo kak 🙌 saya '.$r->nama_peserta.' ('.$r->no_hp.') ingin bergabung ke grup '.$r->kursus->nama_kursus) }}"
                            target="_blank"
                            class="bg-blue-500 px-3 py-1 rounded text-xs">
                            Masuk Grup
                            </a>

                            @endif
                                                        @endif
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

        <!-- ================= LIST KURSUS ================= -->
        <div class="grid md:grid-cols-3 gap-8">

            @foreach ($kursus as $k)
                <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition">

                    <img src="{{ $k->gambar ? asset('storage/' . $k->gambar) : asset('images/img_1.jpg') }}"
                        class="h-52 w-full object-cover">

                    <div class="p-5">

                        <h3 class="font-bold text-lg">{{ $k->nama_kursus }}</h3>

                        <p class="text-sm text-gray-400 mt-2">
                            {{ $k->jumlah_pertemuan }} Pertemuan
                        </p>

                        <p class="text-yellow-400 mt-3 font-semibold">
                            Rp {{ number_format($k->harga, 0, ',', '.') }}
                        </p>

                        <div class="flex gap-2 mt-4">

                            <button onclick="openDetail({{ $k->id }})"
                                class="w-1/2 bg-gray-700 py-2 rounded text-xs hover:bg-gray-600">
                                Detail
                            </button>

                            <button onclick="openModal({{ $k->id }})"
                                class="w-1/2 bg-yellow-500 text-black py-2 rounded text-xs hover:bg-yellow-400">
                                Daftar
                            </button>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <!-- ================= MENTOR ================= -->
        <div class="mt-20">

            <h3 class="text-2xl font-bold text-center mb-8">Mentor Kami</h3>

            <div class="flex flex-wrap justify-center gap-6">

                @foreach ($mentors as $m)
                    <div class="w-56 bg-gray-900 rounded-xl overflow-hidden shadow hover:shadow-xl transition">

                        <img src="{{ $m->foto ? asset('storage/' . $m->foto) : asset('images/img_1.jpg') }}"
                            class="h-40 w-full object-cover">

                        <div class="p-4 text-center">
                            <p class="font-semibold">{{ $m->nama }}</p>
                            <p class="text-xs text-gray-400 mt-1">Mentor Profesional</p>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

    <!-- ================= MODAL DETAIL ================= -->
<div id="detailModal"
class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center">

<div class="bg-gray-900 p-6 rounded-2xl w-[600px] max-h-[85vh] overflow-y-auto relative shadow-2xl">

<!-- CLOSE -->
<button onclick="closeDetail()"
class="absolute top-3 right-3 text-gray-400 hover:text-white text-lg">
✕
</button>

<!-- TITLE -->
<h3 id="detailNama"
class="text-xl font-bold mb-4 text-yellow-400">
</h3>

<!-- ================= BENEFIT ================= -->
<div class="mb-5">

<p class="text-sm font-semibold text-white mb-2">
Benefit
</p>

<p id="detailDesc"
class="text-sm text-gray-300 leading-relaxed">
</p>

</div>

<!-- GARIS PEMBATAS -->
<div class="border-t border-gray-700 my-4"></div>

<!-- ================= MATERI ================= -->
<div>

<p class="text-sm font-semibold text-white mb-2">
Materi
</p>

<ul id="detailMateri"
class="text-sm text-gray-300 space-y-1 list-disc pl-5">
</ul>

</div>

</div>
</div>

    <!-- ================= MODAL DAFTAR ================= -->
    <div id="modal" class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center">

        <div class="bg-gray-900 p-6 rounded-2xl w-96 relative">

            <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400">✕</button>

            <h3 class="text-center font-bold mb-4">Daftar Kursus</h3>

            <form id="formKursus" method="POST">
                @csrf

                <select id="kelasSelect" class="w-full bg-gray-800 p-2 rounded mb-3" onchange="handleKelas(this.value)">
                    <option value="">-- Pilih Kelas --</option>
                    <option value="reguler">Reguler</option>
                    <option value="private">Private</option>
                </select>

                <input type="text" name="nama_peserta" id="namaPeserta" placeholder="Nama Lengkap"
                    class="w-full bg-gray-800 p-2 rounded mb-3" oninput="checkForm()">

                <input type="text" name="no_hp" id="noHp" placeholder="Nomor WhatsApp"
                    class="w-full bg-gray-800 p-2 rounded mb-3" oninput="checkForm()">

                <input type="hidden" name="tipe_kelas" id="tipeKelas">
                <input type="hidden" name="mentor_id" id="mentorId">

                <div id="mentorBox" class="hidden">
                    <select id="mentorSelect" class="w-full bg-gray-800 p-2 rounded" onchange="handleMentor(this.value)">
                        <option value="">-- Pilih Mentor --</option>

                        @foreach ($mentors as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach

                    </select>
                </div>

                <button id="submitBtn" class="mt-4 w-full bg-yellow-500 text-black py-2 rounded hidden">
                    Lanjutkan Pembayaran
                </button>

            </form>

        </div>
    </div>

    <!-- ================= SCRIPT ================= -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
    </script>

    <script>
        let kursus = @json($kursus);

        // DETAIL
        function openDetail(id) {
            let k = kursus.find(x => x.id == id);
            if (!k) return;

            detailNama.innerText = k.nama_kursus;
            detailDesc.innerText = k.deskripsi ?? '-';

            let materi = '';
            if (k.materi) {
                k.materi.split('\n').forEach(i => {
                    if (i.trim()) materi += `<li>${i}</li>`;
                });
            } else {
                materi = '<li>Tidak ada materi</li>';
            }
            detailMateri.innerHTML = materi;

            detailModal.classList.remove('hidden');
        }

        function closeDetail() {
            detailModal.classList.add('hidden');
        }

        // MODAL
        function openModal(id) {
            modal.classList.remove('hidden');
            formKursus.action = '/kursus/daftar/' + id;

            kelasSelect.value = '';
            namaPeserta.value = '';
            noHp.value = '';
            mentorSelect.value = '';
            tipeKelas.value = '';
            mentorId.value = '';
            mentorBox.classList.add('hidden');
            submitBtn.classList.add('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        // LOGIC
        function handleKelas(val) {
            tipeKelas.value = val;

            if (val === 'private') {
                mentorBox.classList.remove('hidden');
            } else {
                mentorBox.classList.add('hidden');
                mentorId.value = '';
            }

            checkForm();
        }

        function handleMentor(val) {
            mentorId.value = val;
            checkForm();
        }

        function checkForm() {
            let kelas = tipeKelas.value;
            let nama = namaPeserta.value.trim();
            let hp = noHp.value.trim();
            let mentor = mentorId.value;

            if (!kelas || !nama || !hp) {
                submitBtn.classList.add('hidden');
                return;
            }

            if (kelas === 'private' && !mentor) {
                submitBtn.classList.add('hidden');
                return;
            }

            submitBtn.classList.remove('hidden');
        }

        // CLOSE OUTSIDE
        window.onclick = function(e) {
            if (e.target.id === 'modal') closeModal();
            if (e.target.id === 'detailModal') closeDetail();
        }

        // MIDTRANS
        function bayar(id) {
            fetch('/kursus/payment/' + id)
                .then(res => res.json())
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function() {
                            fetch('/kursus/success/' + id, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });
                            location.reload();
                        }
                    });
                });
        }
    </script>
@endsection
