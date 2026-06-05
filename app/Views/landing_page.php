<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NA Cell System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .logo-img {
            width: 150px; 
            margin-bottom: 20px;
        }

        h4 {
            font-weight: 600;
            color: #1a237e; 
            margin-bottom: 5px;
        }

        p.subtitle {
            color: #757575;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #444;
            display: block;
            text-align: left;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: #00bcd4; 
            box-shadow: 0 0 0 0.25 margin rgba(0, 188, 212, 0.25);
        }

        .btn-login {
            background: linear-gradient(to right, #1a237e, #00bcd4);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 10px;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            box-shadow: 0 5px 15px rgba(0, 188, 212, 0.4);
            color: white;
        }

        .footer-text {
            margin-top: 25px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Logo -->
    <img src="<?= base_url('logo.png') ?>" alt="NA Cell Logo" class="logo-img">
    
    <h4>Welcome Back</h4>
    <p class="subtitle">Silakan login ke akun Anda</p>

    <!-- Error Message -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger py-2" style="font-size: 13px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/login') ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="email addres" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password" required>
        </div>

        <button type="submit" class="btn btn-login shadow-sm">LOG IN</button>
    </form>

    <div class="footer-text">
        &copy; <?= date('Y') ?> NA Celluler by MFR
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>