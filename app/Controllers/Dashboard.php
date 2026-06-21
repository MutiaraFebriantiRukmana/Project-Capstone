<?php namespace App\Controllers;
use App\Models\StokModel;

class Dashboard extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        $stokModel = new StokModel();
        $stokAnalisis = $stokModel->getStokAnalisis();

        // Stats 4 Kotak
        $penjualanHariIni = $db->table('penjualan_detail d')
            ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
            ->where('DATE(m.tgl_keluar)', date('Y-m-d'))
            ->selectSum('d.total_harga')->get()->getRow()->total_harga ?? 0;

        // Keuntungan Bulan Ini (Logic Master-Detail)
        $untung = $db->table('penjualan_detail d')
            ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
            ->join('stok_barang s', 'd.id_stok = s.id_stok')
            ->where('MONTH(m.tgl_keluar)', date('m'))
            ->selectSum('(d.harga_jual_satuan - s.harga_beli_akhir) * d.qty_jual', 'laba')
            ->get()->getRow()->laba ?? 0;

        // Penjualan Terbaru
        $terbaru = $db->table('penjualan_detail d')
            ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
            ->join('stok_barang s', 'd.id_stok = s.id_stok')
            ->orderBy('m.tgl_keluar', 'DESC')->limit(5)->get()->getResultArray();

        // Grafik 7 Hari
        $gSales = []; $gLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $gLabels[] = date('d M', strtotime($tgl));
            $gSales[] = $db->table('penjualan_detail d')->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
                ->where('DATE(m.tgl_keluar)', $tgl)->selectSum('d.qty_jual')->get()->getRow()->qty_jual ?? 0;
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalProduk' => count($stokAnalisis),
            'totalStok' => array_sum(array_column($stokAnalisis, 'jumlah_stok')),
            'penjualanHariIni' => $penjualanHariIni,
            'keuntunganBulanIni' => $untung,
            'stokMenipis' => array_filter($stokAnalisis, fn($v) => $v['status_ml'] != 'AMAN'),
            'penjualanTerbaru' => $terbaru,
            'gLabels' => $gLabels, 'gSales' => $gSales,
            'prediksi' => 0 
        ]);
    }
}