<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // nama tabel yang digunakan
    protected $primaryKey = 'id'; // id adalah primary key di tabel user
    protected $allowedFields = ['name', 'email', 'password', 'role', 'created_at']; // kolom yang boleh dimanipulasi pada tabel user

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
        // mencari user berdasarkan email dengan mengembalikan satu baris data berdasarkan email yang diberikan
    }
}