<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<!-- Hero Section -->
<div class="hero-section py-3">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="text-primary font-weight-bold mb-2">Tukar Point Anda</h2>
                <p class="text-muted medium mb-2">Dapatkan berbagai produk menarik dengan point yang telah Anda kumpulkan</p>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4 bg-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url();?>/Assets/img/logo_point.svg" 
                                alt="Logo App" 
                                style="width: 45px;">
                            <div class="ml-3">
                                <span class="h6 text-white text-uppercase mb-1">
                                    Point Eco Market
                                </span>
                                <?php 
                                $totalPoint = model('TransaksiSampahModel')->getTotalPointUser(user()->username);
                                ?>
                                <div class="h6 mb-0  text-white">
                                <?= number_format(user()->total_point) ?> Point </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute bottom-0 end-0 opacity-10">
        <i class="fas fa-recycle fa-5x text-gray-300"></i>
    </div>
    </div>
</div>

<div class="container mt-4">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<?php 
$totalPoint = user()->total_point;
?>
<!-- Product Section -->
<section class="products-section py-3">
        <h2 class="text-center font-weight-bold mb-5">Produk Tersedia Saat ini</h2>
<div class="bg-light p-1">
    <div class="row g-2">
        <?php if(empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada produk tersedia saat ini.
                </div>
            </div>
        <?php else: ?>
            <?php foreach($products as $product): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <img src="<?= base_url('uploads/fotoProduk/' . $product['foto_produk']) ?>" 
                             class="card-img-top" 
                             alt="<?= $product['nama_produk'] ?>"
                             style="height: 120px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="card-title text-primary mb-1"><?= $product['nama_produk'] ?></h6>
                            <p class="card-text small text-muted mb-2"><?= substr($product['deskripsi'], 0, 50) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><?= number_format($product['harga_produk']) ?> pts</span>
                                <small class="text-muted">Stok: <?= $product['stok'] ?></small>
                            </div>
                            <?php if($totalPoint >= $product['harga_produk'] && $product['stok'] > 0): ?>
                                <button data-requires-connection class="btn btn-primary btn-sm w-100 mt-2" 
                                        onclick="confirmExchange('<?= $product['nama_produk'] ?>', <?= $product['harga_produk'] ?>, <?= $product['produk_id'] ?>)">
                                    <i class="fas fa-exchange-alt me-1"></i>Tukar
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm w-100 mt-2" disabled>
                                    <?php if($totalPoint < $product['harga_produk']): ?>
                                        <i class="fas fa-lock me-1"></i>Point Tidak Cukup
                                    <?php else: ?>
                                        <i class="fas fa-times me-1"></i>Stok Habis
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</section>

<!--Riwayat Penukaran-->
<section class="history-section py-2 mb-4 bg-light">
    <div class="m-2">
        <h2 class="text-center mb-4">Riwayat Penukaran</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Point</th>
                                <th>Status</th>
                                <th>QR Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penukaran as $p): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                    <td><strong><?= $p['nama_produk'] ?></strong></td>
                                    <td><?= number_format($p['point_tukar']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 
                                            ($p['status'] == 'approved' ? 'success' : 'danger') ?>">
                                            <?= ucfirst($p['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($p['status'] == 'approved'): ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="<?= base_url('uploads/qrcodes/' . $p['qr_code']) ?>" 
                                                     width="40" class="img-thumbnail">
                                                <a href="<?= base_url('uploads/qrcodes/' . $p['qr_code']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                            <?php elseif ($p['status'] == 'pending'): ?>
                                                <span class="text-muted"><i class="fas fa-clock me-2"></i>Menunggu persetujuan</span>
                                            <?php elseif ($p['status'] == 'rejected'): ?>
                                                <span class="text-danger"><i class="fas fa-times-circle me-2"></i>Persetujuan ditolak</span>
                                            <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($p['status'] == 'approved'): '-' ?>
                                            <button class="btn btn-sm btn-info" onclick="showQRDetails('<?= $p['qr_code'] ?>')">
                                                <i class="fas fa-qrcode me-1"></i> Detail
                                            </button>
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
</section>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-qrcode me-2"></i>QR Code Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrImage" src="" class="img-fluid mb-3">
                <div id="qrInfo" class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Tunjukkan QR Code ini kepada Eco Market untuk menukarkan produk Anda
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showQRDetails(qrCode) {
        const modal = new bootstrap.Modal(document.getElementById('qrModal'));
        document.getElementById('qrImage').src = `<?= base_url('uploads/qrcodes/') ?>/${qrCode}`;
        modal.show();
    }

    function confirmExchange(productName, point, productId) {
        Swal.fire({
            title: 'Konfirmasi Penukaran',
            text: `Anda akan menukar ${point} point dengan ${productName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tukar Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= base_url('tukar-produk/') ?>${productId}`;
            }
        });
    }
</script>

<!-- Add these CSS styles -->
<style>
    .product-card {
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .hero-section {
        background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }

    .badge {
        padding: 0.5em 0.8em;
    }
</style>
<?= $this->endSection(); ?>