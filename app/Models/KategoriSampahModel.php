<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriSampahModel extends Model
{
    protected $table            = 'kategori_sampah';
    protected $primaryKey       = 'kategori_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_kategori',
        'harga_per_kg',
        'deskripsi',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveKategori()
    {
        return $this->where('status', 'active')->findAll();
    }
    public function getKategoriWithStats()
    {
        return $this->select('kategori_sampah.*, 
            COUNT(transaksi_sampah.id) as total_transaksi,
            SUM(transaksi_sampah.point_sampah_dijual) as total_point')
            ->join('transaksi_sampah', 'transaksi_sampah.kategori = kategori_sampah.kategori_id', 'left')
            ->groupBy('kategori_sampah.kategori_id');
    }

    public function tbl_kategori()
    {
        return $this->belongsTo(TransaksiSampahModel::class);
    }
}
