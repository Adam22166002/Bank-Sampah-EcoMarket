<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-4">
<!-- Riwayat Penarikan -->
<div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pencairan Dana</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Point</th>
                            <th>Rupiah</th>
                            <th>No. DANA</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td><?= number_format($r['jumlah_point']) ?></td>
                                <td>Rp <?= number_format($r['jumlah_rupiah'], 0, ',', '.') ?></td>
                                <td><?= $r['no_ewallet'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $r['status'] == 'pending' ? 'warning' : 
                                        ($r['status'] == 'approved' ? 'success' : 'danger') ?>">
                                        <?= ucfirst($r['status']) ?>
                                    </span>
                                </td>
                                <td><small class="text-muted"><?= $r['keterangan'] ?? 'Menunggu transfer' ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>