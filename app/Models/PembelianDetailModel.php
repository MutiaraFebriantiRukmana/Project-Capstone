<?php namespace App\Models;
use CodeIgniter\Model;

class PembelianDetailModel extends Model {
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $allowedFields = ['id_pembelian', 'kode_barang', 'qty_beli', 'harga_beli_satuan'];
}