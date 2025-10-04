<?php

namespace App\Controllers;
use App\Models\PermintaanModel;

class DapurController extends BaseController
{
    public function dashboard()
    {
        $permintaanModel = new PermintaanModel();
        $userId = session()->get('user_id');
        $data['total_menunggu'] = $permintaanModel->where('pemohon_id', $userId)->where('status', 'menunggu')->countAllResults();
        $data['total_disetujui'] = $permintaanModel->where('pemohon_id', $userId)->where('status', 'disetujui')->countAllResults();
        $data['total_ditolak'] = $permintaanModel->where('pemohon_id', $userId)->where('status', 'ditolak')->countAllResults();
        $data['permintaan_terakhir'] = $permintaanModel->where('pemohon_id', $userId)
                                                      ->orderBy('created_at', 'DESC')
                                                      ->limit(5)
                                                      ->findAll();
        return view('dapur/dashboard', $data);
    }
}