<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;

class NotifikasiController extends BaseController
{
    protected $notifikasiModel;

    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Notifikasi',
            'notifikasi' => $this->notifikasiModel->where('user_id', user()->id)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll()
        ];
        return view('notifikasi/index', $data);
    }

    public function markAsRead($id)
    {
        $notif = $this->notifikasiModel->find($id);
        
        if (!$notif || $notif['user_id'] !== user()->id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notifikasi tidak ditemukan']);
        }

        $this->notifikasiModel->update($id, ['is_read' => 1]);
        return $this->response->setJSON(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = $this->notifikasiModel->where('user_id', user()->id)
                                      ->where('is_read', 0)
                                      ->countAllResults();
        
        return $this->response->setJSON(['count' => $count]);
    }
}