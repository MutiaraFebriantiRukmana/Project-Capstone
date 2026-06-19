<?php namespace App\Controllers;
use App\Models\StokModel;

class Penjualan extends BaseController {
    protected $db;
    public function __construct() { $this->db = \Config\Database::connect(); }

    public function index() {
        $role = session()->get('role');
        $data = [
            'title' => 'Barang Keluar',
            'stok'  => $this->db->table('stok_barang')->where('jumlah_stok >', 0)->get()->getResultArray(),
            'master'=> $this->db->table('penjualan_master')->orderBy('id_penjualan','DESC')->get()->getResultArray()
        ];
        return view($role . '/barang_keluar', $data);
    }

    public function save() {
        $ids = $this->request->getPost('id_stok'); // Array
        $qtys = $this->request->getPost('qty');    // Array
        $inv = 'INV-OUT-' . strtoupper(bin2hex(random_bytes(3)));
        
        $this->db->transStart();
        
        //Simpan Master
        $this->db->table('penjualan_master')->insert([
            'no_invoice' => $inv,
            'tgl_keluar' => date('Y-m-d H:i:s'),
            'added_by'   => session()->get('username')
        ]);
        $id_p = $this->db->insertID();
        $grand_total = 0;

        //Loop Detail & Hitung Laba Otomatis
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
                'laba'              => $laba // Keuntungan Masuk
            ]);

            // Potong Stok
            $this->db->table('stok_barang')->where('id_stok', $id_stok)->update([
                'jumlah_stok' => $barang->jumlah_stok - $qtys[$i]
            ]);
            
            $grand_total += $sub_total;
        }

        $this->db->transComplete();
        return redirect()->back()->with('success', 'Invoice '.$inv.' Berhasil!');
    }
}