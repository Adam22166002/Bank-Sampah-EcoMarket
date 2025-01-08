<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-primary"> <i class="fas fa-file-alt"></i> Laporan Transaksi User</h5>
            <div>
                <a href="<?= base_url('admin/laporan/excel') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" 
                   class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="<?= base_url('admin/laporan/pdf') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" 
                class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
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
</div>

<?= $this->endSection(); ?>