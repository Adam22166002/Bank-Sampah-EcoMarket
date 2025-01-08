<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>
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

                    <form action="<?= base_url('reset-password/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirm" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>