<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'NA Celluler'; ?> | System</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --mint-green: #5EEAD4;
            --sidebar-bg: #ffffff;
            --main-bg: #E0F7F1;
            --text-dark: #334155;
            --text-muted: #94a3b8;
        }

        body { 
            background-color: var(--main-bg); 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
        }

        /* Sidebar Styling */
        .sidebar { 
            width: 280px; 
            height: 100vh; 
            position: fixed; 
            background: var(--sidebar-bg); 
            padding: 40px 24px; 
            display: flex; 
            flex-direction: column; 
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,0,0,0.02);
        }

        .brand-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding-left: 10px;
        }
        
        .brand-logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            margin-right: 12px;
        }

        .brand-name {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-dark);
            margin: 0;
        }

        .brand-role {
            font-size: 12px;
            color: var(--mint-green);
            font-weight: 600;
            display: block;
            margin-top: -4px;
        }

        /* Nav Link Styling */
        .nav-link { 
            color: var(--text-dark); 
            padding: 14px 18px; 
            border-radius: 14px; 
            margin-bottom: 6px; 
            display: flex; 
            align-items: center; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500;
            transition: all 0.3s ease;
        }

        /* Fix Ikon Agar Lurus */
        .nav-link i { 
            width: 30px; 
            font-size: 18px; 
            color: var(--text-muted);
            transition: all 0.3s ease;
            text-align: left;
        }

        .nav-link:hover { 
            background-color: #f8fafc; 
        }

        /* State Active (Warna Hijau Mint) */
        .nav-link.active { 
            background-color: var(--mint-green); 
            color: #000 !important; 
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(94, 234, 212, 0.3);
        }

        .nav-link.active i { 
            color: #000; 
        }

        /* Logout Section */
        .logout-section {
            margin-top: auto;
        }

        .logout-link { 
            color: #ef4444 !important; 
            font-weight: 600; 
            text-decoration: none; 
            padding: 14px 18px; 
            display: flex; 
            align-items: center;
            border-radius: 14px;
        }
        
        .logout-link i {
            margin-right: 12px;
            font-size: 18px;
        }

        .logout-link:hover {
            background-color: #fef2f2;
        }

        /* Content Area */
        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh; 
        }

        .card {
            border-radius: 24px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <!-- Brand & Logo -->
    <div class="brand-section">
        <img src="<?= base_url('logo.png') ?>" alt="Logo" class="brand-logo">
        <div>
            <h5 class="brand-name">NA Celluler</h5>
            <span class="brand-role"><?= ucfirst(session()->get('role') ?? 'User'); ?></span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav flex-column">
        <!-- Dashboard (Semua Role) -->
        <a class="nav-link <?= (($title ?? '') == 'Dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
            <!-- Menu Khusus Owner -->
            <?php if(session()->get('role') == 'owner'): ?>
                <a class="nav-link <?= ($title == 'Master Barang') ? 'active' : '' ?>" href="<?= base_url('owner/master-barang') ?>"><i class="fa-solid fa-file-invoice"></i> Master Barang</a>
                <a class="nav-link <?= ($title == 'Detail Barang') ? 'active' : '' ?>" href="<?= base_url('owner/detail-barang') ?>"><i class="fa-solid fa-list-ul"></i> Detail Barang</a>
                <a class="nav-link <?= ($title == 'Stok Barang') ? 'active' : '' ?>" href="<?= base_url('admin/stok-barang') ?>"><i class="fa-solid fa-boxes-stacked"></i> Stok Barang</a>
                <a class="nav-link <?= ($title == 'Barang Keluar') ? 'active' : '' ?>" href="<?= base_url('owner/barang-keluar') ?>"><i class="fa-solid fa-truck-ramp-box"></i> Barang Keluar</a>
                <a class="nav-link <?= ($title == 'Analisis') ? 'active' : '' ?>" href="<?= base_url('owner/analisis') ?>"><i class="fa-solid fa-magnifying-glass-chart"></i> Analisist</a>
                <a class="nav-link <?= ($title == 'Laporan') ? 'active' : '' ?>" href="<?= base_url('owner/laporan') ?>"><i class="fa-solid fa-file-pdf"></i> Laporan</a>
            <?php endif; ?>

        <?php if (session()->get('role') == 'admin') : ?>
            <!-- Menu Khusus Admin -->
            <a class="nav-link <?= (($title ?? '') == 'Stok Barang') ? 'active' : '' ?>" href="<?= base_url('admin/stok-barang') ?>">
                <i class="fa-solid fa-boxes-stacked"></i> Stok Barang
            </a>
            <a class="nav-link <?= (($title ?? '') == 'Barang Keluar') ? 'active' : '' ?>" href="<?= base_url('admin/barang-keluar') ?>">
                <i class="fa-solid fa-cart-shopping"></i> Barang Keluar
            </a>
            <a class="nav-link <?= (($title ?? '') == 'Laporan') ? 'active' : '' ?>" href="<?= base_url('admin/laporan') ?>">
                <i class="fa-solid fa-file-pdf"></i> Laporan
            </a>
        <?php endif; ?>
    </nav>

    <!-- Logout -->
    <div class="logout-section">
        <a class="logout-link" href="<?= base_url('auth/logout') ?>">
            <i class="fa-solid fa-power-off"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">