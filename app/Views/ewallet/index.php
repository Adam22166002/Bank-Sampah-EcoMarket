<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <?php if(session('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">


        <!-- Modal Form Penarikan -->
<div class="modal fade" id="penarikanModal" tabindex="-1" aria-labelledby="penarikanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penarikanModalLabel">
                    <?= ($role === 'seller') ? 'Form Penarikan Saldo' : 'Form Penarikan Point' ?> ke DANA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                $formAction = ($role === 'seller') ? 
                    base_url('seller/ewallet/store') : 
                    base_url('nasabah/ewallet/store');
                ?>
                <form action="<?= $formAction ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="jumlah_point" class="form-label">
                            <?= ($role === 'seller') ? 'Jumlah Saldo' : 'Jumlah Point' ?>
                        </label>
                        <input type="number" name="jumlah_point" class="form-control" required
                            min="1" max="<?= user()->total_point ?>">
                        <small class="text-muted">1 Point = Rp 100</small>
                    </div>

                    <div class="mb-3">
                        <label for="no_ewallet" class="form-label">Nomor DANA</label>
                        <input type="text" name="no_ewallet" class="form-control" required
                               placeholder="08xxxxxxxxxx">
                        <small class="text-muted">Masukkan nomor DANA yang terdaftar</small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Submit Penarikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Riwayat Penarikan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Penarikan</h6>
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
                                <td><?= $r['keterangan'] ?? '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>