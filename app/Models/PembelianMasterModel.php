<?php namespace App\Models;
use CodeIgniter\Model;

class PembelianMasterModel extends Model {
    protected $table = 'pembelian_master';
    protected $primaryKey = 'id_pembelian';
    protected $allowedFields = ['no_invoice', 'supplier', 'total_bayar', 'tgl_pembelian', 'added_by'];
}