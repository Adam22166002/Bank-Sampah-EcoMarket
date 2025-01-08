<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class ForgotPasswordController extends BaseController
{
    protected $userModel;
    protected $email;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->email = \Config\Services::email();
    }

    public function index()
    {
        return view('Login/forgot_password');
    }

    public function sendResetLink()
{
    $email = $this->request->getPost('email');
    
    $user = $this->userModel->where('email', $email)->first();
    if (!$user) {
        return redirect()->back()->with('error', 'Email tidak ditemukan');
    }

    $token = bin2hex(random_bytes(32));
    $now = date('Y-m-d H:i:s');

    $this->userModel->logResetAttempt(
        $email,
        $token,
        $this->request->getIPAddress(),
        $this->request->getUserAgent()->getAgentString()
    );

    $this->userModel->update($user->id, [
        'reset_hash' => $token,
        'reset_at' => $now,
        'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
    ]);

    $resetLink = site_url("reset-password?token={$token}");
    $this->email->setFrom('ecomarket84@gmail.com', 'Eco Market');
    $this->email->setTo($email);
    $this->email->setSubject('Reset Password - Eco Market');
    $this->email->setMessage(view('emails/forgot_password', [
        'token' => $token,
        'username' => $user->username,
        'email' => $user->email,
        'resetLink' => $resetLink
    ]));

    if ($this->email->send()) {
        return redirect()->back()->with('message', 'Link reset password telah dikirim ke email Anda. Silahkan cek email Anda.');
    }

    return redirect()->back()->with('error', 'Gagal mengirim email reset password. Silahkan coba lagi.');
}
}