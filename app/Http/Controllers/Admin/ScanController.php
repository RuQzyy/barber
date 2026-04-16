<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class ScanController extends Controller
{
    public function scan($token)
    {
        $booking = Booking::with(['user', 'barber', 'layananItem'])
            ->where('qr_code', $token)
            ->first();

        if (!$booking) {
            abort(404, 'QR tidak valid');
        }

        return view('admin.result', compact('booking'));
    }
}
