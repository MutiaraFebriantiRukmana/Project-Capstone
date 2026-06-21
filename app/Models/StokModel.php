<?php namespace App\Models;
use CodeIgniter\Model;

class StokModel extends Model {
    protected $table = 'stok_barang';
    protected $primaryKey = 'id_stok';
    protected $allowedFields = ['kode_barang','nama_barang','jumlah_stok','harga_beli_akhir','harga_jual_akhir','estimasi_datang'];

    public function getStokAnalisis() {
        $db = \Config\Database::connect();
        $all = $this->findAll();
        $data = [];
        $tgl_7 = date('Y-m-d', strtotime('-7 days'));

        foreach($all as $b) {
            $jual = $db->table('penjualan_detail d')
                ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
                ->where(['d.id_stok' => $b['id_stok'], 'DATE(m.tgl_keluar) >=' => $tgl_7])
                ->selectSum('d.qty_jual')->get()->getRow()->qty_jual ?? 0;

            $vel = ($jual > 0) ? ($jual / 7) : 0.05;
            $sisa = floor($b['jumlah_stok'] / $vel);
            $lt = $b['estimasi_datang'];

            if ($sisa < $lt) { $st = 'BAHAYA'; $cl = 'danger'; }
            elseif ($sisa <= ($lt + 2)) { $st = 'PERINGATAN'; $cl = 'warning'; }
            else { $st = 'AMAN'; $cl = 'success'; }

            $data[] = array_merge($b, ['sisa_hari' => ($sisa > 90 ? 99 : $sisa), 'status_ml' => $st, 'color_ml' => $cl]);
        }
        return $data;
    }
}