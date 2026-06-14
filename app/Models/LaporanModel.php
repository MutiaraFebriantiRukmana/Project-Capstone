<?php
namespace App\Models;
use CodeIgniter\Model;

class LaporanModel extends Model {
    protected $table = 'laporan_penjualan';
    protected $primaryKey = 'id_laporan';
    protected $allowedFields = ['tanggal', 'id_barang', 'jumlah_terjual', 'harga_satuan', 'total', 'status', 'added_by'];

    public function getLaporan($showDeleted = false) {
        $builder = $this->db->table($this->table)
            ->join('barang_masuk', 'barang_masuk.id_barang = laporan_penjualan.id_barang')
            ->select('laporan_penjualan.*, barang_masuk.nama_barang, barang_masuk.kode_barang, barang_masuk.harga_beli as modal');
        if (!$showDeleted) { $builder->where('status', 'Terjual'); }
        return $builder->orderBy('tanggal', 'ASC')->get()->getResultArray();
    }

    // Fungsi untuk Dashboard
    public function getMonthlySales() {
        return $this->db->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah_terjual) as total 
                                 FROM laporan_penjualan WHERE status='Terjual' 
                                 GROUP BY bulan ORDER BY bulan ASC")->getResultArray();
    }

    // Fungsi untuk Analisist (Trend harian per kategori)
    public function getTrendByCategory() {
        return $this->db->query("
            SELECT 
                LEFT(b.kode_barang, 1) as kategori, 
                l.tanggal, 
                SUM(l.jumlah_terjual) as total 
            FROM laporan_penjualan l
            JOIN barang_masuk b ON l.id_barang = b.id_barang
            WHERE l.status = 'Terjual'
            GROUP BY kategori, l.tanggal
            ORDER BY l.tanggal ASC
        ")->getResultArray();
    }
}