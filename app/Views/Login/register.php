<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <link href="<?= base_url(); ?>/Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="<?= base_url(); ?>/Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
      .btn-primary {
        background: linear-gradient(45deg, rgb(0, 64, 255), #36b9cc);
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

      @media (max-width: 576px) {
        .card {
          margin: 10px 0;
        }

        .btn {
          font-size: 0.9rem;
        }

        footer {
          font-size: 0.8rem;
        }
      }
    </style>
</head>

<body class="bg-light">
<div class="container">
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-10">
        <div class="card o-hidden border-0 shadow-lg my-5 shadow-lg rounded-4">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-4">
                            <div class="text-center">
                                <h1 class="h4 text-primary font-weight-bold mb-4">Create an Account!</h1>
                            </div>

                            <?= view('Myth\Auth\Views\_message_block') ?>

                            <form action="<?= url_to('register') ?>" method="post" class="user">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                <input type="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email"
                                    placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                                    <small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                                </div>

                                <div class="form-group">
                                <input type="text" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username"
                                    placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>"/>
                                </div>
                                <div class="form-group">
                                    <select name="group" class="form-control rounded-pill" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        <?php if(isset($groups) && is_array($groups)): foreach($groups as $group): ?>
                                            <option value="<?= esc($group->name) ?>">
                                                <?= esc(ucfirst($group->name)) ?>
                                            </option>
                                        <?php endforeach; 
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" 
                                            placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" name="pass_confirm" 
                                        placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-paper-plane mr-2"></i><?=lang('Auth.register')?>
                                </button>
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= url_to('forgot') ?>">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <p class="small"><?=lang('Auth.alreadyRegistered')?> <a class="medium" href="<?= url_to('login') ?>"><?=lang('Auth.signIn')?> <i class="fas fa-arrow-right mr-2"></i></a></p>
                            </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/Assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/Assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>/Assets/js/sb-admin-2.min.js"></script>

</body>

</html>