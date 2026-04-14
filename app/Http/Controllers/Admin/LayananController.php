<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\LayananItem;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::with('items')->latest()->get();
        return view('admin.layanan', compact('layanans'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'kategori' => 'required',
            'judul' => 'required|string|max:255',
            'items' => 'nullable|array'
        ]);

        // ✅ SIMPAN LAYANAN
        $layanan = Layanan::create([
            'kategori' => $request->kategori,
            'judul' => $request->judul
        ]);

        // ✅ SIMPAN ITEMS (FLEXIBLE)
        if ($request->items) {
            foreach ($request->items as $item) {

                // skip jika kosong semua
                if (empty($item['nama']) && empty($item['value'])) {
                    continue;
                }

                LayananItem::create([
                    'layanan_id' => $layanan->id,
                    'nama' => $item['nama'] ?? '-',
                    'value' => $this->formatValue($request->kategori, $item['value'] ?? null)
                ]);
            }
        }

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'judul' => 'required|string|max:255',
            'items' => 'nullable|array'
        ]);

        $layanan = Layanan::findOrFail($id);

        // ✅ UPDATE LAYANAN
        $layanan->update([
            'kategori' => $request->kategori,
            'judul' => $request->judul
        ]);

        // ✅ HAPUS ITEM LAMA
        $layanan->items()->delete();

        // ✅ SIMPAN ULANG ITEM
        if ($request->items) {
            foreach ($request->items as $item) {

                if (empty($item['nama']) && empty($item['value'])) {
                    continue;
                }

                LayananItem::create([
                    'layanan_id' => $layanan->id,
                    'nama' => $item['nama'] ?? '-',
                    'value' => $this->formatValue($request->kategori, $item['value'] ?? null)
                ]);
            }
        }

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        // hapus item dulu
        $layanan->items()->delete();

        // hapus layanan
        $layanan->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    // ================= HELPER =================
    private function formatValue($kategori, $value)
    {
        if (!$value) return null;

        // 🔥 kalau barbershop = angka
        if ($kategori === 'barbershop') {
            return preg_replace('/[^0-9]/', '', $value);
        }

        // 🔥 selain itu = text (Ya / Ada / Included)
        return $value;
    }
}
