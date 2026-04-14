<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\LayananItem;
use App\Models\Kursus;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ================= BOOKING TERBARU =================
        $bookingTerbaru = Booking::with(['barber', 'layananItem'])
            ->where('user_id', $userId)
            ->latest()
            ->first();

        // ================= ANTRIAN AKTIF =================
        $antrian = Booking::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()
            ->first();

        // ================= LAYANAN BARBERSHOP =================
        $layanans = LayananItem::whereHas('layanan', function ($q) {
                $q->where('kategori', 'barbershop');
            })
            ->get();

        // ================= KURSUS =================
        $kursus = Kursus::latest()->get();

        // ================= KURSUS AKTIF =================
        // nanti kalau sudah ada tabel pendaftaran kursus
        $kursusAktif = '-';

        // ================= FORMAT TAMBAHAN (OPTIONAL BIAR RAPI DI VIEW) =================
        if ($bookingTerbaru) {
            $bookingTerbaru->tanggal_format = \Carbon\Carbon::parse($bookingTerbaru->tanggal)
                ->format('d M Y');
        }

        if ($antrian) {
            $antrian->status_label = ucfirst($antrian->status);
        }

        return view('user.dashboard', compact(
            'bookingTerbaru',
            'antrian',
            'layanans',
            'kursus',
            'kursusAktif'
        ));
    }
}
