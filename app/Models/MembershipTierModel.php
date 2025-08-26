<?php

namespace App\Models;

use CodeIgniter\Model;

class MembershipTierModel extends Model
{
    protected $table = 'membership_tiers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tier_name', 'price_monthly', 'daily_scan_limit', 'features'];
}
