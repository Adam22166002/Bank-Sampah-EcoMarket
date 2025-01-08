<?php

namespace App\Controllers;

use App\Models\PenarikanEwalletModel;
use App\Models\ProdukModel;

class Seller extends BaseController
{
    protected $produkModel;
    protected $penarikanModel;

    public function __construct()
    {
        if (!in_groups('seller')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->produkModel = new ProdukModel();
        $this->penarikanModel = new PenarikanEwalletModel();
    }

    public function index()
    {
        $userId = user()->id;
        
        $data = [
            'title' => 'Seller Dashboard',
            'products' => $this->produkModel->where('user_id', $userId)->findAll(),
            'stats' => $this->produkModel->getSellerStats($userId),
            'title' => 'Penarikan Saldo ke E-Wallet',
            'total_point' => user()->total_point,
            'riwayat' => $this->penarikanModel->getPenarikanByUser(user()->id),
            'role' => 'seller'
        ];
        
        return view('seller/index', $data );
    }

    public function riwayatTransaksi(): string
    {
        return view('seller/riwayat_transaksi');
    }
    
}
