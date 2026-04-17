<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barber;
use Illuminate\Support\Facades\Storage;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::latest()->get();
        return view('admin.barbers', compact('barbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barbers', 'public');
        }

        Barber::create([
            'nama' => $request->nama,
            'foto' => $fotoPath
        ]);

        return back()->with('success', 'Barber berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $barber = Barber::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto')) {

            if ($barber->foto) {
                Storage::disk('public')->delete($barber->foto);
            }

            $barber->foto = $request->file('foto')->store('barbers', 'public');
        }

        $barber->nama = $request->nama;
        $barber->save();

        return back()->with('success', 'Barber berhasil diupdate');
    }

    public function destroy($id)
    {
        $barber = Barber::findOrFail($id);

        if ($barber->foto) {
            Storage::disk('public')->delete($barber->foto);
        }

        $barber->delete();

        return back()->with('success', 'Barber berhasil dihapus');
    }
}
