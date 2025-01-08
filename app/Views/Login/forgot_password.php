<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Forgot Password</title>

    <!-- Custom fonts -->
    <link href="<?= base_url(); ?>/Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles -->
    <link href="<?= base_url(); ?>/Assets/css/sb-admin-2.min.css" rel="stylesheet" />
    
    <style>
        .bg-forgot-image {
            background: url('<?= base_url(); ?>/Assets/img/forgot-password.svg');
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .card-header {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            background: linear-gradient(45deg,rgb(0, 64, 255), #36b9cc);
        }
        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #36b9cc);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.85rem;
        color: #6c757d;
      }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-xl-10">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-forgot-image">
                                <img src="" alt="Ilustasi">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-primary font-weight-bold mb-4">Lupa Password?</h1>
                                    </div>

                                    <?= view('Myth\Auth\Views\_message_block') ?>

                                    <p class="mb-4 text-muted text-center">
                                        Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan instruksi untuk mereset password.
                                    </p>

                                    <form action="<?= url_to('forgot') ?>" method="post" class="user">
                                        <?= csrf_field() ?>

                                        <div class="form-group">
                                            <input type="email" 
                                                   class="form-control form-control-user <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                                   name="email" 
                                                   placeholder="Masukkan email Anda..."
                                                   aria-describedby="emailHelp">
                                            <div class="invalid-feedback text-center">
                                                <?= session('errors.email') ?>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block py-3">
                                            <i class="fas fa-paper-plane mr-2"></i> Kirim Link Reset
                                        </button>
                                    </form>

                                    <hr>

                                    <div class="text-center">
                                        <a href="<?= url_to('login') ?>" class="text-primary">
                                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Footer -->
<footer>
    <div
         class="text-center p-3"
         >
      © 2024 Copyright:
      <a class="text-gray-800" href="<?= base_url('/')?>"
         >Develop Eco Market</a
        >
    </div>
</footer>
    </div>


    <!-- Scripts -->
    <script src="<?= base_url(); ?>/Assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/js/sb-admin-2.min.js"></script>
</body>
</html>