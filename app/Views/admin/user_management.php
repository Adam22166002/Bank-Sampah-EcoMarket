<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
<?= csrf_field() ?>
    <div class="row py-3">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h3 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus"></i> Daftar User</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= esc($user->username); ?></td>
                                        <td><?= esc($user->email); ?></td>
                                        <td><?= esc($user->name); ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/user/' . $user->userid); ?>" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                        <td>
                                            <select class="form-select activation-select" 
                                                    data-user-id="<?= $user->userid ?>"
                                                    data-current-status="<?= $user->active ?>"
                                                    onchange="updateActivation(this)">
                                                <option value="1" <?= $user->active == 1 ? 'selected' : '' ?>>Active</option>
                                                <option value="0" <?= $user->active == 0 ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restore status selections from localStorage if exists
    document.querySelectorAll('.activation-select').forEach(select => {
        const userId = select.dataset.userId;
        const savedStatus = localStorage.getItem(`user_status_${userId}`);
        if (savedStatus !== null) {
            select.value = savedStatus;
        } else {
            // Jika tidak ada di localStorage, gunakan status current dari data-attribute
            select.value = select.dataset.currentStatus;
        }
    });
    
    // DataTable initialization jika diperlukan
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#dataTable').DataTable();
    }
});

function updateActivation(select) {
    const userId = select.dataset.userId;
    const status = select.value;
    const token = document.querySelector('input[name="<?= csrf_token() ?>"]').value;

    fetch('<?= base_url('admin/user/activation') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `user_id=${userId}&status=${status}&<?= csrf_token() ?>=${token}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem(`user_status_${userId}`, status);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: status == 1 
                    ? 'Pengguna berhasil diaktifkan.' 
                    : 'Pengguna berhasil dinonaktifkan.',
                timer: 2000,
                showConfirmButton: true
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Gagal memperbarui status.',
                timer: 2000,
                showConfirmButton: true
            });
            const savedStatus = localStorage.getItem(`user_status_${userId}`);
            if (savedStatus !== null) {
                select.value = savedStatus;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan!',
            text: 'Terjadi kesalahan saat memperbarui status.',
            timer: 2000,
            showConfirmButton: true
        });
        const savedStatus = localStorage.getItem(`user_status_${userId}`);
        if (savedStatus !== null) {
            select.value = savedStatus;
        }
    });
}
</script>

<?= $this->endSection(); ?>