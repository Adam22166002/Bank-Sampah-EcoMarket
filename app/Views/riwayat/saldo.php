<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Saldo Seller</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td>
                                    <?= $r['jenis'] == 'penukaran_produk' ? 'Penjualan Produk' : 'Penarikan E-Wallet' ?>
                                </td>
                                <td>
                                    <span class="text-<?= $r['jumlah'] >= 0 ? 'success' : 'danger' ?>">
                                        Rp <?= number_format($r['jumlah'], 0, ',', '.') ?>
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