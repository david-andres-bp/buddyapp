<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'username', 
        'email', 
        'password_hash', 
        'tier_id', 
        'api_calls_today', 
        'last_api_call_date'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Finds a user by their email address or username.
     *
     * @param string $loginIdentifier
     * @return array|null
     */
    public function findUserByEmailOrUsername(string $loginIdentifier): ?array
    {
        return $this->where('email', $loginIdentifier)
                    ->orWhere('username', $loginIdentifier)
                    ->first();
    }

    public function getUserWithTier(int $userId): ?array
    {
        return $this->select('users.*, membership_tiers.tier_name, membership_tiers.price_monthly, membership_tiers.daily_scan_limit, membership_tiers.features')
            ->join('membership_tiers', 'membership_tiers.id = users.tier_id')
            ->where('users.id', $userId)
            ->first();
    }
}