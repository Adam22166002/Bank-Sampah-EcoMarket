<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-4">
<h1 class="h5 ml-3 mt-3 mb-4 text-gray-800"><i class="fas fa-box-alt"></i> Dashboard Produk Transaksi</h1>
    <?php if(session('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
<div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-check"></i> Verifikasi Produk Seller Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Seller</th>
                            <th>Nama Produk</th>
                            <th>Harga (Point)</th>
                            <th>Stok</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produk as $p): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            <td><?= $p['username'] ?></td>
                            <td><?= $p['nama_produk'] ?></td>
                            <td><?= number_format($p['harga_produk']) ?></td>
                            <td><?= $p['stok'] ?></td>
                            <td>
                                <img src="<?= base_url('uploads/fotoProduk/' . $p['foto_produk']) ?>" 
                                     width="50" class="img-thumbnail">
                            </td>
                            <td>
                                <?php 
                                $badges = [
                                    'pending' => ['bg-warning', 'Menunggu Verifikasi'],
                                    'active' => ['bg-success', 'Disetujui'],
                                    'inactive' => ['bg-danger', 'Ditolak']
                                ];
                                
                                [$class, $text] = $badges[$p['status']] ?? ['bg-secondary', 'Unknown'];
                                ?>
                                <span class="badge <?= $class ?>"><?= $text ?></span>
                                
                                <?php if($p['status'] !== 'pending' && isset($p['tanggal_verifikasi'])): ?>
                                    <br>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($p['tanggal_verifikasi'])) ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                            <?php if($p['status'] == 'pending'): ?>
                                <form action="<?= base_url('admin/produk/verifikasi/' . $p['produk_id']) ?>" 
                                    method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form action="<?= base_url('admin/produk/verifikasi/' . $p['produk_id']) ?>" 
                                    method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-<?= $p['status'] == 'active' ? 'success' : 'danger' ?>">
                                    <?= $p['status'] == 'active' ? 'Telah disetujui' : 'Telah ditolak' ?>
                                </span>
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

<!-- Tabel Verifikasi Penukaran Produk Nasabah -->
<div class="container-fluid py-4">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Verifikasi Penukaran Produk Nasabah</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nasabah</th>
                        <th>Nama Produk</th>
                        <th>Point Ditukar</th>
                        <th>Barcode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($penukaran as $pn): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($pn['created_at'])) ?></td>
                        <td><?= $pn['username'] ?></td>
                        <td><?= $pn['nama_produk'] ?></td>
                        <td><?= number_format($pn['point_tukar']) ?></td>
                        <td>
                            <?php if($pn['status'] == 'approved'): ?>
                                <img src="<?= base_url('uploads/qrcodes/' . $pn['qr_code']) ?>" 
                                    width="50" class="img-thumbnail" 
                                    style="cursor: pointer;"
                                    onclick="showQRModal('<?= $pn['qr_code'] ?>', '<?= $pn['nama_produk'] ?>', '<?= $pn['username'] ?>')">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $badges = [
                                'pending' => ['bg-warning', 'Menunggu Verifikasi'],
                                'approved' => ['bg-success', 'Disetujui'],
                                'rejected' => ['bg-danger', 'Ditolak']
                            ];
                            
                            [$class, $text] = $badges[$pn['status']] ?? ['bg-secondary', 'Unknown'];
                            ?>
                            <span class="badge <?= $class ?>"><?= $text ?></span>
                            
                            <?php if($pn['status'] !== 'pending' && isset($pn['tanggal_verifikasi'])): ?>
                                <br>
                                <small class="text-muted">
                                    <?= date('d/m/Y H:i', strtotime($pn['tanggal_verifikasi'])) ?>
                                </small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($pn['status'] == 'pending'): ?>
                                <button class="btn btn-success btn-sm" onclick="showApprovalModal(<?= $pn['penukaran_id'] ?>)">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="showRejectModal(<?= $pn['penukaran_id'] ?>)">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            <?php else: ?>
                                <small class="text-muted">
                                    <?= $pn['status'] == 'approved' ? 'Telah disetujui' : 'Telah ditolak' ?>
                                </small>
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

<!-- Modal Verifikasi Penukaran -->
<div class="modal fade" id="verifikasiPenukaranModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVerifikasiPenukaran" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitlePenukaran">Verifikasi Penukaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" id="statusVerifikasiPenukaran">
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal Qr Code -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrImage" src="" class="img-fluid mb-3" style="max-width: 300px;">
                <div id="qrInfo" class="mb-3">
                    <p class="mb-1">Produk: <span id="qrProduk"></span></p>
                    <p class="mb-1">Nasabah: <span id="qrNasabah"></span></p>
                </div>
                <a id="downloadQR" href="" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Download QR Code
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showApprovalModal(id) {
    document.getElementById('formVerifikasiPenukaran').action = 
        `<?= base_url('admin/verifikasi-penukaran/') ?>${id}`;
    document.getElementById('statusVerifikasiPenukaran').value = 'approved';
    document.getElementById('modalTitlePenukaran').textContent = 'Approve Penukaran';
    new bootstrap.Modal(document.getElementById('verifikasiPenukaranModal')).show();
}

function showRejectModal(id) {
    document.getElementById('formVerifikasiPenukaran').action = 
        `<?= base_url('admin/verifikasi-penukaran/') ?>${id}`;
    document.getElementById('statusVerifikasiPenukaran').value = 'rejected';
    document.getElementById('modalTitlePenukaran').textContent = 'Reject Penukaran';
    new bootstrap.Modal(document.getElementById('verifikasiPenukaranModal')).show();
}
function showQRModal(qrCode, produk, nasabah) {
    const qrUrl = `<?= base_url('uploads/qrcodes/') ?>${qrCode}`;
    document.getElementById('qrImage').src = qrUrl;

    document.getElementById('qrProduk').textContent = produk;
    document.getElementById('qrNasabah').textContent = nasabah;

    document.getElementById('downloadQR').href = qrUrl;

    new bootstrap.Modal(document.getElementById('qrModal')).show();
}
</script>
<?= $this->endSection(); ?>