<?php

namespace App\Controllers;

use App\Models\PenarikanEwalletModel;
use App\Models\PenukaranProdukModel;
use App\Models\ProdukModel;
use App\Models\TransaksiSampahModel;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $produkModel;
    protected $penukaranModel;
    protected $userModel;
    protected $penarikanModel;
    protected $transaksiModel;
    protected $db;

    public function __construct()
    {
        if (!in_groups('nasabah')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->produkModel = new ProdukModel();
        $this->penukaranModel = new PenukaranProdukModel();
        $this->userModel = new UserModel();
        $this->penarikanModel = new PenarikanEwalletModel();
        $this->transaksiModel = new TransaksiSampahModel();
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        $data['title'] = 'User';
        $db = \Config\Database::connect();
        $username = session()->get('username');

        $builder = $db->table('transaksi_sampah');

        $result = $builder->select('SUM(point_sampah_dijual) AS total_point')
                        ->where('username', $username)
                        ->get()
                        ->getRow(); 

        $data['totalPoint'] = $result->total_point ?? 0;
        $dataa = [
            'title' => 'Penarikan Saldo ke E-Wallet',
            'total_point' => user()->total_point,
            'riwayat' => $this->penarikanModel->getPenarikanByUser(user()->id),
            'role' => 'nasabah'
        ];

        return view('user/index', $data);
    }

    public function tukarProduk()
    {
        $data = [
            'title' => 'Tukar Produk',
            'products' => $this->produkModel->getActiveProduk(),
            'totalPoint' => $this->transaksiModel->getTotalPointUser(user()->username),
            'penukaran' => $this->penukaranModel->getPenukaranByUser(user()->id)
        ];

        return view('user/tukar_produk', $data);
    }

    public function jualSampah(): string
    {
        return view('user/jual_sampah');
    }
    public function tentangKita(): string
    {
        $data['title'] = 'User';
        return view('user/tentang_kita', $data);
    }
}
