<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestUsageModel extends Model
{
    protected $table            = 'guest_usage';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['ip_address', 'scan_count', 'month', 'year'];
    protected $updatedField     = 'updated_at';

    public function canGuestScan(string $ipAddress): bool
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        $limit = 5; // Guest limit: 2 scans per month

        $usage = $this->where('ip_address', $ipAddress)
                      ->where('month', $currentMonth)
                      ->where('year', $currentYear)
                      ->first();

        if ($usage && $usage['scan_count'] >= $limit) {
            return false;
        }
        
        return true;
    }

    public function incrementGuestUsage(string $ipAddress)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $usage = $this->where('ip_address', $ipAddress)
                      ->where('month', $currentMonth)
                      ->where('year', $currentYear)
                      ->first();

        if ($usage) {
            $this->update($usage['id'], ['scan_count' => $usage['scan_count'] + 1]);
        } else {
            $this->insert([
                'ip_address' => $ipAddress,
                'scan_count' => 1,
                'month'      => $currentMonth,
                'year'       => $currentYear,
            ]);
        }
    }
}