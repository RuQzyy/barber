<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;

class KursusController extends Controller
{
    public function index()
    {
        $kursus = Kursus::latest()->get();

        return view('admin.kursus', compact('kursus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kursus' => 'required',
            'harga' => 'required|numeric',
            'jumlah_pertemuan' => 'required|numeric',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image',
            'is_rekomendasi' => 'nullable'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kursus', 'public');
        }

        $data['is_rekomendasi'] = $request->has('is_rekomendasi');

        Kursus::create($data);

        return back()->with('success', 'Data berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $kursus = Kursus::findOrFail($id);

        $data = $request->validate([
            'nama_kursus' => 'required',
            'harga' => 'required|numeric',
            'jumlah_pertemuan' => 'required|numeric',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image',
            'is_rekomendasi' => 'nullable'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kursus', 'public');
        }

        $data['is_rekomendasi'] = $request->has('is_rekomendasi');

        $kursus->update($data);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Kursus::destroy($id);

        return back()->with('success', 'Data berhasil dihapus');
    }
}
