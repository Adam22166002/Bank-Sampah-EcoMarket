<?php

namespace App\Controllers;

use App\Models\KategoriSampahModel;
use App\Models\NotifikasiModel;
use App\Models\TransaksiSampahModel;
use Myth\Auth\Models\UserModel;

class TransaksiController extends BaseController
{
    protected $db, $builder;
    protected $kategoriModel;
    protected $transaksiModel;
    protected $notificationController;
    protected $userModel;
    protected $notifikasiModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->kategoriModel = new KategoriSampahModel();
        $this->transaksiModel = new TransaksiSampahModel();
        $this->userModel = new UserModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->notificationController = new NotificationController();
    }
    public function create()
{
    $data = [
        'title' => 'Jual Sampah',
        'user' => user(),
        'kategoris' => $this->kategoriModel->findAll(), 
        'transaksi' => $this->transaksiModel->getTransaksiByUser(user()->username),
        'stats' => $this->transaksiModel->getTransaksiStats(user()->username)
    ];

    return view('user/jual_sampah', $data);

}
    public function getHarga($kategori_id)
    {
        $kategori = $this->kategoriModel->find($kategori_id);
        if (!$kategori) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ])->setStatusCode(404);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'harga' => $kategori['harga_per_kg']
        ]);
    }

    public function store()
    {
        $validationRules = [
            'kategori' => 'required|numeric',
            'berat_sampah' => 'required|numeric|greater_than[0]',
            'lokasi' => 'required|min_length[5]',
            'bukti_foto' => [
                'rules' => 'uploaded[bukti_foto]|is_image[bukti_foto]|mime_in[bukti_foto,image/jpg,image/jpeg,image/png]|max_size[bukti_foto,2048]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format file harus JPG/PNG',
                    'max_size' => 'Ukuran file maksimal 2MB'
                ]
            ]
        ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()
                        ->withInput()
                        ->with('errors', $this->validator->getErrors());
    }

    try {
        $this->db->transStart();

        $foto = $this->request->getFile('bukti_foto');
        $fotoName = $foto->getRandomName();
        $foto->move('uploads/bukti', $fotoName);

        $kategori = $this->kategoriModel->find($this->request->getPost('kategori'));
        if (!$kategori) {
            throw new \Exception('Kategori tidak ditemukan');
        }

        $berat = $this->request->getPost('berat_sampah');
        $point = floor($berat * $kategori['harga_per_kg'] / 100);

        $data = [
            'username' => user()->username,
            'kategori' => $kategori['kategori_id'],
            'berat_sampah' => $berat,
            'lokasi' => $this->request->getPost('lokasi'),
            'harga_per_kg' => $kategori['harga_per_kg'],
            'point_sampah_dijual' => $point,
            'bukti_foto' => $fotoName,
            'status' => 'pending'
        ];

        if (!$this->transaksiModel->insert($data)) {
            throw new \Exception('Gagal menyimpan transaksi');
        }

        // Kirim notifikasi ke admin
        $notificationController = new NotificationController();
        $notificationController->notifyNewTransaction([
            'id' => $this->transaksiModel->getInsertID(),
            'username' => user()->username,
            'berat_sampah' => $berat
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \Exception('Transaksi database gagal');
        }

        return redirect()->to('/jualSampah')
                        ->with('message', 'Transaksi sampah berhasil ditambahkan! Silakan tunggu verifikasi admin.');

    } catch (\Exception $e) {
        $this->db->transRollback();
        log_message('error', '[TransaksiController::store] ' . $e->getMessage());
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal menambahkan transaksi: ' . $e->getMessage());
    }
}

    public function verifikasiTransaksi($id)
    {
        try {
            $status = $this->request->getPost('status');
            $admin_id = user()->id;
            
            $transaksi = $this->transaksiModel->find($id);
            if (!$transaksi) {
                throw new \Exception('Transaksi tidak ditemukan');
            }

            $this->db->transStart();

            // Update status transaksi
            $updateData = [
                'status' => $status,
                'admin_id' => $admin_id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ];

            $this->transaksiModel->update($id, $updateData);

            // Jika disetujui, update point user
            if ($status === 'approved') {
                $totalPoint = $this->transaksiModel->getTotalPointUser($transaksi['username']);
                $this->userModel->where('username', $transaksi['username'])
                               ->set(['total_point' => $totalPoint])
                               ->update();
            }

            // Ambil data user untuk notifikasi
            $user = $this->userModel->where('username', $transaksi['username'])->first();
            if ($user) {
                // Kirim notifikasi push
                $this->notificationController->sendStatusChangeNotification(
                    $user->id,
                    $status,
                    'transaction',
                    [
                        'id' => $id,
                        'point_sampah_dijual' => $transaksi['point_sampah_dijual'],
                        'berat_sampah' => $transaksi['berat_sampah']
                    ]
                );

                // Simpan notifikasi ke database
                $notifTitle = $status === 'approved' ? 'Transaksi Disetujui' : 'Transaksi Ditolak';
                $notifMessage = $status === 'approved' 
                    ? "Transaksi sampah Anda seberat {$transaksi['berat_sampah']}kg telah disetujui. Point Anda bertambah {$transaksi['point_sampah_dijual']} point!"
                    : "Transaksi sampah Anda seberat {$transaksi['berat_sampah']}kg ditolak. Silakan hubungi admin untuk informasi lebih lanjut.";

                $this->notifikasiModel->insert([
                    'user_id' => $user->id,
                    'judul' => $notifTitle,
                    'pesan' => $notifMessage,
                    'is_read' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal memproses verifikasi');
            }

            return redirect()->back()->with('message', 'Transaksi berhasil diverifikasi');

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', '[TransaksiController::verifikasiTransaksi] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}