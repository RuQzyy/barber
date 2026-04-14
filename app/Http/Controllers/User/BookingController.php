<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; // 🔥 WAJIB
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🔥 FIX auth()
use App\Models\Booking;
use App\Models\Barber;
use App\Models\LayananItem;

class BookingController extends Controller
{
    public function create()
    {
        $barbers = Barber::all();

        $layanans = LayananItem::where('layanan_id', 1)->get();

        return view('user.booking.create', compact('barbers', 'layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required',
            'layanan_item_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required'
        ]);

        // 🔥 nomor antrian otomatis
        $antrian = Booking::whereDate('tanggal', $request->tanggal)->count() + 1;

        Booking::create([
            'user_id' => Auth::id(), // 🔥 FIX
            'barber_id' => $request->barber_id,
            'layanan_item_id' => $request->layanan_item_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'nomor_antrian' => $antrian,
            'status' => 'menunggu'
        ]);

        return redirect()->back()->with('success', 'Booking berhasil!');
    }
}
