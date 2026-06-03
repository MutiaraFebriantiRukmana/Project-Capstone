<!DOCTYPE html>
<html>
<head>
    <title>Dashboard NaCelluler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h4>Halo, <?= session()->get('username') ?>!</h4>
            <p>Anda login sebagai: <strong><?= session()->get('role') ?></strong></p>
        </div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>