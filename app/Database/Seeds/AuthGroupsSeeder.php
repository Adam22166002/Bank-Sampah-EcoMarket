<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthGroupsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'description' => 'Site Administrator'
            ],
            [
                'name' => 'nasabah',
                'description' => 'Bank Sampah Customer'
            ],
            [
                'name' => 'seller',
                'description' => 'Product Seller'
            ]
        ];

        $this->db->table('auth_groups')->insertBatch($data);
    }
}