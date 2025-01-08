<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanEwalletModel extends Model
{
    protected $table            = 'penarikan_ewallet';
    protected $primaryKey       = 'penarikan_id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'user_id', 'role', 'jumlah_point', 'jumlah_rupiah', 
        'no_ewallet', 'status', 'tanggal_verifikasi', 'admin_id', 'keterangan'
    ];

    public function getPenarikanByUser($userId)
    {
        return $this->select('penarikan_ewallet.*, users.username')
                    ->join('users', 'users.id = penarikan_ewallet.user_id')
                    ->where('penarikan_ewallet.user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getPendingPenarikan()
    {
        return $this->select('penarikan_ewallet.*, users.username, users.email')
                    ->join('users', 'users.id = penarikan_ewallet.user_id')
                    ->where('penarikan_ewallet.status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}