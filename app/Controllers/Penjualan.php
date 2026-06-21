<?php namespace App\Controllers;
use App\Models\StokModel;

class Penjualan extends BaseController {
    protected $db;
    public function __construct() { $this->db = \Config\Database::connect(); }

    public function index() {
        $role = session()->get('role');
        $laporan = $this->db->table('penjualan_detail d')
                    ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
                    ->join('stok_barang s', 'd.id_stok = s.id_stok')
                    ->select('m.*, d.*, s.nama_barang, s.kode_barang, s.harga_beli_akhir as modal')
                    ->orderBy('m.tgl_keluar','DESC')->get()->getResultArray();

        $data = [
            'title'   => 'Barang Keluar',
            'stok'    => $this->db->table('stok_barang')->where('jumlah_stok >', 0)->get()->getResultArray(),
            'master'  => $this->db->table('penjualan_master')->orderBy('id_penjualan','DESC')->get()->getResultArray(),
            'laporan' => $laporan 
        ];
        return view($role . '/barang_keluar', $data);
    }

    public function save() {
        $ids = $this->request->getPost('id_stok');
        $qtys = $this->request->getPost('qty');
        $inv = 'INV-OUT-' . strtoupper(bin2hex(random_bytes(3)));
        
        $this->db->transStart();
        $this->db->table('penjualan_master')->insert([
            'no_invoice' => $inv,
            'tgl_keluar' => date('Y-m-d H:i:s'),
            'added_by'   => session()->get('username')
        ]);
        $id_p = $this->db->insertID();

        foreach($ids as $i => $id_stok) {
            $barang = $this->db->table('stok_barang')->where('id_stok', $id_stok)->get()->getRow();
            $sub_total = $qtys[$i] * $barang->harga_jual_akhir;
            $laba = ($barang->harga_jual_akhir - $barang->harga_beli_akhir) * $qtys[$i];

            $this->db->table('penjualan_detail')->insert([
                'id_penjualan'      => $id_p,
                'id_stok'           => $id_stok,
                'qty_jual'          => $qtys[$i],
                'harga_jual_satuan' => $barang->harga_jual_akhir,
                'total_harga'       => $sub_total,
                'laba'              => $laba
            ]);
            $this->db->table('stok_barang')->where('id_stok', $id_stok)->update(['jumlah_stok' => $barang->jumlah_stok - $qtys[$i]]);
        }
        $this->db->transComplete();
        return redirect()->back()->with('success', 'Berhasil!');
    }
}