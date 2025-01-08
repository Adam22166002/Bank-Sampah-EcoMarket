<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\TransaksiSampahModel;
use App\Models\UserManagementModel;
use Myth\Auth\Models\UserModel;

class UserManagementController extends BaseController
{
    protected $userManagementModel;
    protected $transaksiModel;
    protected $produkModel;
    protected $Model;
    protected $db, $builder;

    public function __construct()
    {
        $this->userManagementModel = new UserManagementModel();
        $this->transaksiModel = new TransaksiSampahModel();
        $this->produkModel = new ProdukModel();
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function index()
{
    $this->builder->select('users.id as userid, username, email, name, active');
    $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
    $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
    $users = $this->builder->get()->getResult();

    $data = [
        'title' => 'Manajemen User',
        'users' => $users
    ];

    return view('admin/user_management', $data);
}

public function updateActivation()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403)->setJSON(['error' => 'Invalid request']);
    }

    $userId = $this->request->getPost('user_id');
    $status = $this->request->getPost('status');

    if (!$userId || !in_array($status, ['0', '1'])) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Invalid input'
        ]);
    }

    try {
        $result = $this->userManagementModel->updateActivation($userId, $status);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status aktivasi berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui status aktivasi'
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', '[UserManagement] Error updating activation: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan server'
        ]);
    }
}
public function detail($id = 0)
{
    $transaksiModel = new TransaksiSampahModel();
    $produkModel = new ProdukModel();

    $this->builder->select('users.id as userid, username, email, fullname, user_image, 
                           total_point, active, created_at, auth_groups.name as role');
    $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
    $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
    $this->builder->where('users.id', $id);
    $query = $this->builder->get();

    $user = $query->getRow();

    if(empty($user)) {
        return redirect()->to('/admin')->with('error', 'User tidak ditemukan');
    }  
    $debug = [
        'user_data' => $user,
        'role' => $user->role,
        'is_nasabah' => (strtolower($user->role) == 'nasabah')
    ];  

    $stats = [];
    $seller_stats = [];
    if(strtolower($user->role) == 'nasabah') {
        try {
            $totalTransaksi = $transaksiModel->where('username', $user->username)->countAllResults();
            
            $totalSampah = $transaksiModel->where('username', $user->username)
                                       ->where('status', 'approved')
                                       ->selectSum('berat_sampah', 'total_berat')
                                       ->get()
                                       ->getRow();

            $stats = [
                'total_transaksi' => $totalTransaksi,
                'total_sampah' => $totalSampah ? $totalSampah->total_berat : 0,
                'point_terkumpul' => $user->total_point ?? 0,
                'join_date' => $user->created_at
            ];

            
        } catch (\Exception $e) {
            log_message('error', 'Error getting stats: ' . $e->getMessage());
            $stats = [
                'total_transaksi' => 0,
                'total_sampah' => 0,
                'point_terkumpul' => 0,
                'join_date' => $user->created_at
            ];
        }
    }elseif(strtolower($user->role) == 'seller') {
        $seller_stats = [
            'total_produk' => $produkModel->where('user_id', $user->userid)->countAllResults(),
            'produk_terjual' => $produkModel->where('user_id', $user->userid)
                                          ->selectSum('terjual')
                                          ->get()
                                          ->getRow()
                                          ->terjual ?? 0
        ];
    }

    $data = [
        'title' => 'Detail User',
        'user' => $user,
        'stats' => $stats,
        'seller_stats' => $seller_stats,
        'recent_activities' => $this->getRecentActivities($user),
        'debug' => $debug
    ];

    return view('admin/detail_user', $data);
}

private function getRecentActivities($user)
{
    $activities = [];
    
    if($user->role === 'nasabah') {
        $transaksiModel = new TransaksiSampahModel();
        $activities = $transaksiModel->select('created_at, status, berat_sampah, point_sampah_dijual')
                                   ->where('username', $user->username)
                                   ->orderBy('created_at', 'DESC')
                                   ->limit(5)
                                   ->find();
    }

    return $activities;
}
}