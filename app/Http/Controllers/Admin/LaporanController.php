<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\KursusUser;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth();
        $end = $request->end_date ?? now();

        // BOOKING
        $booking = Booking::whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai')
            ->get();

        // KURSUS
        $kursus = KursusUser::whereBetween('paid_at', [$start, $end])
            ->where('payment_status', 'paid')
            ->get();

        $totalBooking = $booking->sum('total_harga');
        $totalKursus = $kursus->sum(fn($k) => $k->kursus->harga ?? 0);

        $totalSemua = $totalBooking + $totalKursus;

        return view('admin.laporan', compact(
            'booking',
            'kursus',
            'totalBooking',
            'totalKursus',
            'totalSemua',
            'start',
            'end'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(new LaporanExport(
            $request->start_date,
            $request->end_date
        ), 'laporan.xlsx');
    }
}
