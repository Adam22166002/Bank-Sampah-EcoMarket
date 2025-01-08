<?php

namespace App\Models;

use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    protected $table            = 'verifikasi_admin';
    protected $primaryKey       = 'verifikasi_id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'admin_id', 'tipe', 'id_transaksi', 'status', 'keterangan'
    ];

}