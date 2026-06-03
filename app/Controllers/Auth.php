<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        return view('landing_page');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'email'    => $user['email'],
                    'role'     => $user['role'],
                    'isLogged' => true
                ]);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password Salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}