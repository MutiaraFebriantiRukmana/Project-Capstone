<?php

namespace App\Controllers;

class Penjualan extends BaseController
{
    protected $db;
    public function __construct() { $this->db = \Config\Database::connect(); }

    public function index()
    {
        $role = session()->get('role');
        // Ambil data penjualan beserta detailnya
        $data['penjualan'] = $this->db->table('penjualan_master')
            ->orderBy('tgl_keluar', 'DESC')->get()->getResultArray();
            
        // Ambil stok untuk pilihan di modal
        $data['stok'] = $this->db->table('stok_barang')->where('jumlah_stok >', 0)->get()->getResultArray();
        $data['title'] = 'Barang Keluar';

        return view($role . '/barang_keluar', $data);
    }

    public function save()
    {
        $ids    = $this->request->getPost('id_stok');
        $qtys   = $this->request->getPost('qty');
        $role   = session()->get('role');

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih barang terlebih dahulu!');
        }

        try {
            $this->db->transStart();

            //  Buat Master Penjualan
            $invoice = 'INV-OUT-' . strtoupper(substr(md5(time()), 0, 6));
            $this->db->table('penjualan_master')->insert([
                'no_invoice' => $invoice,
                'tgl_keluar' => date('Y-m-d H:i:s'),
                'added_by'   => session()->get('username') ?? 'Admin'
            ]);
            $id_penjualan = $this->db->insertID();

            foreach ($ids as $i => $id_stok) {
                // Ambil data stok untuk ambil harga
                $stok = $this->db->table('stok_barang')->where('id_stok', $id_stok)->get()->getRow();
                
                if ($stok->jumlah_stok < $qtys[$i]) {
                    return redirect()->back()->with('error', 'Stok ' . $stok->nama_barang . ' tidak cukup!');
                }

                $total_harga = $qtys[$i] * $stok->harga_jual_akhir;
                $total_modal = $qtys[$i] * $stok->harga_beli_akhir;
                $laba = $total_harga - $total_modal;

                // Simpan Detail Penjualan
                $this->db->table('penjualan_detail')->insert([
                    'id_penjualan'    => $id_penjualan,
                    'id_stok'         => $id_stok,
                    'qty_jual'        => $qtys[$i],
                    'harga_jual_satuan' => $stok->harga_jual_akhir,
                    'total_harga'     => $total_harga,
                    'harga_beli_saat_itu' => $stok->harga_beli_akhir,
                    'laba'            => $laba,
                    'status'          => 'Terjual'
                ]);

                // Potong Stok
                $this->db->table('stok_barang')->where('id_stok', $id_stok)->update([
                    'jumlah_stok' => $stok->jumlah_stok - $qtys[$i]
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === FALSE) {
                return redirect()->back()->with('error', 'Gagal memproses penjualan!');
            }

            return redirect()->to('/' . $role . '/barang-keluar')->with('success', 'Penjualan Berhasil!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}