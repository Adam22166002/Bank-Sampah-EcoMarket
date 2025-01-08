<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Point Nasabah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah Point</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td>
                                    <?php
                                    switch($r['jenis']) {
                                        case 'transaksi_sampah':
                                            echo 'Penjualan Sampah';
                                            break;
                                        case 'penukaran_produk':
                                            echo 'Penukaran Produk';
                                            break;
                                        case 'penarikan_ewallet':
                                            echo 'Penarikan E-Wallet';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span class="text-<?= $r['jumlah'] >= 0 ? 'success' : 'danger' ?>">
                                        <?= $r['jumlah'] >= 0 ? '+' : '' ?><?= number_format($r['jumlah']) ?>
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