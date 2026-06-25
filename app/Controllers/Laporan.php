<?php 

namespace App\Controllers;

class Laporan extends BaseController {
    protected $db;
    public function __construct() { $this->db = \Config\Database::connect(); }

    public function index() {
        $role = session()->get('role');
        return view($role . '/laporan', [
            'title' => 'Laporan',
            'logs'  => $this->db->table('cetak_log')->orderBy('id_log','DESC')->get()->getResultArray()
        ]);
    }

    public function cetak() {
        $awal  = $this->request->getGet('awal');
        $akhir = $this->request->getGet('akhir');

        // VALIDASI: Jika tanggal akhir mendahului tanggal awal
        if (strtotime($akhir) < strtotime($awal)) {
            return redirect()->back()->with('error', 'Gagal! Pilih Tanggal dengan Benar!');
        }

        // Simpan Log
        $this->db->table('cetak_log')->insert([
            'nama_pencetak' => session()->get('username'),
            'tgl_awal'      => $awal,
            'tgl_akhir'     => $akhir,
            'tgl_cetak'     => date('Y-m-d H:i:s')
        ]);

        $data = $this->db->table('penjualan_detail d')
            ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
            ->join('stok_barang s', 'd.id_stok = s.id_stok')
            ->where('DATE(m.tgl_keluar) >=', $awal)
            ->where('DATE(m.tgl_keluar) <=', $akhir)
            ->select('m.no_invoice, m.tgl_keluar, s.nama_barang, d.qty_jual, d.total_harga, m.added_by, s.harga_beli_akhir')
            ->get()->getResultArray();

        return view('admin/cetak_pdf', [
            'data'  => $data,
            'awal'  => $awal,
            'akhir' => $akhir
        ]);
    }
}