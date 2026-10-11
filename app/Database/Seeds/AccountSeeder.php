<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        if ($this->db->table('customers')->countAllResults() === 0) {
            $this->db->table('customers')->insertBatch([
                ['full_name' => 'Avery Johnson', 'email' => 'avery@example.com', 'phone' => '555-0101', 'created_at' => $createdAt],
                ['full_name' => 'Jordan Lee', 'email' => 'jordan@example.com', 'phone' => '555-0102', 'created_at' => $createdAt],
                ['full_name' => 'Morgan Reyes', 'email' => 'morgan@example.com', 'phone' => '555-0103', 'created_at' => $createdAt],
                ['full_name' => 'Taylor Chen', 'email' => 'taylor@example.com', 'phone' => '555-0104', 'created_at' => $createdAt],
                ['full_name' => 'Casey Patel', 'email' => 'casey@example.com', 'phone' => null, 'created_at' => $createdAt],
            ]);
        }

        if ($this->db->table('users')->countAllResults() === 0) {
            $this->db->table('users')->insertBatch([
                ['username' => 'arivera', 'full_name' => 'Alex Rivera', 'email' => 'alex.rivera@example.com', 'avatar' => null, 'created_at' => $createdAt],
                ['username' => 'skim', 'full_name' => 'Sam Kim', 'email' => 'sam.kim@example.com', 'avatar' => null, 'created_at' => $createdAt],
                ['username' => 'jbrooks', 'full_name' => 'Jamie Brooks', 'email' => 'jamie.brooks@example.com', 'avatar' => null, 'created_at' => $createdAt],
                ['username' => 'rsingh', 'full_name' => 'Robin Singh', 'email' => 'robin.singh@example.com', 'avatar' => null, 'created_at' => $createdAt],
                ['username' => 'dwilson', 'full_name' => 'Drew Wilson', 'email' => 'drew.wilson@example.com', 'avatar' => null, 'created_at' => $createdAt],
            ]);
        }
    }
}
