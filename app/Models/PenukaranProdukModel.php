<?php

namespace App\Models;

use CodeIgniter\Model;

class PenukaranProdukModel extends Model
{
    protected $table            = 'penukaran_produk';
    protected $primaryKey       = 'penukaran_id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'user_id', 'produk_id', 'nama_produk', 'point_tukar',
        'qr_code', 'status', 'tanggal_tukar', 'tanggal_verifikasi',
        'admin_id', 'keterangan'
    ];

    public function getPenukaranByUser($userId)
    {
        return $this->select('penukaran_produk.*, users.username, produk.nama_produk')
                    ->join('users', 'users.id = penukaran_produk.user_id')
                    ->join('produk', 'produk.produk_id = penukaran_produk.produk_id')
                    ->where('penukaran_produk.user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getPendingPenukaran()
    {
        return $this->select('penukaran_produk.*, users.username, produk.nama_produk')
                    ->join('users', 'users.id = penukaran_produk.user_id')
                    ->join('produk', 'produk.produk_id = penukaran_produk.produk_id')
                    ->where('penukaran_produk.status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
    public function getRiwayatPenukaran($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}