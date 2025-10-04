<?php

namespace App\Controllers;
use App\Models\BahanBakuModel;
class GudangController extends BaseController
{
    public function dashboard()
    {
        return redirect()->to('/gudang/bahan');
    }

    public function bahan()
    {
        $model = new BahanBakuModel();
       
        // Panggil method baru yang sudah kita buat di model
        $data['bahan_baku_list'] = $model->getAllWithCalculatedStatus();

       return view('gudang/bahan/index', $data);
    }

    public function create()
    {
        // Helper 'form' diperlukan untuk validation_errors() di view
        helper('form');
        return view('gudang/create_bahan');
    }

    public function store(){
        helper('form');
        $rules = [
            'nama' => 'required|min_length[3]|max_length[120]',
            'kategori' => 'required|max_length[60]',
            'jumlah' => 'required|numeric|greater_than_equal_to[0]',
            'satuan' => 'required|max_length[20]',
            'tanggal_masuk' => 'required|valid_date',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form dengan pesan error
            return view('gudang/bahan/create', [
                'validation' => $this->validator
            ]);
        }

        // Jika validasi berhasil
        $model = new BahanBakuModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
            'status' => 'tersedia', // Status awal sesuai permintaan soal
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        // Tambahkan notifikasi flash data untuk ditampilkan setelah redirect
        session()->setFlashdata('success', 'Bahan baku berhasil ditambahkan.');

        return redirect()->to('/gudang/bahan');

    }

    public function edit($id)
    {
        helper('form');
        $model = new BahanBakuModel();
        $data['bahan'] = $model->find($id);

        if (!$data['bahan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bahan baku tidak ditemukan.');
        }
        return view('gudang/bahan/edit', $data);
    }

    public function update($id)
    {
        helper('form');
        
        // Aturan validasi: hanya untuk jumlah
        $rules = [
            'jumlah' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form edit dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Jika validasi berhasil
        $model = new BahanBakuModel();
        
        $data = [
            'jumlah' => $this->request->getPost('jumlah'),
        ];

        $model->update($id, $data);

        session()->setFlashdata('success', 'Stok bahan baku berhasil diperbarui.');

        return redirect()->to('/gudang/bahan');
    }
}