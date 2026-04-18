<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kursus;
use App\Models\KursusUser;
use App\Models\Barber;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

class KursusController extends Controller
{
    public function index()
    {
        $kursus = Kursus::all();

        $riwayat = KursusUser::with(['kursus','mentor'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $mentors = Barber::where('is_mentor', 1)->get();

        return view('user.kursus', compact('kursus','riwayat','mentors'));
    }

    public function daftar(Request $request, $id)
    {
        $kursus = Kursus::findOrFail($id);

        // 🔥 VALIDASI BARU
        $request->validate([
            'tipe_kelas' => 'required|in:private,reguler',
            'mentor_id' => 'nullable|exists:barbers,id',
            'nama_peserta' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20'
        ]);

        // 🔥 VALIDASI KHUSUS PRIVATE
        if ($request->tipe_kelas == 'private' && !$request->mentor_id) {
            return back()->with('error','Pilih mentor untuk kelas private');
        }

        // 🔥 CEK SUDAH BELI
        $cek = KursusUser::where('user_id', Auth::id())
            ->where('kursus_id', $id)
            ->where('tipe_kelas', $request->tipe_kelas)
            ->where('payment_status','paid')
            ->exists();

        if ($cek) {
            return back()->with('error','Anda sudah membeli kursus ini');
        }

        // 🔥 SIMPAN DATA
        $trx = KursusUser::create([
            'user_id' => Auth::id(),
            'kursus_id' => $id,
            'tipe_kelas' => $request->tipe_kelas,
            'mentor_id' => $request->mentor_id,
            'nama_peserta' => $request->nama_peserta,
            'no_hp' => $request->no_hp,
            'payment_status' => 'pending'
        ]);

        // 🔥 MIDTRANS CONFIG
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'KURSUS-' . $trx->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $kursus->harga
            ],
            'customer_details' => [
                'first_name' => $request->nama_peserta,
                'phone' => $request->no_hp,
                'email' => Auth::user()->email
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        $trx->update([
            'midtrans_order_id' => $orderId,
            'snap_token' => $snapToken
        ]);

        return redirect()->route('user.kursus.index')
            ->with('snap_token', $snapToken)
            ->with('trx_id', $trx->id);
    }

    public function payment($id)
    {
        $trx = KursusUser::findOrFail($id);

        return response()->json([
            'snap_token' => $trx->snap_token
        ]);
    }

    public function success($id)
    {
        $trx = KursusUser::findOrFail($id);

        $trx->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return response()->json(['success'=>true]);
    }
}
