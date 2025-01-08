<?php

namespace App\Models;

use CodeIgniter\Model;

class UserManagementModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['active'];

    public function getAllUsers()
    {
        return $this->db->table('users')
                    ->select('
                        users.id as userid, 
                        users.email, 
                        users.username, 
                        users.active,
                        users.fullname,
                        auth_groups.name
                    ')
                    ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                    ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                    ->where('auth_groups.name !=', 'admin')
                    ->get()
                    ->getResult();
    }

    public function updateActivation($userId, $status)
    {
        try {
            $result = $this->update($userId, ['active' => $status]);
            
            if ($result === false) {
                log_message('error', 'Failed to update user activation. User ID: ' . $userId);
                return false;
            }
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error updating user activation: ' . $e->getMessage());
            return false;
        }
    }

    public function getTotalActiveUsers()
    {
        return $this->where('active', 1)->countAllResults();
    }
}