<?php 

namespace App\Controllers;

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
                        ->join('stok_barang s', 'd.kode_barang = s.kode_barang', 'left') 
                        ->select('d.*, m.no_invoice, m.tgl_pembelian, m.supplier, s.nama_barang')
                        ->orderBy('m.tgl_pembelian', 'DESC')
                        ->get()->getResultArray()
        ];
        return view('owner/detail_barang', $data);
    }

    public function cek_barang($kode) {
        $barang = $this->db->table('stok_barang')->where('kode_barang', $kode)->get()->getRow();
        $history = $this->db->table('pembelian_detail d')
            ->join('pembelian_master m', 'd.id_pembelian = m.id_pembelian')
            ->where('d.kode_barang', $kode)
            ->orderBy('m.tgl_pembelian', 'DESC')
            ->select('m.supplier')->get()->getRow();

        return $this->response->setJSON([
            'status'   => ($barang || $history) ? true : false,
            'nama'     => $barang ? $barang->nama_barang : '',
            'harga'    => $barang ? $barang->harga_jual_akhir : '',
            'supplier' => $history ? $history->supplier : ''
        ]);
    }

    public function save() {
        $invoice = 'INV-IN-' . strtoupper(substr(md5(time()), 0, 6));
        $kodes = $this->request->getPost('kode_barang');
        $namas = $this->request->getPost('nama_barang');
        $qtys  = $this->request->getPost('qty');
        $belis = $this->request->getPost('harga_beli');
        $juals = $this->request->getPost('harga_jual');

        if (empty($kodes)) {
            return redirect()->back()->with('error', 'Form barang masih kosong!');
        }

        try {
            $this->db->transStart();
            
            //Simpan Master Pembelian
            $this->db->table('pembelian_master')->insert([
                'no_invoice' => $invoice, 
                'supplier' => $this->request->getPost('supplier'),
                'total_bayar' => $this->request->getPost('total_invoice'),
                'tgl_pembelian' => date('Y-m-d H:i:s'), 
                'added_by' => session()->get('username') ?? 'Admin'
            ]);
            $id_p = $this->db->insertID();

            foreach($kodes as $i => $kode) {
                // CEK & UPDATE STOK 
                $cek = $this->db->table('stok_barang')->where('kode_barang', $kode)->get()->getRow();
                
                if($cek) {
                    $this->db->table('stok_barang')->where('kode_barang', $kode)->update([
                        'jumlah_stok' => $cek->jumlah_stok + $qtys[$i],
                        'harga_beli_akhir' => $belis[$i], 
                        'harga_jual_akhir' => $juals[$i]
                    ]);
                } else {
                    $this->db->table('stok_barang')->insert([
                        'kode_barang' => $kode, 
                        'nama_barang' => $namas[$i], 
                        'jumlah_stok' => $qtys[$i],
                        'harga_beli_akhir' => $belis[$i], 
                        'harga_jual_akhir' => $juals[$i],
                        'estimasi_datang' => $this->request->getPost('estimasi') ?? 3
                    ]);
                }

                // 3. BARU SIMPAN DETAILNYA
                $this->db->table('pembelian_detail')->insert([
                    'id_pembelian' => $id_p, 
                    'kode_barang' => $kode,
                    'qty_beli' => $qtys[$i], 
                    'harga_beli_satuan' => $belis[$i]
                ]);
            }
            
            $this->db->transComplete();

            if ($this->db->transStatus() === FALSE) {
                // Ambil pesan error asli dari database untuk debug
                $error = $this->db->error();
                return redirect()->back()->with('error', 'Gagal Simpan! Pesan Database: ' . $error['message']);
            }

            return redirect()->back()->with('success', 'Berhasil update stok dan master barang!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}