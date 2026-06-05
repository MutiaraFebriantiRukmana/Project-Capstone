<?php
namespace App\Controllers;
use App\Models\LaporanModel;

class BarangKeluar extends BaseController {
    public function index() {
    $model = new LaporanModel();
    $data = [
        'title' => 'Barang Keluar',
        'laporan' => $model->getLaporan(true)
    ];
    return view('owner/barang_keluar', $data);
}
}