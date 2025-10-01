<?php

namespace App\Controllers;

class DapurController extends BaseController
{
    public function dashboard()
    {
        echo "<h1>Selamat Datang, " . session()->get('name') . "!</h1>";
        echo "<p>Anda login sebagai Petugas Dapur.</p>";
        echo '<a href="/dapur/permintaan/create">Buat Permintaan Bahan</a><br>';
        echo '<a href="/logout">Logout</a>';
    }
}