<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;

class BarangMasuk extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Stok Barang',
            'barang' => $this->barangModel->findAll()
        ];
        return view('owner/barang_masuk', $data);
    }

    public function save()
    {
        $this->barangModel->save([
            'kode_barang'     => $this->request->getPost('kode_barang'),
            'nama_barang'     => $this->request->getPost('nama_barang'),
            'harga_beli'      => $this->request->getPost('harga_beli'),
            'harga_jual'      => $this->request->getPost('harga_jual'),
            'jumlah_barang'   => $this->request->getPost('jumlah_barang'),
            'estimasi_datang' => $this->request->getPost('estimasi_datang'),
            'added_by'        => session()->get('username')
        ]);
        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil ditambah');
    }

    public function update($id)
    {
        $this->barangModel->update($id, [
            'kode_barang'     => $this->request->getPost('kode_barang'),
            'nama_barang'     => $this->request->getPost('nama_barang'),
            'harga_beli'      => $this->request->getPost('harga_beli'),
            'harga_jual'      => $this->request->getPost('harga_jual'),
            'jumlah_barang'   => $this->request->getPost('jumlah_barang'),
            'estimasi_datang' => $this->request->getPost('estimasi_datang'),
        ]);
        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil dihapus');
    }
}