<?= $this->extend('layout/template') ?>
<?= $this->section('title') ?>Riwayat Permintaan Bahan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
             <h3 class="mb-3">Riwayat Permintaan Bahan Baku</h3>
            <div class="card shadow-sm">
                 <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Permintaan Anda</h5>
                    <a href="/dapur/permintaan/create" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Buat Permintaan Baru</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tgl Permintaan</th>
                                    <th>Tgl Masak</th>
                                    <th>Menu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($permintaan_list)): ?>
                                    <tr><td colspan="6" class="text-center">Anda belum pernah membuat permintaan.</td></tr>
                                <?php else: ?>
                                    <?php $i = 1; foreach ($permintaan_list as $p): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d M Y H:i', strtotime($p['created_at'])) ?></td>
                                        <td><?= date('d M Y', strtotime($p['tgl_masak'])) ?></td>
                                        <td><?= esc($p['menu_makan']) ?></td>
                                        <td>
                                            <?php
                                                $status = $p['status'];
                                                $badge_class = '';
                                                switch ($status) {
                                                    case 'menunggu': $badge_class = 'bg-warning text-dark'; break;
                                                    case 'disetujui': $badge_class = 'bg-success'; break;
                                                    case 'ditolak': $badge_class = 'bg-danger'; break;
                                                }
                                            ?>
                                            <span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span>
                                        </td>
                                        <td>
                                            <a href="/dapur/permintaan/detail/<?= $p['id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
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