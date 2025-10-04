<?php

namespace App\Controllers;

use App\Models\BahanBakuModel;
use App\Models\PermintaanModel;
use App\Models\PermintaanDetailModel;

class PermintaanController extends BaseController
{
    /**
     * Menampilkan form untuk membuat permintaan bahan.
     */
    public function create()
    {
        helper('form');
        $bahanBakuModel = new BahanBakuModel();
        // Ambil hanya bahan yang tersedia dan tidak kadaluarsa
        $data['bahan_list'] = $bahanBakuModel->getBahanTersedia();
        return view('dapur/permintaan/create', $data);
    }

    /**
     * Memvalidasi dan menyimpan data permintaan ke database.
     * Ini menggunakan database transaction.
     */
    public function store()
    {

        $rules = [
            'tgl_masak'   => 'required|valid_date',
            'menu_makan'  => 'required|min_length[5]',
            'jumlah_porsi'=> 'required|numeric|greater_than[0]',
            'bahan_id'    => 'required', 
            'jumlah'      => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart(); 
        try {
            $permintaanModel = new PermintaanModel();
            $permintaanData = [
                'pemohon_id'   => session()->get('user_id'),
                'tgl_masak'    => $this->request->getPost('tgl_masak'),
                'menu_makan'   => $this->request->getPost('menu_makan'),
                'jumlah_porsi' => $this->request->getPost('jumlah_porsi'),
                'status'       => 'menunggu',
                'created_at'   => date('Y-m-d H:i:s'),
            ];
            $permintaanModel->insert($permintaanData);
            $permintaanId = $permintaanModel->getInsertID();

            
            $permintaanDetailModel = new PermintaanDetailModel();
            $bahanIds = $this->request->getPost('bahan_id');
            $jumlahs = $this->request->getPost('jumlah');

            foreach ($bahanIds as $key => $bahanId) {
                $detailData = [
                    'permintaan_id'  => $permintaanId,
                    'bahan_id'       => $bahanId,
                    'jumlah_diminta' => $jumlahs[$key],
                ];
                $permintaanDetailModel->insert($detailData);
            }

            $db->transCommit();

            session()->setFlashdata('success', 'Permintaan bahan baku berhasil diajukan.');
            return redirect()->to('/dapur/dashboard');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengajukan permintaan.');
            return redirect()->back()->withInput();
        }
    }
}