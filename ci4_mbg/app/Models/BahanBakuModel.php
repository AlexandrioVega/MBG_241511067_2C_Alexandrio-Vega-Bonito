<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuModel extends Model
{
    protected $table = 'bahan_baku'; // nama tabel yang digunakan
    protected $primaryKey = 'id'; // id adalah primary key di tabel user
    protected $allowedFields = ['nama', 'kategori', 'jumlah', 'satuan', 'tanggal_masuk', 'tanggal_kadaluarsa', 'status', 'created_at']; // kolom yang boleh dimanipulasi pada tabel user
    
    public function getAllWithCalculatedStatus()
    {
        $today = date('Y-m-d');

        $this->select("*, 
            CASE 
                WHEN jumlah <= 0 THEN 'habis'
                WHEN tanggal_kadaluarsa < '{$today}' THEN 'kadaluarsa'
                WHEN DATEDIFF(tanggal_kadaluarsa, '{$today}') <= 3 THEN 'segera_kadaluarsa'
                ELSE 'tersedia'
            END as status_terhitung"
        );
        
        return $this->orderBy('nama', 'ASC')->findAll();
    }
    
    public function getBahanTersedia()
    {
        $today = date('Y-m-d');
        return $this->where('jumlah >', 0)
                    ->where('tanggal_kadaluarsa >=', $today)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }
}