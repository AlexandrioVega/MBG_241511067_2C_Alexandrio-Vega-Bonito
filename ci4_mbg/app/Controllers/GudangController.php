<?php

namespace App\Controllers;
use App\Models\BahanBakuModel;
class GudangController extends BaseController
{
    public function dashboard()
    {
        echo "<h1>Selamat Datang, " . session()->get('name') . "!</h1>";
        echo "<p>Anda login sebagai Petugas Gudang.</p>";
        echo '<a href="/gudang/bahan">Lihat Bahan Baku</a><br>';
        echo '<a href="/logout">Logout</a>';
    }

    public function bahan()
    {
        
    }
}