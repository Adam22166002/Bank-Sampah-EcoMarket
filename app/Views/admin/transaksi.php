<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
<h1 class="h5 ml-3 mt-3 mb-4 text-gray-800"><i class="fa fa-recycle"></i> Dashboard Transaksi Sampah</h1>
    <?php if(session('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
<div class="card m-2">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-check"></i> Verifikasi Transaksi Sampah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Username</th>
                            <th>Kategori</th>
                            <th>Berat (kg)</th>
                            <th>Point</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $t): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><?= $t['username'] ?></td>
                            <td><?= $t['nama_kategori'] ?></td>
                            <td><?= $t['berat_sampah'] ?></td>
                            <td><?= number_format($t['point_sampah_dijual']) ?></td>
                            <td>
                                <a href="<?= base_url('uploads/bukti/' . $t['bukti_foto']) ?>" target="_blank">
                                    <img src="<?= base_url('uploads/bukti/' . $t['bukti_foto']) ?>" 
                                         alt="Bukti" width="50">
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-<?= $t['status'] == 'pending' ? 'warning' : 
                                    ($t['status'] == 'approved' ? 'success' : 'danger') ?>">
                                    <?= ucfirst($t['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($t['status'] == 'pending'): ?>
                                    <form action="<?= base_url('admin/transaksi_sampah/verifikasi/' . $t['id']) ?>" 
                                          method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="<?= base_url('admin/transaksi_sampah/verifikasi/' . $t['id']) ?>" 
                                          method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <?php if($t['status'] == 'approved'): ?>
                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i> Disetujui pada 
                                            <?= date('d/m/Y H:i', strtotime($t['tanggal_verifikasi'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle"></i> Ditolak pada 
                                            <?= date('d/m/Y H:i', strtotime($t['tanggal_verifikasi'])) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
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
<?= $this->endSection(); ?>