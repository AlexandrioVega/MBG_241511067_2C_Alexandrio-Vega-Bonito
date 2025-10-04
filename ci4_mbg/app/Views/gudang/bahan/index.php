<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Daftar Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="mb-3">Manajemen Bahan Baku</h3>
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Bahan Baku</h5>
                    <a href="/gudang/bahan/create" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Bahan</a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Bahan</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Tgl Masuk</th>
                                    <th scope="col">Tgl Kadaluarsa</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($bahan_baku_list)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data bahan baku.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($bahan_baku_list as $bahan): ?>
                                        <tr>
                                            <th scope="row"><?= $i++ ?></th>
                                            <td><?= esc($bahan['nama']) ?></td>
                                            <td><?= esc($bahan['kategori']) ?></td>
                                            <td><?= esc($bahan['jumlah']) . ' ' . esc($bahan['satuan']) ?></td>
                                            <td><?= date('d M Y', strtotime($bahan['tanggal_masuk'])) ?></td>
                                            <td><?= date('d M Y', strtotime($bahan['tanggal_kadaluarsa'])) ?></td>
                                            <td>
                                                <?php
                                                    $status = $bahan['status_terhitung'];
                                                    $badge_class = '';
                                                    switch ($status) {
                                                        case 'tersedia':
                                                            $badge_class = 'bg-success';
                                                            break;
                                                        case 'segera_kadaluarsa':
                                                            $badge_class = 'bg-warning text-dark';
                                                            break;
                                                        case 'kadaluarsa':
                                                            $badge_class = 'bg-danger';
                                                            break;
                                                        case 'habis':
                                                            $badge_class = 'bg-secondary';
                                                            break;
                                                    }
                                                ?>
                                                <span class="badge <?= $badge_class ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                                            </td>
                                            <td>
                                                <a href="/gudang/bahan/edit/<?= $bahan['id'] ?>" class=="btn btn-warning btn-sm" title="Update Stok"><i class="bi bi-pencil"></i></a> 
                                                <form action="/gudang/bahan/delete/<?= $bahan['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan ini?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Hapus"
                                                            <?php if ($bahan['status_terhitung'] !== 'kadaluarsa'): ?>
                                                                disabled 
                                                                onclick="event.preventDefault(); alert('Hanya bahan kadaluarsa yang bisa dihapus.');"
                                                            <?php endif; ?>>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>