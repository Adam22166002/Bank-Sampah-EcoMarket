<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatSaldoModel extends Model
{
    protected $table            = 'riwayat_saldo';
    protected $primaryKey       = 'riwayat_saldo_id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'user_id', 'jenis', 'jumlah', 'keterangan'
    ];

    public function getRiwayatBySeller($userId)
    {
        return $this->select('riwayat_saldo.*, users.username')
                    ->join('users', 'users.id = riwayat_saldo.user_id')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function tambahRiwayat($userId, $jenis, $jumlah, $keterangan = null)
    {
        return $this->insert([
            'user_id' => $userId,
            'jenis' => $jenis,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ]);
    }
}