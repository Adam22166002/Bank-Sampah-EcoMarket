<?php

namespace App\Controllers;

use App\Models\PenukaranProdukModel;
use App\Models\ProdukModel;
use App\Models\RiwayatPointModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PenukaranController extends BaseController
{
    protected $penukaranModel;
    protected $produkModel;
    protected $riwayatPointModel;

    public function __construct()
    {
        $this->penukaranModel = new PenukaranProdukModel();
        $this->produkModel = new ProdukModel();
        $this->riwayatPointModel = new RiwayatPointModel();
    }

    public function tukarProduk($produkId)
{
    try {
        // 1. Validasi produk
        $produk = $this->produkModel->find($produkId);
        if (!$produk || $produk['status'] !== 'active') {
            throw new \Exception('Produk tidak tersedia');
        }

        // 2. Validasi point user
        $userModel = new \Myth\Auth\Models\UserModel();
        $user = $userModel->find(user()->id);
        if ($user->total_point < $produk['harga_produk']) {
            return redirect()->back()->with('error', 'Point anda tidak mencukupi');
        }

        // 3. Generate QR Code
        $qrData = json_encode([
            'user_id' => user()->id,
            'username' => user()->username,
            'produk_id' => $produkId,
            'nama_produk' => $produk['nama_produk'],
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        $qrCode = new QrCode($qrData);
        $writer = new PngWriter();
        $qrFilename = 'QR_' . time() . '_' . user()->id . '.png';
        $result = $writer->write($qrCode);
        $result->saveToFile(FCPATH . 'uploads/qrcodes/' . $qrFilename);

        // 4. Mulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // Kurangi point user
        $newPoint = $user->total_point - $produk['harga_produk'];
        $userModel->update(user()->id, ['total_point' => $newPoint]);

        // Simpan data penukaran
        $this->penukaranModel->insert([
            'user_id' => user()->id,
            'produk_id' => $produkId,
            'nama_produk' => $produk['nama_produk'],
            'point_tukar' => $produk['harga_produk'],
            'qr_code' => $qrFilename,
            'status' => 'pending',
            'tanggal_tukar' => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        $this->riwayatPointModel->tambahRiwayatTukarProduk(
            user()->id,
            $produk['harga_produk'],
            $produk['nama_produk']
        );

        if ($db->transStatus() === false) {
            throw new \Exception('Gagal melakukan penukaran');
        }

        return redirect()->to(base_url('tukarProduk'))->with('success', 'Penukaran produk berhasil, harap menunggu verifikasi admin');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    public function riwayatPenukaran()
    {
        $data = [
            'title' => 'Riwayat Penukaran',
            'penukaran' => $this->penukaranModel->getPenukaranByUser(user()->id)
        ];

        return view('user/riwayat_penukaran', $data);
    }
    
    public function detailPenukaran($id)
    {
        $penukaran = $this->penukaranModel->find($id);
        
        if (!$penukaran || $penukaran['user_id'] !== user()->id) {
            return redirect()->back()
                           ->with('error', 'Data penukaran tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Penukaran',
            'penukaran' => $penukaran
        ];

        return view('user/detail_penukaran', $data);
    }
}