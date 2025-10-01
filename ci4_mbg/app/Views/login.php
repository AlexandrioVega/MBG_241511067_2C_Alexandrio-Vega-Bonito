<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-primary text-white">
                <h4>LOGIN SISTEM GUDANG MBG</h4>
            </div>
            <div class="card-body p-4">
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="/login" method="post" id="loginForm">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="email" class="form-label required-field">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label required-field">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                         <div class="invalid-feedback"></div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    // Inisialisasi validator untuk form login
    document.addEventListener('DOMContentLoaded', function () {
        const loginValidator = new FormValidator('loginForm');
    });
</script>
<?= $this->endSection() ?>