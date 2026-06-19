<?php namespace App\Controllers;

class Pembelian extends BaseController {
    protected $db;
    public function __construct() { $this->db = \Config\Database::connect(); }

    public function index() {
        return view('owner/master_barang', [
            'title' => 'Master Barang',
            'pembelian' => $this->db->table('pembelian_master')->orderBy('tgl_pembelian','DESC')->get()->getResultArray()
        ]);
    }

    public function detail() {
        $data = [
            'title' => 'Detail Barang',
            'detail' => $this->db->table('pembelian_detail d')
                        ->join('pembelian_master m', 'd.id_pembelian = m.id_pembelian')
                        ->select('d.*, m.no_invoice, m.tgl_pembelian, m.supplier')
                        ->orderBy('m.tgl_pembelian', 'DESC')->get()->getResultArray()
        ];
        return view('owner/detail_barang', $data);
    }

    public function save() {
        $invoice = 'INV-IN-' . strtoupper(bin2hex(random_bytes(3)));
        $kodes = $this->request->getPost('kode_barang');
        $namas = $this->request->getPost('nama_barang');
        $qtys  = $this->request->getPost('qty');
        $belis = $this->request->getPost('harga_beli');
        $juals = $this->request->getPost('harga_jual');

        $this->db->transStart();
        $this->db->table('pembelian_master')->insert([
            'no_invoice' => $invoice, 'supplier' => $this->request->getPost('supplier'),
            'total_bayar' => $this->request->getPost('total_invoice'),
            'tgl_pembelian' => date('Y-m-d H:i:s'), 'added_by' => session()->get('username')
        ]);
        $id_p = $this->db->insertID();

        foreach($kodes as $i => $kode) {
            $this->db->table('pembelian_detail')->insert([
                'id_pembelian' => $id_p, 'kode_barang' => $kode,
                'qty_beli' => $qtys[$i], 'harga_beli_satuan' => $belis[$i]
            ]);

            $cek = $this->db->table('stok_barang')->where('kode_barang', $kode)->get()->getRow();
            if($cek) {
                $this->db->table('stok_barang')->where('kode_barang', $kode)->update([
                    'jumlah_stok' => $cek->jumlah_stok + $qtys[$i],
                    'harga_beli_akhir' => $belis[$i], 'harga_jual_akhir' => $juals[$i]
                ]);
            } else {
                $this->db->table('stok_barang')->insert([
                    'kode_barang' => $kode, 'nama_barang' => $namas[$i], 'jumlah_stok' => $qtys[$i],
                    'harga_beli_akhir' => $belis[$i], 'harga_jual_akhir' => $juals[$i],
                    'estimasi_datang' => $this->request->getPost('estimasi')
                ]);
            }
        }
        $this->db->transComplete();
        return redirect()->back()->with('success', 'Berhasil!');
    }
}