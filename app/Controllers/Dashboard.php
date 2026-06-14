<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\BarangMasukModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();
        $barangModel = new BarangMasukModel();
        $db = \Config\Database::connect();

        // Ambil Data SMA dari Model 
        $stokAnalisis = $barangModel->getStokAnalisis();
        
        // Ringkasan
        $totalProduk = count($stokAnalisis);
        $totalStok = array_sum(array_column($stokAnalisis, 'jumlah_barang'));
        
        $hariIni = date('Y-m-d');
        $penjualanHariIni = $laporanModel->where('tanggal', $hariIni)->where('status', 'Terjual')->selectSum('total')->get()->getRow()->total ?? 0;

        $bulanIni = date('m');
        $tahunIni = date('Y');
        $keuntunganBulanIni = $db->table('laporan_penjualan l')
            ->join('barang_masuk b', 'l.id_barang = b.id_barang')
            ->where(['l.status' => 'Terjual', 'MONTH(l.tanggal)' => $bulanIni, 'YEAR(l.tanggal)' => $tahunIni])
            ->selectSum('(l.harga_satuan - b.harga_beli) * l.jumlah_terjual', 'laba')
            ->get()->getRow()->laba ?? 0;

        // Grafik Penjualan 7 Hari Terakhir
        $grafikSales = [];
        $grafikLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $grafikLabels[] = date('d M', strtotime($tgl));
            $grafikSales[] = $laporanModel->where('tanggal', $tgl)->where('status', 'Terjual')->selectSum('jumlah_terjual')->get()->getRow()->jumlah_terjual ?? 0;
        }

        // Filter Stok Menipis 
        $stokMenipis = array_filter($stokAnalisis, function($v) {
            return $v['status_ml'] !== 'AMAN';
        });

        // Logika Regresi Linear (Prediksi Bulan Depan)
        $monthlyData = $laporanModel->getMonthlySales();
        $x = []; $y = []; $n = count($monthlyData);
        foreach ($monthlyData as $idx => $row) { $x[] = $idx + 1; $y[] = (int)$row['total']; }
        $prediksi = 0;
        if ($n > 1) {
            $sumX = array_sum($x); $sumY = array_sum($y); $sumXY = 0; $sumX2 = 0;
            for ($i = 0; $i < $n; $i++) { $sumXY += ($x[$i] * $y[$i]); $sumX2 += ($x[$i] * $x[$i]); }
            $denom = ($n * $sumX2 - $sumX * $sumX);
            if($denom != 0) {
                $m = ($n * $sumXY - $sumX * $sumY) / $denom;
                $c = ($sumY - $m * $sumX) / $n;
                $prediksi = round(($m * ($n + 1)) + $c);
            }
        }

        return view('dashboard', [
            'title'             => 'Dashboard',
            'totalProduk'       => $totalProduk,
            'totalStok'         => $totalStok,
            'penjualanHariIni'  => $penjualanHariIni,
            'keuntunganBulanIni'=> $keuntunganBulanIni,
            'stokMenipis'       => $stokMenipis,
            'penjualanTerbaru'  => array_slice($laporanModel->getLaporan(false), 0, 5),
            'grafikLabels'      => $grafikLabels,
            'grafikSales'       => $grafikSales,
            'prediksi'          => ($prediksi < 0) ? 0 : $prediksi,
            'alerts'            => $stokAnalisis
        ]);
    }
}