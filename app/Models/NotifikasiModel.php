<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'user_id',
        'judul',
        'pesan',
        'is_read',
        'link'
    ];

    protected $validationRules = [
        'user_id' => 'required',
        'judul' => 'required',
        'pesan' => 'required'
    ];

    public function getNotifikasiUser($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->where('deleted_at', null)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    public function getUnreadCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->where('deleted_at', null)
                    ->countAllResults();
    }

    public function markAsRead($notifikasiId)
    {
        return $this->update($notifikasiId, ['is_read' => 1]);
    }

    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }
}