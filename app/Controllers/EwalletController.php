<?php

namespace App\Controllers;

use App\Models\PenarikanEwalletModel;
use App\Models\RiwayatPointModel;
use App\Models\RiwayatSaldoModel;
use Myth\Auth\Models\UserModel;

class EwalletController extends BaseController
{
    protected $penarikanModel;
    protected $userModel;
    protected $riwayatPointModel;
    protected $riwayatSaldoModel;
    
    private static $validPoints = [250, 500, 1000];

    public function __construct()
    {
        $this->penarikanModel = new PenarikanEwalletModel();
        $this->userModel = new UserModel();
        $this->riwayatPointModel = new RiwayatPointModel();
        $this->riwayatSaldoModel = new RiwayatSaldoModel();
    }

    private function validatePoint($point) 
    {
        return in_array($point, self::$validPoints);
    }

    private function processStore($role)
    {
        $rules = [
            'jumlah_point' => 'required|numeric|greater_than[0]',
            'no_ewallet' => 'required|min_length[10]|max_length[13]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                            ->withInput()
                            ->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find(user()->id);
        $jumlahPoint = (int) $this->request->getPost('jumlah_point');

        if (!$this->validatePoint($jumlahPoint)) {
            return redirect()->back()
                            ->with('error', 'Jumlah point harus 250, 500, atau 1000 point');
        }
        if ($user->total_point < $jumlahPoint) {
            return redirect()->back()
                            ->with('error', 'Point tidak mencukupi');
        }

        $jumlahRupiah = $jumlahPoint * 100;

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            $newPoint = $user->total_point - $jumlahPoint;
            $this->userModel->update($user->id, ['total_point' => $newPoint]);

            if ($role === 'nasabah') {
                $this->riwayatPointModel->tambahRiwayat(
                    $user->id,
                    'penarikan_ewallet',
                    -$jumlahPoint,
                    'Penarikan ke DANA'
                );
            } else {
                $this->riwayatSaldoModel->tambahRiwayat(
                    $user->id,
                    'penarikan_ewallet',
                    -$jumlahRupiah,
                    'Penarikan ke DANA'
                );
            }
            $this->penarikanModel->insert([
                'user_id' => $user->id,
                'role' => $role,
                'jumlah_point' => $jumlahPoint,
                'jumlah_rupiah' => $jumlahRupiah,
                'no_ewallet' => $this->request->getPost('no_ewallet'),
                'status' => 'pending'
            ]);

            $db->transComplete();

            //riwayat
            $this->riwayatPointModel->tambahRiwayatPenarikan(
                user()->id,
                $jumlahPoint,
                $jumlahRupiah
            );

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal melakukan penarikan, coba lagi!');
            }
            $redirectPath = ($role === 'seller') ? '/seller' : '/user';
            return redirect()->to(base_url($redirectPath))
                            ->with('message', 'Permintaan penarikan berhasil disubmit, Silahkan cek di riwayat transaksi');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan penarikan!: ' . $e->getMessage());
        }
    }

    public function indexNasabah()
    {
        $data = [
            'title' => 'Tukar Point ke E-Wallet',
            'total_point' => user()->total_point,
            'riwayat' => $this->penarikanModel->getPenarikanByUser(user()->id),
            'role' => 'nasabah',
            'valid_points' => self::$validPoints
        ];
    
        return view('ewallet/index', $data);
    }
    
    public function indexSeller()
    {
        $data = [
            'title' => 'Penarikan Saldo ke E-Wallet',
            'total_point' => user()->total_point,
            'riwayat' => $this->penarikanModel->getPenarikanByUser(user()->id),
            'role' => 'seller',
            'valid_points' => self::$validPoints
        ];
    
        return view('ewallet/index', $data);
    }
    
    public function storeNasabah()
    {
        return $this->processStore('nasabah');
    }
    
    public function storeSeller()
    {
        return $this->processStore('seller');
    }
}