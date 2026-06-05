<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;

class StokBarang extends BaseController
{
    public function index()
    {
        $model = new BarangMasukModel();
        $data = [
            'title'  => 'Daftar Stok Barang',
            'barang' => $model->findAll()
        ];
        return view('admin/stok_barang', $data);
    }
}