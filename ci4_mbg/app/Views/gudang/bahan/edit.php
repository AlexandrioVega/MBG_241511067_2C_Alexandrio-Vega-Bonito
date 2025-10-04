<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Update Stok Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Form Update Stok: <?= esc($bahan['nama']) ?></h4>
                </div>
                <div class="card-body">
                    
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                             <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <p><?= esc($error) ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>

                    <form action="/gudang/bahan/update/<?= $bahan['id'] ?>" method="post" id="updateStokForm">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control" value="<?= esc($bahan['nama']) ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" class="form-control" value="<?= esc($bahan['kategori']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label required-field">Jumlah Stok</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah', $bahan['jumlah']) ?>" min="0" required>
                            <div class="invalid-feedback"></div>
                            <div class="form-text">Hanya kolom ini yang dapat diubah.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="/gudang/bahan" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    // Inisialisasi validator untuk form
    document.addEventListener('DOMContentLoaded', function () {
        const formValidator = new FormValidator('updateStokForm');
    });
script>
<?= $this->endSection() ?>