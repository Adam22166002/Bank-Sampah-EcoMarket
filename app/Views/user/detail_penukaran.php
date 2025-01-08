<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Detail Penukaran Produk</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Produk</dt>
                        <dd class="col-sm-8"><?= $penukaran['nama_produk'] ?></dd>
                        
                        <dt class="col-sm-4">Point</dt>
                        <dd class="col-sm-8"><?= number_format($penukaran['harga_produk']) ?></dd>
                        
                        <dt class="col-sm-4">Tanggal</dt>
                        <dd class="col-sm-8"><?= date('d/m/Y H:i', strtotime($penukaran['created_at'])) ?></dd>
                        
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-<?= $penukaran['status'] == 'pending' ? 'warning' : 
                                ($penukaran['status'] == 'redeemed' ? 'success' : 'danger') ?>">
                                <?= ucfirst($penukaran['status']) ?>
                            </span>
                        </dd>
                        
                        <dt class="col-sm-4">Lokasi</dt>
                        <dd class="col-sm-8"><?= $penukaran['lokasi'] ?></dd>
                    </dl>
                </div>
                <div class="col-md-6 text-center">
                    <h5>Barcode Penukaran</h5>
                    <img src="<?= base_url('uploads/qrcodes/' . $penukaran['barcode'] . '.png') ?>" 
                         alt="QR Code" class="img-fluid mb-2" style="max-width: 200px;">
                    <p class="text-muted">Barcode: <?= $penukaran['barcode'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>