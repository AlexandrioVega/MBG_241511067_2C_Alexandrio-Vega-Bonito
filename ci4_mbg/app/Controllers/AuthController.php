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

    // Fungsi untuk memproses login setelah user mengisi form.
    public function attemptLogin()
    {
        $session = session();
        // Membuka objek session (tempat menyimpan data login).
        $userModel = new UserModel();
        // Membuat objek UserModel supaya bisa akses tabel user.

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // Ambil input dari form login: email dan password.
        // getPost = ambil data dari form metode POST

        $user = $userModel->getUserByEmail($email);
        // Cari data user di database berdasarkan email.

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
        //Kalau user ditemukan dan password yang diinput (setelah diubah ke MD5) cocok dengan password di database → login berhasil.
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}