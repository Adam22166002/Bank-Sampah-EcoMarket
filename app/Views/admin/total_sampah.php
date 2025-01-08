<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-start align-items-center">
            <h4 class="mr-3 font-weight-bold text-primary"><i class="fas fa-recycle"></i> Total Sampah Terkumpul</h4>
            <div>
                <h4 class="font-weight-bold text-success">+
                    <?= number_format($total_sampah) ?> Kg
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <th>Username</th>
                            <th>Kategori</th>
                            <th>Berat (Kg)</th>
                            <th>Point</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sampah as $s): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($s['created_at'])) ?></td>
                            <td><?= $s['username'] ?></td>
                            <td><?= $s['nama_kategori'] ?></td>
                            <td><?= number_format($s['berat_sampah'], 2) ?></td>
                            <td><?= number_format($s['point_sampah_dijual']) ?></td>
                            <td>
                                <a href="<?= base_url('uploads/bukti/' . $s['bukti_foto']) ?>" 
                                   class="btn btn-info btn-sm" target="_blank">
                                    <i class="fas fa-image"></i> Lihat
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

<?= $this->endSection(); ?>