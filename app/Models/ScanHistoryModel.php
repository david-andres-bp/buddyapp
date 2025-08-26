<?php

namespace App\Models;

use CodeIgniter\Model;

class ScanHistoryModel extends Model
{
    protected $table            = 'scan_history';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'scan_date',
        'content_text',
        'verdict',
        'analysis',
        'recommendations'
    ];

    /**
     * Saves a scan result to the database.
     *
     * @param int $userId
     * @param string|null $contentText
     * @param array $scanResult
     * @return bool
     */
    public function saveScan(int $userId, ?string $contentText, array $scanResult): bool
    {
        $data = [
            'user_id' => $userId,
            'content_text' => $contentText,
            'verdict' => $scanResult['verdict'] ?? 'N/A',
            'analysis' => json_encode($scanResult['analysis'] ?? []),
            'recommendations' => json_encode($scanResult['recommendations'] ?? [])
        ];

        return $this->insert($data);
    }

    /**
     * Retrieves the scan history for a specific user.
     *
     * @param int $userId
     * @return array
     */
    public function getHistoryForUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('scan_date', 'DESC')
                    ->findAll();
    }
}
