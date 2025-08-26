<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MembershipTierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'tier_name' => 'Free',
                'price_monthly' => 0.00,
                'daily_scan_limit' => 10,
                'features' => json_encode(['model' => 'standard', 'history' => false, 'priority_analysis' => false])
            ],
            [
                'id' => 2,
                'tier_name' => 'Premium',
                'price_monthly' => 5.00,
                'daily_scan_limit' => null, // Unlimited
                'features' => json_encode(['model' => 'advanced', 'history' => true, 'priority_analysis' => true])
            ]
        ];

        $this->db->table('membership_tiers')->insertBatch($data);
    }
}
