<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'barber', 'layananItem']);

        // 🔥 FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $bookings = $query->latest()->get();

        return view('admin.booking', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $booking->status = $request->status;
    $booking->save();

    return redirect()->route('admin.booking')
        ->with('success', 'Status berhasil diupdate!');
}
}
