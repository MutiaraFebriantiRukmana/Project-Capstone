<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title)) ? $title : 'NA Celluler'; ?> | System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #E0F7F1; font-family: 'Poppins', sans-serif; margin: 0; }
        .sidebar { width: 280px; height: 100vh; position: fixed; background: white; padding: 30px 20px; z-index: 100; display: flex; flex-direction: column; }
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; display: block !important; }
        .nav-link { color: #333; padding: 12px 15px; border-radius: 12px; margin-bottom: 10px; display: flex; align-items: center; text-decoration: none; font-weight: 500; }
        .nav-link:hover { background-color: #f1f5f9; }
        .nav-link.active { background-color: #5EEAD4; color: #000 !important; font-weight: 600; }
        .logout-link { margin-top: auto; color: red !important; font-weight: 600; text-decoration: none; padding: 12px 15px; }
        .card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; }
    </style>
</head>
<body>

<div class="sidebar shadow-sm">
    <div class="d-flex align-items-center mb-5 ps-2">
        <img src="<?= base_url('logo.png') ?>" alt="Logo" style="width: 45px;" class="me-2">
        <div>
            <h5 class="fw-bold m-0" style="font-size: 16px;">NA Celluler</h5>
            <span style="font-size: 12px; color: #5EEAD4; font-weight: bold;"><?= ucfirst(session()->get('role') ?? 'User'); ?></span>
        </div>
    </div>

    <!-- Sidebar -->
        <nav class="nav flex-column">
            <a class="nav-link" href="#">📊 Dashboard</a>

            <?php if (session()->get('role') == 'owner') : ?>
                <a class="nav-link <?= (isset($title) && $title == 'Manajemen Stok Barang') ? 'active' : '' ?>" href="<?= base_url('owner/barang-masuk') ?>">📦 Barang Masuk</a>
                <a class="nav-link" href="<?= base_url('owner/barang-keluar') ?>">📤 Barang Keluar</a>
                <a class="nav-link <?= (isset($title) && $title == 'Laporan Penjualan Owner') ? 'active' : '' ?>" href="<?= base_url('owner/laporan-penjualan') ?>">📝 Laporan Penjualan</a>
                <a class="nav-link" href="#">📈 Analisist</a>
            <?php endif; ?>

            <?php if (session()->get('role') == 'admin') : ?>
                <a class="nav-link <?= (isset($title) && $title == 'Daftar Stok Barang') ? 'active' : '' ?>" href="<?= base_url('admin/stok-barang') ?>">📦 Stok Barang</a>
                <a class="nav-link <?= (isset($title) && $title == 'Laporan Penjualan') ? 'active' : '' ?>" href="<?= base_url('admin/laporan') ?>">💰 Laporan Penjualan</a>
            <?php endif; ?>

            <a class="logout-link" href="<?= base_url('auth/logout') ?>">🚪 Logout</a>
        </nav>
</div>

<div class="main-content">