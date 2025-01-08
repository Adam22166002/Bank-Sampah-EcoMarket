<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiSampahModel extends Model
{
    protected $table            = 'transaksi_sampah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'kategori',
        'berat_sampah',
        'lokasi',
        'harga_per_kg',
        'point_sampah_dijual',
        'bukti_foto',
        'status',
        'admin_id',
        'tanggal_verifikasi',
        'keterangan',
        'created_at',  
        'updated_at'   
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    public function kategoriSampah()
    {
        return $this->belongsTo(KategoriSampahModel::class, 'kategori', 'kategori_id');
        return $this->belongsTo(KategoriSampahModel::class, 'harga_per_kg', 'kategori_id');

    }
    
    public function getTotalPointUser($username)
    {
        return $this->selectSum('point_sampah_dijual')
                    ->where('username', $username)
                    ->where('status', 'approved')
                    ->get()
                    ->getRow()
                    ->point_sampah_dijual ?? 0;
    }

    public function getTransaksiByUsername($username)
    {
        return $this->select('transaksi_sampah.*, kategori_sampah.nama_kategori, users.fullname as admin_name')
            ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
            ->join('users', 'users.id = transaksi_sampah.admin_id', 'left')
            ->where('transaksi_sampah.username', $username)
            ->orderBy('transaksi_sampah.created_at', 'DESC')
            ->findAll();
    }
    
    public function getTransaksiByUser($username)
{
    return $this->select('transaksi_sampah.*, kategori_sampah.nama_kategori')
                ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
                ->where('transaksi_sampah.username', $username)
                ->orderBy('transaksi_sampah.created_at', 'DESC')
                ->find();
}

    public function getPendingTransaksi()
    {
        return $this->select('transaksi_sampah.*, kategori_sampah.nama_kategori, users.fullname')
            ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
            ->join('users', 'users.username = transaksi_sampah.username')
            ->where('transaksi_sampah.status', 'pending')
            ->orderBy('transaksi_sampah.created_at', 'ASC')
            ->findAll();
    }

    public function verifyTransaksi($id, $admin_id, $status, $keterangan = null)
    {
        return $this->update($id, [
            'status' => $status,
            'admin_id' => $admin_id,
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan
        ]);
    }

    public function getTransaksiStats($username)
    {

        return $this->select('
            COUNT(*) as total_transaksi,
            SUM(berat_sampah) as total_berat,
            SUM(point_sampah_dijual) as total_point,
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count,
            COUNT(CASE WHEN status = "approved" THEN 1 END) as approved_count
        ')->where('username', $username)->first();
    }

    public function countTransaksiByUser($username, $filter = [])
    {
        $builder = $this->where('username', $username);
        if (!empty($filter['status'])) {
            $builder->where('status', $filter['status']);
        }
        if (!empty($filter['date_from'])) {
            $builder->where('DATE(created_at) >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $builder->where('DATE(created_at) <=', $filter['date_to']);
        }

        return $builder->countAllResults();
    }

public function getTransaksiReport($period = 'daily')
{
    $groupBy = ($period == 'daily') ? 'DATE(transaksi_sampah.created_at)' : 'MONTH(transaksi_sampah.created_at)';
    return $this->select("
        $groupBy as period,
        COUNT(*) as total_transaksi,
        SUM(berat_sampah) as total_berat,
        SUM(point_sampah_dijual) as total_point
    ")->groupBy($groupBy)->findAll();
}
}
