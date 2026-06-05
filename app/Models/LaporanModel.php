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
            ->select('laporan_penjualan.*, barang_masuk.nama_barang, barang_masuk.kode_barang, barang_masuk.harga_beli');
        
        if (!$showDeleted) {
            $builder->where('status', 'Terjual');
        }
        
        return $builder->orderBy('id_laporan', 'DESC')->get()->getResultArray();
    }
}