<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPointModel extends Model
{
    protected $table            = 'riwayat_point';
    protected $primaryKey       = 'riwayat_point_id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'user_id', 'jenis', 'jumlah', 'keterangan'
    ];
    // Fungsi untuk menambah riwayat transaksi sampah
    public function tambahRiwayatTransaksiSampah($userId, $pointDapat, $beratSampah)
    {
        return $this->insert([
            'user_id' => $userId,
            'jenis' => 'transaksi_sampah',
            'jumlah' => $pointDapat,
            'keterangan' => "Mendapat {$pointDapat} point dari penjualan sampah {$beratSampah}kg",
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    //riwayat tukar produk
    public function tambahRiwayatTukarProduk($userId, $pointKeluar, $namaProduk)
    {
        return $this->insert([
            'user_id' => $userId,
            'jenis' => 'penukaran_produk',
            'jumlah' => -$pointKeluar,
            'keterangan' => "Penukaran produk {$namaProduk} seharga {$pointKeluar} point",
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    //riwayat penarikan ewallet
    public function tambahRiwayatPenarikan($userId, $pointKeluar, $jumlahRupiah)
    {
        return $this->insert([
            'user_id' => $userId,
            'jenis' => 'penarikan_ewallet',
            'jumlah' => -$pointKeluar,
            'keterangan' => "Penarikan point ke e-wallet senilai Rp " . number_format($jumlahRupiah),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    //riwayat point user dengan running balance
    public function getRiwayatLengkap($userId)
    {
        return $this->select('
            riwayat_point.*,
            users.username,
            (SELECT SUM(rp2.jumlah) 
             FROM riwayat_point rp2 
             WHERE rp2.created_at <= riwayat_point.created_at 
             AND rp2.user_id = riwayat_point.user_id) as running_balance
        ')
        ->join('users', 'users.id = riwayat_point.user_id')
        ->where('riwayat_point.user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->findAll();
    }
}