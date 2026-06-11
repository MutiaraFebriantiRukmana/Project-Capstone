<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\BarangMasukModel;

class Laporan extends BaseController
{
    protected $laporanModel, $barangModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->barangModel = new BarangMasukModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $data = [
            'title'   => ($role == 'admin') ? 'Laporan Penjualan' : 'Laporan Penjualan Owner',
            'laporan' => $this->laporanModel->getLaporan(false),
            'barang'  => $this->barangModel->findAll()
        ];
        return view($role . '/laporan_penjualan', $data);
    }

    public function save() {
        $id_b = $this->request->getPost('id_barang');
        $qty = $this->request->getPost('jumlah_terjual');
        $barang = $this->barangModel->find($id_b);

        if ($barang['jumlah_barang'] < $qty) return redirect()->back()->with('error', 'Stok Kurang!');

        $this->laporanModel->save([
            'tanggal' => date('Y-m-d'),
            'id_barang' => $id_b,
            'jumlah_terjual' => $qty,
            'harga_satuan' => $barang['harga_jual'],
            'total' => $qty * $barang['harga_jual'],
            'status' => 'Terjual',
            'added_by' => session()->get('username')
        ]);

        $this->barangModel->update($id_b, ['jumlah_barang' => $barang['jumlah_barang'] - $qty]);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    public function update($id)
        {
            $laporanModel = new \App\Models\LaporanModel();
            $barangModel = new \App\Models\BarangMasukModel();

            $old = $laporanModel->find($id);
            $new_qty = $this->request->getPost('jumlah_terjual');
            $barang = $barangModel->find($old['id_barang']);

            $stok_sekarang = ($barang['jumlah_barang'] + $old['jumlah_terjual']) - $new_qty;
            $barangModel->update($old['id_barang'], ['jumlah_barang' => $stok_sekarang]);
            $laporanModel->update($id, [
                'jumlah_terjual' => $new_qty,
                'total'          => $new_qty * $old['harga_satuan'],
                'status'         => 'Terjual' 
            ]);

            return redirect()->to('/admin/laporan')->with('success', 'Data berhasil diperbarui');
        }

    public function delete($id) {
        $l = $this->laporanModel->find($id);
        $b = $this->barangModel->find($l['id_barang']);
        $this->barangModel->update($l['id_barang'], ['jumlah_barang' => $b['jumlah_barang'] + $l['jumlah_terjual']]);
        $this->laporanModel->update($id, ['status' => 'Dihapus']);
        return redirect()->back()->with('success', 'Dihapus & Stok Kembali');
    }
}