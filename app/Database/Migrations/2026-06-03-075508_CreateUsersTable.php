<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
        {
            $this->forge->addField([
                'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'username'    => ['type' => 'VARCHAR', 'constraint' => 100], // Tetap ada username
                'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true], // Login pakai ini
                'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
                'role'        => ['type' => 'ENUM', 'constraint' => ['owner', 'admin'], 'default' => 'admin'],
                'created_at'  => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('users');
        }

        public function down() { $this->forge->dropTable('users'); }
    }
