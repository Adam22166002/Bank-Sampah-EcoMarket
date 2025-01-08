<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h6 ml-2 mt-3 mb-4 text-gray-800"><i class="fa fa-home"></i> Dashboard Admin Managemen</h1>
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Admin</div>
                            <a class="h5 font-weight-bold text-gray-800" href="<?= base_url('admin/user-management') ?>">User</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card border-left-success shadow h-100 py-2" role="button" data-bs-toggle="modal" data-bs-target="#modalNasabahAktif">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nasabah Active</div>
                            <a class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_nasabah_active ?></a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Semua Transaksi</div>
                            <a class="h5 mb-0 font-weight-bold text-gray-800" href="<?= base_url('admin/laporan') ?>"><?= number_format($total_transaksi) ?></a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sampah Terkumpul</div>
                            <a href="<?= base_url('admin/sampah') ?>" class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($total_sampah) ?> Kg
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-recycle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivasi User dan Nasabah Active -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title font-weight-bold text-primary"><i class="fas fa-user-clock"></i> Aktivasi User</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= esc($user->username); ?></td>
                                        <td><?= esc($user->name); ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/user/' . $user->userid); ?>" 
                                                class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nasabah Active -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title font-weight-bold text-primary"><i class="fas fa-user-check"></i> Nasabah Active</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataNasabah" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                                <?php foreach ($nasabah_active as $nasabah): ?>
                                    <?php if($nasabah->active == 1): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= esc($nasabah->username); ?></td>
                                        <td><?= esc($nasabah->email); ?></td>
                                        <td><?= esc($nasabah->role); ?></td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Laporan -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-primary"> <i class="fas fa-file-alt"></i> Semua Transaksi User</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Username</th>
                            <th>Tipe Transaksi</th>
                            <th>Detail Transaksi</th>
                            <th>Status</th>
                            <th>Point/Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td><?= date('l, d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><?= $t['username'] ?></td>
                            <td><?= ucwords(str_replace('_', ' ', $t['tipe_transaksi'])) ?></td>
                            <td>
                                <?php
                                switch ($t['tipe_transaksi']) {
                                    case 'transaksi_sampah':
                                        echo "{$t['nama_kategori']} - {$t['berat_sampah']} kg";
                                        break;
                                    case 'penukaran_produk':
                                        echo $t['nama_produk'];
                                        break;
                                    case 'penarikan_ewallet':
                                        echo "Penarikan ke {$t['no_ewallet']}";
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $t['status'] == 'approved' ? 'success' : 
                                    ($t['status'] == 'pending' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($t['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?= isset($t['point_sampah_dijual']) ? number_format($t['point_sampah_dijual']) : 
                                    (isset($t['point_tukar']) ? number_format($t['point_tukar']) : 
                                    number_format($t['jumlah_point'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Card Verifikasi Sampah Nasabah -->                                
<div class="card m-2">
    <div class="card-header">
        <h5 class="card-title font-weight-bold text-primary"><i class="fas fa-exchange-alt"></i> Transaksi Sampah Nasabah</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Username</th>
                        <th>Kategori</th>
                        <th>Berat</th>
                        <th>Point</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $t) : ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><?= $t['username'] ?></td>
                            <td><?= $t['nama_kategori'] ?></td>
                            <td><?= $t['berat_sampah'] ?> kg</td>
                            <td><?= $t['point_sampah_dijual'] ?></td>
                            <td>
                                <?php if($t['status'] == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($t['status'] == 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
 <!-- Modal Nasabah Aktif -->
<div class="modal fade" id="modalNasabahAktif" tabindex="-1" aria-labelledby="modalNasabahAktifLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalNasabahAktifLabel">
                    <i class="fas fa-users"></i> Daftar Nasabah Active
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="nasabahTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Point</th>
                                <th>Total Sampah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($nasabah_active as $nasabah): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= esc($nasabah->username); ?></td>
                                <td><?= esc($nasabah->email); ?></td>
                                <td><?= esc($nasabah->role); ?></td>
                                <td><?= number_format($nasabah->total_point); ?></td>
                                <td><?= number_format($nasabah->total_sampah); ?> kg</td>
                                <td>
                                    <select class="form-select activation-select" 
                                            data-user-id="<?= esc($nasabah->userid) ?>"
                                            data-current-status="<?= esc($nasabah->active) ?>"
                                            onchange="updateActivation(this)">
                                        <option value="1" <?= $nasabah->active == 1 ? 'selected' : '' ?> class="text-success">Active</option>
                                        <option value="0" <?= $nasabah->active == 0 ? 'selected' : '' ?> class="text-danger">Inactive</option>
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


<script>
$(document).ready(function() {
    $('#nasabahTable').DataTable({
        "pageLength": 10,
        "responsive": true
    });
});

// Update activasi status
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
            select.value = select.dataset.currentStatus;
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
        select.value = select.dataset.currentStatus;
    });
}
</script>
<?= $this->endSection(); ?>
