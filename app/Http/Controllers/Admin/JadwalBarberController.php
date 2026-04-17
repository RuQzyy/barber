<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 🔥 IMPORT MODEL (WAJIB)
use App\Models\Barber;
use App\Models\JadwalBarber;
use App\Models\LiburBarber;

class JadwalBarberController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $barbers = Barber::with(['jadwal', 'libur'])->get();

        return view('admin.jadwal', compact('barbers'));
    }

    // ================= SIMPAN JADWAL =================
    public function store(Request $request)
    {
        $request->validate([
            'barber_id'   => 'required|exists:barbers,id',
            'hari'        => 'required|string',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required'
        ]);

        JadwalBarber::updateOrCreate(
            [
                'barber_id' => $request->barber_id,
                'hari'      => strtolower($request->hari)
            ],
            [
                'jam_mulai'   => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'libur'       => $request->has('libur') // 🔥 checkbox fix
            ]
        );

        return back()->with('success', 'Jadwal berhasil disimpan');
    }

    // ================= TAMBAH LIBUR =================
    public function tambahLibur(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'tanggal'   => 'required|date'
        ]);

        LiburBarber::create([
            'barber_id'  => $request->barber_id,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Hari libur berhasil ditambahkan');
    }

    // ================= HAPUS LIBUR (OPSIONAL 🔥) =================
    public function hapusLibur($id)
    {
        LiburBarber::findOrFail($id)->delete();

        return back()->with('success', 'Hari libur dihapus');
    }
}
