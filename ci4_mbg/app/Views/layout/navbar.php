<?php
$uri = service('uri');
$role = session()->get('role');
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">GUDANG MBG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($role == 'gudang'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'dashboard') ? 'active' : '' ?>" href="/gudang/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'bahan') ? 'active' : '' ?>" href="/gudang/bahan">Bahan Baku</a>
                    </li>
                <?php elseif ($role == 'dapur'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'dashboard') ? 'active' : '' ?>" href="/dapur/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'permintaan') ? 'active' : '' ?>" href="/dapur/permintaan/create">Buat Permintaan</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?= session()->get('name') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>