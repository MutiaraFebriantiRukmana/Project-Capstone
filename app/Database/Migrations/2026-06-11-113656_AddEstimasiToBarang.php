<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddEstimasiToBarang extends Migration {
    public function up() {
        $fields = [
            'estimasi_datang' => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'jumlah_barang'],
        ];
        $this->forge->addColumn('barang_masuk', $fields);
    }
    public function down() {
        $this->forge->dropColumn('barang_masuk', 'estimasi_datang');
    }
}