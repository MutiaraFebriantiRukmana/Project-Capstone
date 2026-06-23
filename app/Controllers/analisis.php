<?php namespace App\Controllers;
use App\Models\StokModel;

class Analisis extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        // Label Tanggal 30 Hari Terakhir (Lalu)
        $listTglLalu = []; 
        for($i=29; $i>=0; $i--) { $listTglLalu[] = date('Y-m-d', strtotime("-$i days")); }

        // Label Tanggal 30 Hari Kedepan (Prediksi)
        $listTglDepan = [];
        for($i=1; $i<=30; $i++) { $listTglDepan[] = date('d M', strtotime("+$i days")); }
        
        $raw = $db->query("SELECT LEFT(s.kode_barang, 1) as kat, DATE(m.tgl_keluar) as tgl, SUM(d.qty_jual) as total 
                           FROM penjualan_detail d JOIN penjualan_master m ON d.id_penjualan = m.id_penjualan 
                           JOIN stok_barang s ON d.id_stok = s.id_stok GROUP BY kat, tgl")->getResultArray();

        $uniqueKats = array_unique(array_column($raw, 'kat'));
        $colorMap = ['A' => '#FF4444', 'B' => '#00C851', 'C' => '#33b5e5', 'D' => '#ffbb33', 'E' => '#aa66cc'];

        $datasetsLalu = [];
        $datasetsDepan = [];

        foreach($uniqueKats as $k) {
            $valsLalu = [];
            foreach($listTglLalu as $t) {
                $found = 0;
                foreach($raw as $r) { if($r['kat'] == $k && $r['tgl'] == $t) $found = $r['total']; }
                $valsLalu[] = (int)$found;
            }

            // --- LOGIKA REGRESI LINEAR ---
            $n = count($valsLalu);
            $x = range(1, $n);
            $y = $valsLalu;
            $valsDepan = [];

            if (array_sum($y) > 0) {
                $sumX = array_sum($x); $sumY = array_sum($y);
                $sumXY = 0; $sumX2 = 0;
                for($i=0; $i<$n; $i++) { $sumXY += ($x[$i] * $y[$i]); $sumX2 += ($x[$i] * $x[$i]); }
                $denom = ($n * $sumX2 - $sumX * $sumX);
                
                if($denom != 0) {
                    $m = ($n * $sumXY - $sumX * $sumY) / $denom;
                    $c = ($sumY - $m * $sumX) / $n;
                    
                    // Hitung Prediksi HARIAN untuk hari ke 31 sampai 60
                    for($j=31; $j<=60; $j++) {
                        $p = ($m * $j) + $c;
                        $valsDepan[] = ($p > 0) ? round($p, 1) : 0; 
                    }
                }
            } else {
                $valsDepan = array_fill(0, 30, 0);
            }

            $color = $colorMap[strtoupper($k)] ?? '#cbd5e1';
            
            // Dataset Grafik Lalu
            $datasetsLalu[] = [
                'label' => 'Kategori ' . strtoupper($k),
                'data' => $valsLalu,
                'borderColor' => $color,
                'backgroundColor' => $color . '22',
                'borderWidth' => 3, 'tension' => 0.4, 'fill' => true
            ];

            // Dataset Grafik Prediksi 
            $datasetsDepan[] = [
                'label' => 'Prediksi ' . strtoupper($k),
                'data' => $valsDepan,
                'borderColor' => $color,
                'backgroundColor' => $color . '11',
                'borderDash' => [5, 5], // Membuat garis putus-putus
                'borderWidth' => 2, 'tension' => 0.4, 'fill' => true
            ];
        }

        $stokModel = new StokModel();
        return view('owner/analisis', [
            'title'         => 'Analisis Penjualan',
            'labelsLalu'    => array_map(fn($d) => date('d M', strtotime($d)), $listTglLalu),
            'labelsDepan'   => $listTglDepan,
            'datasetsLalu'  => $datasetsLalu,
            'datasetsDepan' => $datasetsDepan,
            'stok'          => $stokModel->getStokAnalisis()
        ]);
    }
}