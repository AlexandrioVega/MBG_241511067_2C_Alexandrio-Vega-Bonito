<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Cek role jika diperlukan
        if (!empty($arguments)) {
            $role = session()->get('role');
            if (!in_array($role, $arguments)) {
                // Jika role tidak sesuai, bisa redirect ke halaman error atau dashboard default
                return redirect()->to('/login'); 
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}