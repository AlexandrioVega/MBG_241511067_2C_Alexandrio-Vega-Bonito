<?= $this->extend('layout/template') ?>
<?= $this->section('title') ?>Detail Permintaan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header"><h4>Detail Permintaan</h4></div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Tgl Masak:</strong> <?= date('d M Y', strtotime($permintaan['tgl_masak'])) ?></div>
                        <div class="col-md-6"><strong>Status:</strong> 
                            <?php
                                $status = $permintaan['status'];
                                $badge_class = '';
                                switch ($status) {
                                    case 'menunggu': $badge_class = 'bg-warning text-dark'; break;
                                    case 'disetujui': $badge_class = 'bg-success'; break;
                                    case 'ditolak': $badge_class = 'bg-danger'; break;
                                }
                            ?>
                            <span class="badge <?= $badge_class ?>"><?= ucfirst($status) ?></span>
                        </div>
                    </div>
                    <div class="mb-3"><strong>Menu:</strong> <?= esc($permintaan['menu_makan']) ?></div>
                    
                    <?php if ($permintaan['status'] == 'ditolak' && !empty($permintaan['alasan_penolakan'])): ?>
                        <div class="alert alert-danger">
                            <strong>Alasan Penolakan:</strong>
                            <p class="mb-0"><?= esc($permintaan['alasan_penolakan']) ?></p>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <h5>Bahan yang Diminta:</h5>
                    <ul class="list-group">
                        <?php foreach ($detail_bahan as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= esc($item['bahan_nama']) ?>
                                <span class="badge bg-primary rounded-pill"><?= esc($item['jumlah_diminta']) ?> <?= esc($item['satuan']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/dapur/permintaan" class="btn btn-secondary">Kembali ke Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>