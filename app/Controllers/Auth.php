<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function redirect()
    {
        // Check if user is logged in
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Redirect based on role using in_groups() helper
        if (in_groups('admin')) {
            return redirect()->to('/admin');
        } elseif (in_groups('seller')) {
            return redirect()->to('/seller');
        } elseif (in_groups('nasabah')) {
            return redirect()->to('/user');
        }

        // Fallback if no valid role found
        return redirect()->to('/login')->with('error', 'No valid role assigned');
    }
    public function ping() {
        return $this->response->setStatusCode(200);
    }
}