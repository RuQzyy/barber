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

        // ================= 🔥 ANTRIAN HARI INI (LIVE) =================
        $antrianHariIni = Booking::with(['barber','layananItem'])
            ->whereDate('tanggal', today())
            ->whereIn('status', ['menunggu','diproses'])
            ->orderBy('nomor_antrian')
            ->get();

        // ================= 🔥 SEDANG DIPROSES =================
        $antrianSekarang = $antrianHariIni
            ->where('status', 'diproses')
            ->first();

        // ================= 🔥 POSISI USER =================
        $posisiUser = null;

        if ($antrian) {
            $posisiUser = $antrianHariIni
                ->pluck('id')
                ->search($antrian->id);

            if ($posisiUser !== false) {
                $posisiUser += 1;
            }
        }

        // ================= LAYANAN =================
        $layanans = LayananItem::whereHas('layanan', function ($q) {
                $q->where('kategori', 'barbershop');
            })
            ->get();

        // ================= KURSUS =================
        $kursus = Kursus::latest()->get();

        // ================= KURSUS AKTIF =================
        $kursusAktif = '-';

        // ================= FORMAT TAMBAHAN =================
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
            'kursusAktif',

            // 🔥 TAMBAHAN BARU
            'antrianHariIni',
            'antrianSekarang',
            'posisiUser'
        ));
    }
}
