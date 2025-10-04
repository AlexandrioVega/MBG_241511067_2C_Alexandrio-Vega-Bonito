<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Tambah Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Form Tambah Bahan Baku</h4>
                </div>
                <div class="card-body">
                    
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="/gudang/bahan/store" method="post" id="tambahBahanForm">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label required-field">Nama Bahan</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label required-field">Kategori</label>
                                <input type="text" class="form-control" id="kategori" name="kategori" value="<?= old('kategori') ?>" required>
                                 <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah" class="form-label required-field">Jumlah Stok</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" min="0" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="satuan" class="form-label required-field">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" value="<?= old('satuan') ?>" placeholder="Contoh: kg, liter, pcs" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_masuk" class="form-label required-field">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk') ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kadaluarsa" class="form-label required-field">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="<?= old('tanggal_kadaluarsa') ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="/gudang/bahan" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
        const formValidator = new FormValidator('tambahBahanForm');
    });
</script>
<?= $this->endSection() ?>