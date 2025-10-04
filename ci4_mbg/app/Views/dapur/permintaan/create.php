<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Buat Permintaan Bahan Baku
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Form Permintaan Bahan Baku</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <form action="/dapur/permintaan/store" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tgl_masak" class="form-label required-field">Tanggal Masak</label>
                                <input type="date" class="form-control" id="tgl_masak" name="tgl_masak" value="<?= old('tgl_masak') ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="menu_makan" class="form-label required-field">Menu yang Akan Dibuat</label>
                                <input type="text" class="form-control" id="menu_makan" name="menu_makan" value="<?= old('menu_makan') ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jumlah_porsi" class="form-label required-field">Jumlah Porsi</label>
                                <input type="number" class="form-control" id="jumlah_porsi" name="jumlah_porsi" value="<?= old('jumlah_porsi') ?>" min="1" required>
                            </div>
                        </div>

                        <hr>
                        
                        <h5>Daftar Bahan yang Dibutuhkan</h5>
                        <div id="bahan-list">
                            </div>

                        <button type="button" id="add-bahan" class="btn btn-outline-success btn-sm mt-2"><i class="bi bi-plus-lg"></i> Tambah Bahan</button>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="/dapur/dashboard" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Ajukan Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bahan-template" style="display: none;">
    <div class="row align-items-end bahan-row mb-2">
        <div class="col-md-6">
            <label class="form-label">Nama Bahan</label>
            <select class="form-select" name="bahan_id[]" required>
                <option value="" selected disabled>-- Pilih Bahan --</option>
                <?php foreach ($bahan_list as $bahan): ?>
                    <option value="<?= $bahan['id'] ?>"><?= esc($bahan['nama']) ?> (Stok: <?= $bahan['jumlah'] ?> <?= $bahan['satuan'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah[]" min="1" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-bahan w-100">Hapus</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBahanBtn = document.getElementById('add-bahan');
    const bahanList = document.getElementById('bahan-list');
    const template = document.getElementById('bahan-template');

    function addNewRow() {
        const newRow = template.firstElementChild.cloneNode(true);
        bahanList.appendChild(newRow);
    }
    
    // Tambah baris baru saat tombol diklik
    addBahanBtn.addEventListener('click', addNewRow);

    // Hapus baris saat tombol 'Hapus' di baris tersebut diklik
    bahanList.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-bahan')) {
            e.target.closest('.bahan-row').remove();
        }
    });
    
    // Tambahkan satu baris secara default saat halaman dimuat
    addNewRow();
});
</script>
<?= $this->endSection() ?>