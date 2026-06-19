<?php namespace App\Controllers;
use App\Models\StokModel;

class Stok extends BaseController {
    public function index() {
        $model = new StokModel();
        return view('admin/stok_barang', [
            'title' => 'Stok Barang',
            'barang' => $model->getStokAnalisis()
        ]);
    }

    public function update_harga() {
        $db = \Config\Database::connect();
        $db->table('stok_barang')->where('id_stok', $this->request->getPost('id_stok'))->update([
            'harga_jual_akhir' => $this->request->getPost('harga_jual')
        ]);
        return redirect()->back()->with('success', 'Harga Jual Diperbarui!');
    }
}