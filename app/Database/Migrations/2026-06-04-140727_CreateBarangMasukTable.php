<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarangMasukTable extends Migration
{
   public function up()
        {
            $this->forge->addField([
                'id_barang'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'kode_barang'   => ['type' => 'VARCHAR', 'constraint' => 20],
                'nama_barang'   => ['type' => 'VARCHAR', 'constraint' => 100],
                'harga_beli'    => ['type' => 'DECIMAL', 'constraint' => '12,2'],
                'harga_jual'    => ['type' => 'DECIMAL', 'constraint' => '12,2'],
                'jumlah_barang' => ['type' => 'INT'],
                'added_by'      => ['type' => 'VARCHAR', 'constraint' => 100], 
                'created_at'    => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id_barang', true);
            $this->forge->createTable('barang_masuk');
        }

    public function down() 
        { 
            $this->forge->dropTable('barang_masuk'); 
        }
}
