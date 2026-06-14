<?php
namespace App\Models;
use CodeIgniter\Model;

class BarangMasukModel extends Model {
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga_beli', 'harga_jual', 'jumlah_barang', 'estimasi_datang', 'added_by'];

    public function getStokAnalisis() {
        $allBarang = $this->findAll();
        $db = \Config\Database::connect();
        $tgl_7 = date('Y-m-d', strtotime('-7 days'));
        $dataFix = [];

        foreach ($allBarang as $b) {
            // Hitung penjualan 7 hari terakhir
            $jual = $db->table('laporan_penjualan')
                ->where(['id_barang' => $b['id_barang'], 'status' => 'Terjual', 'tanggal >=' => $tgl_7])
                ->selectSum('jumlah_terjual')->get()->getRow()->jumlah_terjual ?? 0;

            // Rata-rata per hari (7 hari)
            $velocity = ($jual > 0) ? ($jual / 7) : 0.05; 
            $sisa_hari = floor($b['jumlah_barang'] / $velocity);
            $lead_time = $b['estimasi_datang'];

            // LOGIKA STATUS 
            if ($sisa_hari < $lead_time) {
                $status = 'BAHAYA'; $color = 'danger';
            } elseif ($sisa_hari <= ($lead_time + 2)) {
                $status = 'PERINGATAN'; $color = 'warning';
            } else {
                $status = 'AMAN'; $color = 'success';
            }

            $dataFix[] = array_merge($b, [
                'sisa_hari' => ($sisa_hari > 90) ? 99 : $sisa_hari,
                'status_ml' => $status,
                'color_ml'  => $color
            ]);
        }
        return $dataFix;
    }
}