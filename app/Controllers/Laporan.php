<?php
namespace App\Controllers;
use App\Models\LaporanModel;
use App\Models\BarangMasukModel;

class Laporan extends BaseController {
    protected $laporanModel, $barangModel;
    public function __construct() {
        $this->laporanModel = new LaporanModel();
        $this->barangModel = new BarangMasukModel();
    }

    public function index() {
        $role = session()->get('role');
        $data = [
            'title' => ($role == 'admin') ? 'Laporan Penjualan' : 'Laporan Penjualan Owner',
            'laporan' => ($role == 'admin') ? $this->laporanModel->getLaporan(false) : $this->laporanModel->getLaporan(false),
            'barang' => $this->barangModel->findAll()
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

    public function update($id) {
        $laporan = $this->laporanModel->find($id);
        $barang = $this->barangModel->find($laporan['id_barang']);
        $new_qty = $this->request->getPost('jumlah_terjual');

        $stok_awal = $barang['jumlah_barang'] + $laporan['jumlah_terjual'];
        $this->barangModel->update($laporan['id_barang'], ['jumlah_barang' => $stok_awal - $new_qty]);

        $this->laporanModel->update($id, [
            'jumlah_terjual' => $new_qty,
            'total' => $new_qty * $laporan['harga_satuan']
        ]);
        return redirect()->back()->with('success', 'Data Diperbarui');
    }

    public function delete($id) {
        $laporan = $this->laporanModel->find($id);
        $barang = $this->barangModel->find($laporan['id_barang']);

        $this->barangModel->update($laporan['id_barang'], ['jumlah_barang' => $barang['jumlah_barang'] + $laporan['jumlah_terjual']]);
        
        $this->laporanModel->update($id, ['status' => 'Dihapus']);
        return redirect()->back()->with('success', 'Data Dihapus & Stok Kembali');
    }
}