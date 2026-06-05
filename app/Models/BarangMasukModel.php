<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'barang_masuk';
    protected $primaryKey       = 'id_barang';
    protected $allowedFields    = ['kode_barang', 'nama_barang', 'harga_beli', 'harga_jual', 'jumlah_barang', 'added_by'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';
}