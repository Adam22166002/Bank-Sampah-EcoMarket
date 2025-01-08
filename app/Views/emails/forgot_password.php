<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4e73df;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <p>Hi <?= $username ?>,</p>
        
        <p>Kami menerima permintaan untuk reset password akun Anda di Eco Market. Jika Anda memang meminta reset password, silahkan klik tombol di bawah ini:</p>
        
        <a href="<?= $resetLink ?>" class="btn">Reset Password</a>
        
        <p>Jika tombol di atas tidak berfungsi, Anda bisa copy dan paste link berikut di browser Anda:</p>
        <p><?= $resetLink ?></p>
        
        <p><strong>Link ini akan kadaluarsa dalam 1 jam.</strong></p>
        
        <p>Jika Anda tidak merasa meminta reset password, Anda bisa mengabaikan email ini. Akun Anda tetap aman.</p>
        
        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; <?= date('Y') ?> Eco Market. All rights reserved.</p>
        </div>
    </div>
</body>
</html>