<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;

class BarangMasuk extends BaseController
{
    protected $barangModel;

    public function __construct() {
        $this->barangModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Stok Barang',
            'barang' => $this->barangModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('owner/barang_masuk', $data);
    }

    public function save()
    {
        // VALIDASI AGAR KODE BARANG TIDAK DOUBLE
        if (!$this->validate([
            'kode_barang' => [
                'rules'  => 'required|is_unique[barang_masuk.kode_barang]',
                'errors' => [
                    'is_unique' => 'Kode Barang sudah ada dalam sistem!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', 'Kode Barang sudah digunakan!');
        }

        $this->barangModel->save([
            'kode_barang'   => $this->request->getPost('kode_barang'),
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'harga_beli'    => $this->request->getPost('harga_beli'),
            'harga_jual'    => $this->request->getPost('harga_jual'),
            'jumlah_barang' => $this->request->getPost('jumlah_barang'),
            'added_by'      => session()->get('username')
        ]);

        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil ditambah');
    }

    public function update($id)
    {
        $this->barangModel->update($id, [
            'kode_barang'   => $this->request->getPost('kode_barang'),
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'harga_beli'    => $this->request->getPost('harga_beli'),
            'harga_jual'    => $this->request->getPost('harga_jual'),
            'jumlah_barang' => $this->request->getPost('jumlah_barang'),
        ]);

        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/owner/barang-masuk')->with('success', 'Data berhasil dihapus');
    }
}