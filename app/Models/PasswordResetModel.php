<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'token', 'created_at', 'expires_at', 'used'];

    public function getValidToken($token)
    {
        return $this->where('token', $token)
                    ->where('used', 0)
                    ->where('expires_at >', date('Y-m-d H:i:s'))
                    ->first();
    }
}