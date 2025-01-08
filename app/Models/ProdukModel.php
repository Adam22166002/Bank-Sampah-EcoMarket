<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'produk_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'nama_produk',
        'deskripsi',
        'harga_produk',
        'stok',
        'terjual',
        'foto_produk',
        'status',
        'admin_verifikasi_id', 
        'tanggal_verifikasi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $attributes = [
        'status' => 'pending'
    ];
    
    public function verifikasiProduk($id, $status, $admin_id)
    {
        return $this->update($id, [
            'status' => $status,
            'admin_verifikasi_id' => $admin_id,
            'tanggal_verifikasi' => date('Y-m-d H:i:s')
        ]);
    }

    public function getActiveProduk()
    {
        return $this->select('produk.*, users.fullname as seller_name')
            ->join('users', 'users.id = produk.user_id')
            ->where('produk.status', 'active')
            ->where('produk.stok >', 0)
            ->findAll();
    }

    public function getProdukBySeller($user_id)
    {
        return $this->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function updateStock($produk_id, $quantity, $is_sold = false)
    {
        $produk = $this->find($produk_id);
        if ($produk) {
            $data = ['stok' => $produk['stok'] - $quantity];
            if ($is_sold) {
                $data['terjual'] = $produk['terjual'] + $quantity;
            }
            return $this->update($produk_id, $data);
        }
        return false;
    }

    public function getTopProducts($limit = 5)
    {
        return $this->select('produk.*, 
            users.fullname as seller_name,
            COUNT(penukaran_produk.penukaran_id) as total_ditukar')
            ->join('users', 'users.id = produk.user_id')
            ->join('penukaran_produk', 'penukaran_produk.produk_id = produk.produk_id', 'left')
            ->where('produk.status', 'active')
            ->groupBy('produk.produk_id')
            ->orderBy('total_ditukar', 'DESC')
            ->limit($limit)
            ->findAll();
    }

public function getSellerStats($user_id)
{
    return $this->select('
        COUNT(*) as total_produk,
        SUM(stok) as total_stok,
        SUM(terjual) as total_terjual,
        SUM(terjual * harga_produk) as total_pendapatan')
        ->where('user_id', $user_id)
        ->first();
}
public function getPenarikanByUser($userId)
    {
        return $this->select('penarikan_ewallet.*, users.username')
                    ->join('users', 'users.id = penarikan_ewallet.user_id')
                    ->where('penarikan_ewallet.user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

}
