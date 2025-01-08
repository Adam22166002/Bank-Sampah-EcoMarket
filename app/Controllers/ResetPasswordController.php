<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class ResetPasswordController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function update()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]|strong_password',
            'password_confirm' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('reset-password')->with('errors', $errors);
        }

        $userId = user()->id;
        $userEntity = $this->userModel->find($userId);
        $currentPassword = $this->request->getPost('current_password');

        if (!password_verify($currentPassword, $userEntity->password_hash)) {
            return redirect()->to('reset-password')->with('error', 'Password saat ini tidak sesuai');
        }

        $newPassword = $this->request->getPost('new_password');
        $this->userModel->update($userId, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('reset-password')->with('message', 'Password berhasil diubah! Silakan gunakan password baru Anda.');
    }


    public function index()
    {
        $token = $this->request->getGet('token');
        
        if ($token) {
            $user = $this->userModel->where('reset_hash', $token)
                                   ->where('reset_expires >', date('Y-m-d H:i:s'))
                                   ->first();

            if (!$user) {
                return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa');
            }

            return view('Login/reset_password_token', [
                'token' => $token,
                'email' => $user->email
            ]);
        }

        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $userId = user()->id;
        $userEntity = $this->userModel->find($userId);
        
        return view('Login/reset_password', [
            'user' => $userEntity
        ]);
    }
    public function reset()
{
    $rules = [
        'token' => 'required',
        'email' => 'required|valid_email',
        'password' => 'required|min_length[8]|strong_password',
        'pass_confirm' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $token = $this->request->getPost('token');
    $email = $this->request->getPost('email');

    $user = $this->userModel->where('email', $email)
                           ->where('reset_hash', $token)
                           ->where('reset_expires >', date('Y-m-d H:i:s'))
                           ->first();

    if (!$user) {
        return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa');
    }

    $user->password_hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    $user->reset_hash = null;
    $user->reset_at = date('Y-m-d H:i:s');
    $user->reset_expires = null;
    $this->userModel->save($user);

    return redirect()->to('reset-password')->with('message', 'Password berhasil direset. Silahkan login dengan password baru.');
}
}