<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateInventorySystem extends Migration {
    public function up() {
        // 1. Stok Pusat (Saldo Akhir)
        $this->forge->addField([
            'id_stok' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'kode_barang' => ['type'=>'VARCHAR','constraint'=>20,'unique'=>true],
            'nama_barang' => ['type'=>'VARCHAR','constraint'=>100],
            'jumlah_stok' => ['type'=>'INT','default'=>0],
            'harga_beli_akhir' => ['type'=>'DECIMAL','constraint'=>'12,2','default'=>0],
            'harga_jual_akhir' => ['type'=>'DECIMAL','constraint'=>'12,2','default'=>0],
            'estimasi_datang' => ['type'=>'INT','default'=>0],
        ]);
        $this->forge->addKey('id_stok', true); $this->forge->createTable('stok_barang');

        // 2. Pembelian Master (Invoice Masuk - Owner)
        $this->forge->addField([
            'id_pembelian' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'no_invoice' => ['type'=>'VARCHAR','constraint'=>50],
            'supplier' => ['type'=>'VARCHAR','constraint'=>100],
            'total_bayar' => ['type'=>'DECIMAL','constraint'=>'12,2'],
            'tgl_pembelian' => ['type'=>'DATETIME'],
            'added_by' => ['type'=>'VARCHAR','constraint'=>50],
        ]);
        $this->forge->addKey('id_pembelian', true); $this->forge->createTable('pembelian_master');

        // 3. Pembelian Detail (Isi Invoice Masuk)
        $this->forge->addField([
            'id_pembelian_detail' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'id_pembelian' => ['type'=>'INT','unsigned'=>true],
            'kode_barang' => ['type'=>'VARCHAR','constraint'=>20],
            'qty_beli' => ['type'=>'INT'],
            'harga_beli_satuan' => ['type'=>'DECIMAL','constraint'=>'12,2'],
        ]);
        $this->forge->addKey('id_pembelian_detail', true); $this->forge->createTable('pembelian_detail');

        // 4. Penjualan Master (Invoice Keluar - Admin)
        $this->forge->addField([
            'id_penjualan' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'no_invoice' => ['type'=>'VARCHAR','constraint'=>50],
            'tgl_keluar' => ['type'=>'DATETIME'],
            'added_by' => ['type'=>'VARCHAR','constraint'=>50],
        ]);
        $this->forge->addKey('id_penjualan', true); $this->forge->createTable('penjualan_master');

        // 5. Penjualan Detail (Sub Barang Keluar)
        $this->forge->addField([
            'id_penjualan_detail' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'id_penjualan' => ['type'=>'INT','unsigned'=>true],
            'id_stok' => ['type'=>'INT','unsigned'=>true],
            'qty_jual' => ['type'=>'INT'],
            'harga_jual_satuan' => ['type'=>'DECIMAL','constraint'=>'12,2'],
            'total_harga' => ['type'=>'DECIMAL','constraint'=>'12,2'],
        ]);
        $this->forge->addKey('id_penjualan_detail', true); $this->forge->createTable('penjualan_detail');

        // 6. Log Cetak Laporan
        $this->forge->addField([
            'id_log' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'nama_pencetak' => ['type'=>'VARCHAR','constraint'=>50],
            'tgl_awal' => ['type'=>'DATE'],
            'tgl_akhir' => ['type'=>'DATE'],
            'tgl_cetak' => ['type'=>'DATETIME'],
        ]);
        $this->forge->addKey('id_log', true); $this->forge->createTable('cetak_log');
    }
    public function down() { /* refresh handle this */ }
}