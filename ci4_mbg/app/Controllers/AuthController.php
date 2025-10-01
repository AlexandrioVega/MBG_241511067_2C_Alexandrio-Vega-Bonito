<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Jika sudah login, redirect ke dashboard masing-masing
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role');
            return redirect()->to($role == 'gudang' ? '/gudang/dashboard' : '/dapur/dashboard');
        }
        return view('login');
    }

    public function attemptLogin()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->getUserByEmail($email);

        // Gunakan md5() sesuai data dummy, untuk production gunakan password_verify()
        if ($user && md5($password) === $user['password']) {
            $sessionData = [
                'user_id'    => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => TRUE
            ];
            $session->set($sessionData);

            if ($user['role'] == 'gudang') {
                return redirect()->to('/gudang/dashboard');
            } else {
                return redirect()->to('/dapur/dashboard');
            }
        } else {
            $session->setFlashdata('error', 'Email atau Password salah.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}