<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuModel extends Model
{
    protected $table = 'bahan_baku'; // nama tabel yang digunakan
    protected $primaryKey = 'id'; // id adalah primary key di tabel user
    protected $allowedFields = ['nama', 'kategori', 'jumlah', 'satuan', 'tanggal_masuk', 'tanggal_kadaluarsa', 'status', 'created_at']; // kolom yang boleh dimanipulasi pada tabel user

}