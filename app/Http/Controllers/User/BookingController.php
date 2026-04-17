<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Booking;
use App\Models\Barber;
use App\Models\LayananItem;

use App\Models\JadwalBarber;
use App\Models\LiburBarber;

class BookingController extends Controller
{
    public function create()
    {
        $barbers = Barber::with(['jadwal','libur'])->get();

        $layanans = LayananItem::whereHas('layanan', function ($q) {
            $q->where('kategori', 'barbershop');
        })->get();

        $bookings = Booking::whereIn('status', ['menunggu', 'diproses'])->get();

        // 🔥 TAMBAHAN: RIWAYAT USER
        $riwayat = Booking::with(['barber','layananItem'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5) // ambil 5 terakhir
            ->get();

        return view('user.booking', compact(
            'barbers',
            'layanans',
            'bookings',
            'riwayat' // 🔥 kirim ke blade
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required',
            'layanan_item_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required'
        ]);

                // 🔥 CEK USER MASIH PUNYA BOOKING AKTIF
        $cekBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'diproses'])
            ->exists();

        if ($cekBooking) {
            return back()->with('error', 'Anda masih memiliki booking aktif');
        }

        // 🔥 CEK HARI (INDONESIA)
        $hari = strtolower(Carbon::parse($request->tanggal)->locale('id')->isoFormat('dddd'));

        // 🔥 CONVERT HARI KE FORMAT DATABASE
        $mapHari = [
            'senin' => 'senin',
            'selasa' => 'selasa',
            'rabu' => 'rabu',
            'kamis' => 'kamis',
            'jumat' => 'jumat',
            'sabtu' => 'sabtu',
            'minggu' => 'minggu'
        ];

        $hari = $mapHari[$hari] ?? $hari;


        // 🔥 CEK LIBUR KHUSUS (TANGGAL)
        $libur = LiburBarber::where('barber_id', $request->barber_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($libur) {
            return back()->withInput()->with('error', 'Barber libur di tanggal ini');
        }


        // 🔥 CEK JADWAL HARIAN
        $jadwal = JadwalBarber::where('barber_id', $request->barber_id)
            ->where('hari', $hari)
            ->first();

        if (!$jadwal) {
            return back()->withInput()->with('error', 'Jadwal barber belum diatur');
        }

        if ($jadwal->libur) {
            return back()->withInput()->with('error', 'Barber libur di hari ini');
        }


        // 🔥 CEK JAM KERJA
        if (
            strtotime($request->jam) < strtotime($jadwal->jam_mulai) ||
            strtotime($request->jam) > strtotime($jadwal->jam_selesai)
        ) {
            return back()->withInput()->with('error', 'Jam di luar jadwal kerja barber');
        }
        $jamRequest = Carbon::parse($request->jam);

        // 🔥 VALIDASI JEDA 30 MENIT
        $existingBooking = Booking::where('barber_id', $request->barber_id)
            ->whereDate('tanggal', $request->tanggal)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->get();

        foreach ($existingBooking as $item) {
            $jamExisting = Carbon::parse($item->jam);
            $selisih = $jamRequest->diffInMinutes($jamExisting);

            if ($selisih < 30) {
                return back()
                    ->withInput()
                    ->with('error', 'Jam terlalu dekat, minimal 30 menit');
            }
        }

        // 🔥 NOMOR ANTRIAN
        $antrian = Booking::whereDate('tanggal', $request->tanggal)->count() + 1;

        // 🔥 SIMPAN BOOKING
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'barber_id' => $request->barber_id,
            'layanan_item_id' => $request->layanan_item_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'nomor_antrian' => $antrian,
            'status' => 'menunggu',
            'payment_status' => 'pending',
            'qr_code' => uniqid('QR-')
        ]);

        // 🔥 MIDTRANS
        try {

            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            if (!Config::$serverKey) {
                return back()->with('error', 'Server Key kosong, cek .env');
            }

            // 🔥 ORDER ID UNIQUE
            $orderId = 'BOOK-' . $booking->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => 20000
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name ?? 'User',
                    'email' => Auth::user()->email ?? 'user@gmail.com',
                ]
            ];

            // 🔥 AMBIL SNAP TOKEN
            $snapToken = Snap::getSnapToken($params);

            // 🔥 SIMPAN KE DATABASE
            $booking->update([
                'midtrans_order_id' => $orderId,
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {

            return back()->with('error', 'Midtrans Error: ' . $e->getMessage());
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Booking berhasil, silakan lakukan pembayaran');
    }

    public function payment($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'error' => 'Booking tidak ditemukan'
            ], 404);
        }

        if (!$booking->snap_token) {
            return response()->json([
                'error' => 'Snap token tidak tersedia'
            ], 400);
        }

        return response()->json([
            'snap_token' => $booking->snap_token
        ]);
    }

    public function downloadQr($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->payment_status !== 'paid') {
            abort(403, 'QR hanya tersedia setelah pembayaran');
        }

        $url = url('/admin/scan/' . $booking->qr_code);

        $qr = QrCode::format('svg')
            ->size(400)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($url);

        return response($qr)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-booking.svg"');
    }

    public function updatePaymentStatus(Request $request, $id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['error' => 'Booking tidak ditemukan'], 404);
    }

    $booking->update([
        'payment_status' => 'paid',
    ]);

    return response()->json(['success' => true]);
}
}
