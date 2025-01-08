<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">
                    <?php if (session('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session('message')) : ?>
                        <div class="alert alert-success">
                            <?= session('message') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('reset-password/reset') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <input type="hidden" name="email" value="<?= $email ?>">

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" 
                                   class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" 
                                   name="password" 
                                   required>
                            <div class="form-text">
                                Password minimal 8 karakter, harus mengandung huruf besar, huruf kecil, dan angka
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" 
                                   class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" 
                                   name="pass_confirm" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>