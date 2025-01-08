<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;
use App\Models\PenarikanEwalletModel;
use App\Models\PenukaranProdukModel;
use App\Models\ProdukModel;
use App\Models\RiwayatPointModel;
use App\Models\RiwayatSaldoModel;
use App\Models\TransaksiSampahModel;
use App\Models\VerifikasiModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $db, $builder;
    protected $transaksiModel;
    protected $userModel;
    protected $produkModel;
    protected $penarikanModel;
    protected $riwayatPointModel;
    protected $riwayatSaldoModel;
    protected $verifikasiModel;
    protected $penukaranModel;
    protected $notifikasiModel;
    protected $ewalletModel;

    public function __construct() 
    {
        if (!in_groups('admin')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->transaksiModel = new TransaksiSampahModel();
        $this->userModel = new UserModel();
        $this->produkModel = new ProdukModel();
        $this->riwayatPointModel = new RiwayatPointModel();
        $this->riwayatSaldoModel = new RiwayatSaldoModel();
        $this->penarikanModel = new PenarikanEwalletModel();
        $this->verifikasiModel = new VerifikasiModel();
        $this->penukaranModel = new PenukaranProdukModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->ewalletModel = new PenarikanEwalletModel();
        
    }
    public function index(): string
    {
        $this->builder->select('users.id as userid, username, email, name, active');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $users = $this->builder->get()->getResult();

        $nasabahQuery = $this->db->table('users')
            ->select('
                users.id as userid, 
                users.username, 
                users.email, 
                users.total_point,
                users.active,
                auth_groups.name as role,
                (SELECT COALESCE(SUM(berat_sampah), 0) 
                FROM transaksi_sampah 
                WHERE transaksi_sampah.username = users.username 
                AND status = "approved") as total_sampah
            ')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('auth_groups.name', 'nasabah');
        
        $nasabah_active = $nasabahQuery->get()->getResult();
        $total_nasabah_active = count(array_filter($nasabah_active, function($n) {
            return $n->active == 1;
        }));

        $transaksi_data = $this->transaksiModel
            ->select('transaksi_sampah.*, kategori_sampah.nama_kategori')
            ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
            ->orderBy('transaksi_sampah.created_at', 'DESC')
            ->findAll();

        $total_transaksi = $this->transaksiModel->countAllResults();
        $total_sampah = $this->transaksiModel
            ->where('status', 'approved')
            ->selectSum('berat_sampah')
            ->get()
            ->getRow()
            ->berat_sampah ?? 0;

        $total_transaksi = $this->transaksiModel->countAll() + 
        $this->penukaranModel->countAll() + 
        $this->penarikanModel->countAll();

        $total_sampah = $this->transaksiModel
        ->where('status', 'approved')
        ->selectSum('berat_sampah')
        ->get()
        ->getRow()
        ->berat_sampah ?? 0;

        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-1 month'));
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');

        $transactions = $this->getAllTransactions($start_date, $end_date);

        $data = [
            'title' => 'Admin Management',
            'users' => $users,
            'nasabah_active' => $nasabah_active,
            'total_nasabah_active' => $total_nasabah_active,
            'total_transaksi' => $total_transaksi,
            'total_sampah' => $total_sampah,
            'data' => $transaksi_data,
            'total_transaksi' => $total_transaksi,
            'total_sampah' => $total_sampah,
            'pending_transactions' => $this->transaksiModel->getPendingTransaksi(),
            'transactions' => $transactions,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return view('admin/index', $data);
        
    }
    public function totalSampah()
    {
        $data = [
            'title' => 'Total Sampah Terkumpul',
            'sampah' => $this->transaksiModel
                ->select('
                    transaksi_sampah.*,
                    users.username,
                    kategori_sampah.nama_kategori
                ')
                ->join('users', 'users.username = transaksi_sampah.username')
                ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
                ->where('transaksi_sampah.status', 'approved')
                ->orderBy('transaksi_sampah.created_at', 'DESC')
                ->findAll(),
            'total_sampah' => $this->transaksiModel
                ->where('status', 'approved')
                ->selectSum('berat_sampah')
                ->get()
                ->getRow()
                ->berat_sampah ?? 0
        ];

        return view('admin/total_sampah', $data);
    }

    public function transaksi()
    {
        $data = [
            'title' => 'Verifikasi Transaksi',
            'data' => $this->transaksiModel
                ->select('transaksi_sampah.*, kategori_sampah.nama_kategori')
                ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
                ->orderBy('transaksi_sampah.created_at', 'DESC')
                ->findAll()
        ];

        return view('admin/transaksi', $data);
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

        if ($status === 'approved') {
            // Update status transaksi
            $this->transaksiModel->update($id, [
                'status' => 'approved',
                'admin_id' => $admin_id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ]);

            // Ambil user nasabah
            $user = $this->userModel->where('username', $transaksi['username'])->first();
            if (!$user) {
                throw new \Exception('User tidak ditemukan');
            }

            // Hitung point baru: point saat ini + point dari transaksi
            $newPoint = $user->total_point + $transaksi['point_sampah_dijual'];

            // Update point user
            $this->userModel->update($user->id, [
                'total_point' => $newPoint
            ]);

            // Tambahkan ke riwayat point
            $this->riwayatPointModel->insert([
                'user_id' => $user->id,
                'jenis' => 'transaksi_sampah',
                'jumlah' => $transaksi['point_sampah_dijual'],
                'keterangan' => "Mendapat {$transaksi['point_sampah_dijual']} point dari transaksi sampah {$transaksi['berat_sampah']}kg",
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Kirim notifikasi ke nasabah
            $this->notifikasiModel->insert([
                'user_id' => $user->id,
                'judul' => 'Transaksi Disetujui',
                'pesan' => "Transaksi sampah {$transaksi['berat_sampah']}kg telah disetujui. Point Anda bertambah {$transaksi['point_sampah_dijual']} point! Total point Anda sekarang: {$newPoint} point",
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Jika ditolak, update status dan tambahkan keterangan
            $this->transaksiModel->update($id, [
                'status' => $status,
                'admin_id' => $admin_id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s'),
                'keterangan' => $this->request->getPost('keterangan')
            ]);

            // Notifikasi penolakan ke nasabah
            $user = $this->userModel->where('username', $transaksi['username'])->first();
            if ($user) {
                $this->notifikasiModel->insert([
                    'user_id' => $user->id,
                    'judul' => 'Transaksi Ditolak',
                    'pesan' => "Transaksi sampah {$transaksi['berat_sampah']}kg ditolak. " . 
                              ($this->request->getPost('keterangan') ? "Keterangan: " . $this->request->getPost('keterangan') : ""),
                    'is_read' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $this->db->transComplete();
        //buatriwayatdoang
        $this->riwayatPointModel->tambahRiwayatTransaksiSampah(
            $user->id,
            $transaksi['point_sampah_dijual'],
            $transaksi['berat_sampah']
        );

        if ($this->db->transStatus() === false) {
            throw new \Exception('Gagal memproses verifikasi');
        }

        return redirect()->to('admin/transaksi_sampah')->with('message', 'Transaksi berhasil diverifikasi');

    } catch (\Exception $e) {
        $this->db->transRollback();
        log_message('error', '[Admin::verifikasiTransaksi] ' . $e->getMessage());
        return redirect()->to('admin/transaksi_sampah')->with('error', 'Error: ' . $e->getMessage());
    }
}


    public function produk()
    {
        $data = [
            'title' => 'Verifikasi Produk',
            'produk' => $this->produkModel
                ->select('produk.*, users.username')
                ->join('users', 'users.id = produk.user_id')
                ->orderBy('produk.created_at', 'DESC')
                ->findAll(),
            'penukaran' => $this->penukaranModel
            ->select('penukaran_produk.*, users.username')
            ->join('users', 'users.id = penukaran_produk.user_id')
            ->orderBy('penukaran_produk.created_at', 'DESC')
            ->findAll()
        ];

        return view('admin/produk', $data);
    }

    public function verifikasiProduk($id)
    {
        try {
            $produk = $this->produkModel->find($id);
            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            $status = $this->request->getPost('status');
            if (!in_array($status, ['active', 'inactive'])) {
                throw new \Exception('Status tidak valid');
            }

            $data = [
                'status' => $status,
                'admin_verifikasi_id' => user()->id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ];

            if ($this->produkModel->update($id, $data)) {
                return redirect()->to('/admin/transaksi_produk')->with('message', 'Status produk berhasil diupdate menjadi ' . $status);
            }

            throw new \Exception('Gagal mengupdate status produk');

        } catch (\Exception $e) {
            return redirect()->to('/admin/transaksi_produk')->with('error', $e->getMessage());
        }
    }

    public function verifikasiPenukaran($id)
{
    try {
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');
        
        $this->db->transStart();
        
        $penukaran = $this->penukaranModel->find($id);
        if (!$penukaran) {
            throw new \Exception('Data penukaran tidak ditemukan');
        }

        if ($status === 'approved') {
            $nasabah = $this->userModel->find($penukaran['user_id']);
            $produk = $this->produkModel->find($penukaran['produk_id']);
            $seller = $this->userModel->find($produk['user_id']);

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            if ($produk['stok'] <= 0) {
                throw new \Exception('Stok produk habis');
            }

            //generate QR Code
            $qrData = json_encode([
                'penukaran_id' => $id,
                'user_id' => $penukaran['user_id'],
                'produk_id' => $penukaran['produk_id'],
                'nama_produk' => $penukaran['nama_produk'],
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ]);

            $qrCode = new QrCode($qrData);
            $writer = new PngWriter();
            $qrFileName = 'QR_' . time() . '_' . $id . '.png';
            $qrPath = FCPATH . 'uploads/qrcodes/';
            
            if (!is_dir($qrPath)) {
                mkdir($qrPath, 0777, true);
            }
            
            $result = $writer->write($qrCode);
            $result->saveToFile($qrPath . $qrFileName);
            
            //udate Point Seller (Tambah point)
            $newPointSeller = $seller->total_point + $penukaran['point_tukar'];
            $this->userModel->update($seller->id, [
                'total_point' => $newPointSeller
            ]);

            //update Stock Produk
            $this->produkModel->update($produk['produk_id'], [
                'stok' => $produk['stok'] - 1,
                'terjual' => ($produk['terjual'] ?? 0) + 1
            ]);

            //status Penukaran
            $this->penukaranModel->update($id, [
                'status' => $status,
                'qr_code' => $qrFileName,
                'admin_verifikasi_id' => user()->id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s'),
                'keterangan' => $keterangan
            ]);

            //notifikasi ke nasabah
            $notificationController = new NotificationController();
            $notificationController->sendStatusChangeNotification(
                $nasabah->id,
                $status,
                'penukaran',
                [
                    'nama_produk' => $penukaran['nama_produk'],
                    'point' => $penukaran['point_tukar']
                ]
            );

            //notifikasi ke seller
            $notificationController->sendStatusChangeNotification(
                $seller->id,
                $status,
                'penjualan',
                [
                    'nama_produk' => $penukaran['nama_produk'],
                    'point' => $penukaran['point_tukar']
                ]
            );

        } else {
            //refund point nasabah
            $nasabah = $this->userModel->find($penukaran['user_id']);
            if ($nasabah) {
                $refundedPoint = $nasabah->total_point + $penukaran['point_tukar'];
                $this->userModel->update($nasabah->id, [
                    'total_point' => $refundedPoint
                ]);
            }
            //update status
            $this->penukaranModel->update($id, [
                'status' => $status,
                'admin_verifikasi_id' => user()->id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s'),
                'keterangan' => $keterangan
            ]);

            //notifikasi penolakan ke nasabah
            $notificationController = new NotificationController();
            $notificationController->sendStatusChangeNotification(
                $penukaran['user_id'],
                $status,
                'penukaran',
                [
                    'nama_produk' => $penukaran['nama_produk'],
                    'keterangan' => $keterangan
                ]
            );
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \Exception('Gagal memproses verifikasi');
        }

        return redirect()->to('admin/transaksi_produk')->with('message', 'Verifikasi penukaran berhasil diproses');

    } catch (\Exception $e) {
        $this->db->transRollback();
        return redirect()->to('admin/transaksi_produk')->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function verifikasiPenarikan()
    {
        $data = [
            'title' => 'Verifikasi Penarikan E-Wallet',
            'penarikan' => $this->penarikanModel->select('penarikan_ewallet.*, users.username, users.email')
                ->join('users', 'users.id = penarikan_ewallet.user_id')
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ];

        return view('admin/verifikasi_penarikan', $data);
    }

    public function prosesVerifikasiPenarikan($id)
{
    $status = $this->request->getPost('status');
    $keterangan = $this->request->getPost('keterangan');

    $db = \Config\Database::connect();
    $db->transStart();

    try {
        $penarikan = $this->penarikanModel->find($id);
        if (!$penarikan) {
            throw new \Exception('Data penarikan tidak ditemukan');
        }

        $this->penarikanModel->update($id, [
            'status' => $status,
            'admin_id' => user()->id,
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan
        ]);

        $this->verifikasiModel->insert([
            'admin_id' => user()->id,
            'tipe' => 'penarikan_ewallet',
            'id_transaksi' => $id,
            'status' => $status,
            'keterangan' => $keterangan
        ]);

        if ($status === 'rejected') {
            $user = $this->userModel->find($penarikan['user_id']);
            if (!$user) {
                throw new \Exception('User tidak ditemukan');
            }

            $newPoint = $user->total_point + $penarikan['jumlah_point'];
            $this->userModel->update($user->id, ['total_point' => $newPoint]);

            if ($penarikan['role'] === 'nasabah') {
                $this->riwayatPointModel->tambahRiwayat(
                    $penarikan['user_id'],
                    'refund_ewallet',
                    $penarikan['jumlah_point'], 
                    'Refund penarikan e-wallet (Ditolak Admin)'
                );
            } else if ($penarikan['role'] === 'seller') {
                $this->riwayatSaldoModel->tambahRiwayat(
                    $penarikan['user_id'],
                    'refund_ewallet',
                    $penarikan['jumlah_rupiah'], 
                    'Refund penarikan e-wallet (Ditolak Admin)'
                );
            }

            $this->notifikasiModel->insert([
                'user_id' => $penarikan['user_id'],
                'judul' => 'Penarikan E-Wallet Ditolak',
                'pesan' => "Penarikan e-wallet sebesar " . number_format($penarikan['jumlah_point']) . 
                          " point telah ditolak. Point telah dikembalikan ke saldo Anda. Keterangan: " . $keterangan,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \Exception('Gagal memproses verifikasi');
        }

        return redirect()->to('/admin/transaksi_penarikan')->with('message', 'Verifikasi berhasil');

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}

    public function detail($id = 0)
    {
        $data['title'] = 'Admin Detail';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name' );
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if(empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }
    private function getAllTransactions($start_date, $end_date)
    {
        $sampah = $this->transaksiModel->select('
                transaksi_sampah.*, 
                users.username,
                "transaksi_sampah" as tipe_transaksi,
                kategori_sampah.nama_kategori
            ')
            ->join('users', 'users.username = transaksi_sampah.username')
            ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
            ->where('DATE(transaksi_sampah.created_at) >=', $start_date)
            ->where('DATE(transaksi_sampah.created_at) <=', $end_date)
            ->findAll();

        $penukaran = $this->penukaranModel->select('
                penukaran_produk.*, 
                users.username,
                "penukaran_produk" as tipe_transaksi,
                produk.nama_produk
            ')
            ->join('users', 'users.id = penukaran_produk.user_id')
            ->join('produk', 'produk.produk_id = penukaran_produk.produk_id')
            ->where('DATE(penukaran_produk.created_at) >=', $start_date)
            ->where('DATE(penukaran_produk.created_at) <=', $end_date)
            ->findAll();

        $ewallet = $this->ewalletModel->select('
                penarikan_ewallet.*, 
                users.username,
                "penarikan_ewallet" as tipe_transaksi
            ')
            ->join('users', 'users.id = penarikan_ewallet.user_id')
            ->where('DATE(penarikan_ewallet.created_at) >=', $start_date)
            ->where('DATE(penarikan_ewallet.created_at) <=', $end_date)
            ->findAll();

        $all_transactions = array_merge($sampah, $penukaran, $ewallet);
        usort($all_transactions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $all_transactions;
    }
}
