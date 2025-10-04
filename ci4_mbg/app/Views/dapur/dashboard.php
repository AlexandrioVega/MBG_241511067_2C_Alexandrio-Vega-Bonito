<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Dashboard Dapur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h3 class="mb-0">Dashboard Petugas Dapur</h3>
            <p class="text-muted">Selamat datang kembali, <?= esc(session()->get('name')) ?>!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Menunggu</h5>
                        <p class="card-text fs-2 fw-bold"><?= $total_menunggu ?></p>
                    </div>
                    <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Disetujui</h5>
                        <p class="card-text fs-2 fw-bold"><?= $total_disetujui ?></p>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Ditolak</h5>
                        <p class="card-text fs-2 fw-bold"><?= $total_ditolak ?></p>
                    </div>
                    <i class="bi bi-x-circle" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Permintaan Terakhir</h5>
                    <a href="/dapur/permintaan/create" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Buat Permintaan Baru</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tgl Masak</th>
                                    <th>Menu</th>
                                    <th>Jml Porsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($permintaan_terakhir)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Anda belum pernah membuat permintaan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($permintaan_terakhir as $permintaan): ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($permintaan['tgl_masak'])) ?></td>
                                            <td><?= esc($permintaan['menu_makan']) ?></td>
                                            <td><?= esc($permintaan['jumlah_porsi']) ?></td>
                                            <td>
                                                <?php
                                                    $status = $permintaan['status'];
                                                    $badge_class = '';
                                                    switch ($status) {
                                                        case 'menunggu':
                                                            $badge_class = 'bg-warning text-dark';
                                                            break;
                                                        case 'disetujui':
                                                            $badge_class = 'bg-success';
                                                            break;
                                                        case 'ditolak':
                                                            $badge_class = 'bg-danger';
                                                            break;
                                                    }
                                                ?>
                                                <span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span>
                                            </td>
                                            <td>
                                                <a href="/dapur/permintaan/detail/<?= $permintaan['id'] ?>" class="btn btn-info btn-sm" title="Lihat Detail"><i class="bi bi-eye"></i></a>
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