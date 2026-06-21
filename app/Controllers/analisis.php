<?php namespace App\Controllers;
use App\Models\StokModel;

class Analisis extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        // Ambil 30 Hari terakhir
        $listTgl = []; for($i=29; $i>=0; $i--) { $listTgl[] = date('Y-m-d', strtotime("-$i days")); }
        
        $raw = $db->query("SELECT LEFT(s.kode_barang, 1) as kat, DATE(m.tgl_keluar) as tgl, SUM(d.qty_jual) as total 
                           FROM penjualan_detail d JOIN penjualan_master m ON d.id_penjualan = m.id_penjualan 
                           JOIN stok_barang s ON d.id_stok = s.id_stok GROUP BY kat, tgl")->getResultArray();

        $uniqueKats = array_unique(array_column($raw, 'kat'));
        $colorMap = ['A' => '#FF0000', 'B' => '#00FF00', 'C' => '#0000FF', 'D' => '#FFFF00', 'E' => '#FF00FF'];

        $datasets = [];
        $prediksiBulanDepan = [];

        foreach($uniqueKats as $k) {
            $vals = [];
            foreach($listTgl as $t) {
                $found = 0;
                foreach($raw as $r) { if($r['kat'] == $k && $r['tgl'] == $t) $found = $r['total']; }
                $vals[] = (int)$found;
            }

            // --- LOGIKA REGRESI LINEAR ---
            $n = count($vals);
            $x = range(1, $n);
            $y = $vals;
            $res_prediksi = 0;

            if (array_sum($y) > 0) {
                $sumX = array_sum($x); $sumY = array_sum($y);
                $sumXY = 0; $sumX2 = 0;
                for($i=0; $i<$n; $i++) { $sumXY += ($x[$i] * $y[$i]); $sumX2 += ($x[$i] * $x[$i]); }
                $denom = ($n * $sumX2 - $sumX * $sumX);
                if($denom != 0) {
                    $m = ($n * $sumXY - $sumX * $sumY) / $denom;
                    $c = ($sumY - $m * $sumX) / $n;
                    // Prediksi bulan depan (akumulasi 30 hari ke depan)
                    $total_prediksi = 0;
                    for($j=31; $j<=60; $j++) {
                        $p = ($m * $j) + $c;
                        $total_prediksi += ($p > 0) ? $p : 0;
                    }
                    $res_prediksi = round($total_prediksi);
                }
            }
            $prediksiBulanDepan[$k] = $res_prediksi;

            $color = $colorMap[strtoupper($k)] ?? '#cbd5e1';
            $datasets[] = [
                'label' => 'Kategori ' . strtoupper($k),
                'data' => $vals,
                'borderColor' => $color,
                'backgroundColor' => $color . '22',
                'borderWidth' => 3, 'tension' => 0.4, 'fill' => true
            ];
        }

        $stokModel = new StokModel();
        return view('owner/analisis', [
            'title'    => 'Analisis',
            'labels'   => array_map(fn($d) => date('d M', strtotime($d)), $listTgl),
            'datasets' => $datasets,
            'stok'     => $stokModel->getStokAnalisis(),
            'prediksi' => $prediksiBulanDepan
        ]);
    }
}