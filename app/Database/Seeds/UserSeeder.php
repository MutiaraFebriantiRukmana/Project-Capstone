<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
        {
            $data = [
                [
                    'username' => 'Aldi', 
                    'email'    => 'aldi23@gmail.com', 
                    'password' => password_hash('aldi123', PASSWORD_DEFAULT),
                    'role'     => 'owner'
                ],
                [
                    'username' => 'Nella', 
                    'email'    => 'nella422@gmail.com', 
                    'password' => password_hash('nella123', PASSWORD_DEFAULT),
                    'role'     => 'owner'
                ],
                [
                    'username' => 'Dina Khairani', 
                    'email'    => 'dinakai@gmail.com', 
                    'password' => password_hash('kairani123', PASSWORD_DEFAULT),
                    'role'     => 'admin'
                ],
            ];
            $this->db->table('users')->insertBatch($data);
        }

}