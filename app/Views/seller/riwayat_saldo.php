<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-4">
    <!-- Point Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Total Point Saat Ini</h6>
        </div>
        <div class="card-body">
            <h2 class="font-weight-bold text-primary"><?= number_format(user()->total_point) ?> Point</h2>
        </div>
    </div>

    <!-- Riwayat Point -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Point</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="riwayatTable">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Point</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <tr data-username="<?= $r['username'] ?>">
                                <td><?= $r['username'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                <td>
                                    <?php
                                    switch($r['jenis']) {
                                        case 'jualSampah':
                                            echo 'Penjualan Sampah';
                                            break;
                                        case 'tukarProduk':
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
                                <td><?= $r['keterangan'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
