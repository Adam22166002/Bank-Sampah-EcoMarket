<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">

                    <form id="formResetPassword" action="<?= base_url('reset-password/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" 
                                   class="form-control <?php if(session('errors.current_password')) : ?>is-invalid<?php endif ?>" 
                                   name="current_password" 
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" 
                                   class="form-control <?php if(session('errors.new_password')) : ?>is-invalid<?php endif ?>" 
                                   name="new_password" 
                                   required>
                            <div class="form-text">
                                Password minimal 8 karakter, harus mengandung huruf besar, huruf kecil, dan angka
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" 
                                   class="form-control <?php if(session('errors.password_confirm')) : ?>is-invalid<?php endif ?>" 
                                   name="password_confirm" 
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cek flash messages
    <?php if (session()->getFlashdata('message')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('message') ?>',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?= session()->getFlashdata('error') ?>',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    <?php endif; ?>

    // Handle form submission
    document.getElementById('formResetPassword').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin mengubah password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
<?= $this->endSection(); ?>