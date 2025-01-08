<?php

namespace App\Controllers;

use App\Models\PenarikanEwalletModel;
use App\Models\PenukaranProdukModel;
use App\Models\RiwayatPointModel;
use App\Models\RiwayatSaldoModel;

class RiwayatController extends BaseController
{
    protected $riwayatPointModel;
    protected $riwayatSaldoModel;
    protected $penarikanModel;
    protected $penukaranModel;

    public function __construct()
    {
        $this->riwayatPointModel = new RiwayatPointModel();
        $this->riwayatSaldoModel = new RiwayatSaldoModel();
        $this->penarikanModel = new PenarikanEwalletModel();
        $this->penukaranModel = new PenukaranProdukModel();
    }

    public function riwayatPoint()
    {
        $data = [
            'title' => 'Riwayat Point',
            'riwayat' => $this->riwayatPointModel->getRiwayatLengkap(user()->id),
            'penukaran' => $this->penukaranModel->getRiwayatPenukaran(user()->id)
        ];

        return view('user/riwayat_point', $data);
        
    }

    public function riwayatSaldo()
    {
        if (!in_groups('seller')) {
            return redirect()->back();
        }

        $data = [
            'title' => 'Riwayat Saldo',
            'riwayat' => $this->riwayatSaldoModel->getRiwayatBySeller(user()->id)
        ];

        return view('seller/riwayat_saldo', $data);
    }
    public function RiwayatPenarikan()
    {
        $data = [
            'title' => 'Tukar Point ke E-Wallet',
            'total_point' => user()->total_point,
            'riwayat' => $this->penarikanModel->getPenarikanByUser(user()->id),
            'role' => 'nasabah'
        ];
    
        return view('riwayat_transaksi', $data);
    }
}