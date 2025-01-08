<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4">
            <!-- User Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile User</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle" 
                             src="<?= base_url('Assets/img/' . $user->user_image); ?>" 
                             style="width: 150px; height: 150px;">
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td>Username</td>
                            <td>: <?= esc($user->username) ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: <?= esc($user->email) ?></td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>: <?= esc($user->fullname) ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>: <?= esc($user->role) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: 
                                <span class="badge <?= $user->active ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $user->active ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Bergabung</td>
                            <td>: <?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
<!-- Statistics Card -->
        <div class="col-md-8">
            <?php if($user->role === 'nasabah'): ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Transaksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($stats['total_transaksi']) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Sampah</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($stats['total_sampah'], 2) ?> Kg
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trash fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Point Terkumpul</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($stats['point_terkumpul']) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-coins fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

    <!-- Activitias -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Berat Sampah</th>
                                    <th>Point</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recent_activities as $activity): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></td>
                                    <td><?= number_format($activity['berat_sampah'], 2) ?> Kg</td>
                                    <td><?= number_format($activity['point_sampah_dijual']) ?></td>
                                    <td>
                                        <span class="badge <?= $activity['status'] === 'approved' ? 'bg-success' : 
                                            ($activity['status'] === 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= ucfirst($activity['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>