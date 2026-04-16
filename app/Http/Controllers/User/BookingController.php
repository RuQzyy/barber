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

class BookingController extends Controller
{
    public function create()
    {
        $barbers = Barber::all();

        $layanans = LayananItem::whereHas('layanan', function ($q) {
            $q->where('kategori', 'barbershop');
        })->get();

        $bookings = Booking::whereIn('status', ['menunggu', 'diproses'])->get();

        return view('user.booking', compact('barbers', 'layanans', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required',
            'layanan_item_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required'
        ]);

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
            'payment_status' => 'pending'
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
}
