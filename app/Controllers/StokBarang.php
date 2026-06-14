<?php
namespace App\Controllers;
use App\Models\BarangMasukModel;

class StokBarang extends BaseController {
    public function index() {
        $barangModel = new BarangMasukModel();
        return view('admin/stok_barang', [
            'title' => 'Daftar Stok Barang',
            'barang' => $barangModel->getStokAnalisis() 
        ]);
    }
}