<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\KursusUser;
use Maatwebsite\Excel\Concerns\FromArray;

class LaporanExport implements FromArray
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function array(): array
    {
        $data = [];

        $data[] = ['LAPORAN PENDAPATAN'];
        $data[] = ['Tanggal', $this->start . ' - ' . $this->end];
        $data[] = [];

        // BOOKING
        $data[] = ['BOOKING'];
        $data[] = ['Nama', 'Tanggal', 'Total'];

        $booking = Booking::whereBetween('created_at', [$this->start, $this->end])
            ->where('status', 'selesai')
            ->get();

        foreach ($booking as $b) {
            $data[] = [
                $b->nama,
                $b->created_at,
                $b->total_harga
            ];
        }

        $data[] = [];

        // KURSUS
        $data[] = ['KURSUS'];
        $data[] = ['Nama', 'Kursus', 'Harga'];

        $kursus = KursusUser::whereBetween('paid_at', [$this->start, $this->end])
            ->where('payment_status', 'paid')
            ->get();

        foreach ($kursus as $k) {
            $data[] = [
                $k->nama_peserta,
                $k->kursus->nama_kursus ?? '-',
                $k->kursus->harga ?? 0
            ];
        }

        return $data;
    }
}
