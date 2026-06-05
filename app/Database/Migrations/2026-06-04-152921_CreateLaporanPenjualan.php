<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanPenjualan extends Migration
{
    // app/Database/Migrations/xxxx_CreateLaporanPenjualan.php
    public function up()
    {
        $this->forge->addField([
            'id_laporan'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'id_barang'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah_terjual' => ['type' => 'INT', 'constraint' => 11],
            'harga_satuan'   => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'total'          => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['Terjual', 'Dihapus'], 'default' => 'Terjual'],
            'added_by'       => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_laporan', true);
        $this->forge->createTable('laporan_penjualan');
    }
    public function down() { $this->forge->dropTable('laporan_penjualan'); }
}