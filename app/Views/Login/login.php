<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Login</title>
    <link
      href="<?= base_url(); ?>/Assets/vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <!-- Custom styles-->
    <link href="<?= base_url(); ?>/Assets/css/sb-admin-2.min.css" rel="stylesheet" />
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
        margin-top: 18px;
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
                    <div class="text-center mb-4">
                      <img class="align-items-center" style="width: 120px;" src="<?= base_url();?>/Assets/img/eco_market.svg" alt="logo">
                      <?= view('Myth\Auth\Views\_message_block') ?>
                    </div>
                  <form class="user" role="form" method="post" action="<?= url_to('login') ?>"><?= csrf_field() ?>
<?php if ($config->validFields === ['email']): ?>
                      <div class="form-group">
                        <input
                          type="email"
                          name="login"
                          class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                          placeholder="<?=lang('Auth.email')?>"
                        />
                        <div class="invalid-feedback">
                          <?= session('errors.login') ?>
                        </div>
                      </div>
<?php else: ?>
                      <div class="form-group">
                        <input
                          type="text"
                          name="login"
                          class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                          placeholder="<?=lang('Auth.emailOrUsername')?>"
                        />
                        <div class="invalid-feedback">
                          <?= session('errors.login') ?>
                        </div>
                      </div>
<?php endif; ?>
                      <div class="form-group">
                        <input
                          type="password"
                          name="password"
                          class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                          
                          placeholder="<?=lang('Auth.password')?>"
                        />
                        <div class="invalid-feedback">
                          <?= session('errors.password') ?>
                        </div>
                      </div>
<?php if ($config->activeResetter): ?>
                      <div class="mb-2 d-flex justify-content-between">
                        <div></div>
                        <div class="text-end mr-2">
                          <a class="small" href="<?= url_to('forgot') ?>">Forgot Password?</a>
                        </div>
                      </div>
<?php endif; ?>
                      <button
                        type="submit"
                        class="btn btn-primary btn-user btn-block py-3"
                      ><i class="fas fa-paper-plane mr-2"></i>
                        Login
                      </button>

                      <hr />

                    </form>
<?php if ($config->allowRegistration) : ?>
                    <div class="text-center">
                      <a class="small" href="<?= url_to('register') ?>"
                        >Create an Account!</a
                      >
                    </div>
<?php endif; ?>
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
