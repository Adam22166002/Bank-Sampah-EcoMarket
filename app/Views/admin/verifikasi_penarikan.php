<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-4">
    <?php if(session('message')): ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-check"></i> Verifikasi Penarikan E-Wallet</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Point/Saldo</th>
                            <th>No. DANA</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penarikan as $p): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            <td><?= $p['username'] ?></td>
                            <td><?= ucfirst($p['role']) ?></td>
                            <td>
                                <?php if($p['role'] === 'nasabah'): ?>
                                    Rp<?= number_format($p['jumlah_point']*100, 0, ',', '.') ?>
                                <?php else: ?>
                                    Rp <?= number_format($p['jumlah_rupiah'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $p['no_ewallet'] ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 
                                    ($p['status'] == 'approved' ? 'success' : 'danger') ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($p['status'] == 'pending'): ?>
                                    <button class="btn btn-success btn-sm" onclick="showApprovalModal(<?= $p['penarikan_id'] ?>)">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="showRejectModal(<?= $p['penarikan_id'] ?>)">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                <?php else: ?>
                                    <small class="text-muted">
                                        Diverifikasi pada: <?= date('d/m/Y H:i', strtotime($p['tanggal_verifikasi'])) ?>
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

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVerifikasi" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Verifikasi Penarikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" id="statusVerifikasi">
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

<script>
function showApprovalModal(id) {
    document.getElementById('formVerifikasi').action = `<?= base_url('admin/verifikasi-penarikan/') ?>${id}`;
    document.getElementById('statusVerifikasi').value = 'approved';
    document.getElementById('modalTitle').textContent = 'Approve Penarikan';
    new bootstrap.Modal(document.getElementById('verifikasiModal')).show();
}

function showRejectModal(id) {
    document.getElementById('formVerifikasi').action = `<?= base_url('admin/verifikasi-penarikan/') ?>${id}`;
    document.getElementById('statusVerifikasi').value = 'rejected';
    document.getElementById('modalTitle').textContent = 'Reject Penarikan';
    new bootstrap.Modal(document.getElementById('verifikasiModal')).show();
}
</script>
<?= $this->endSection(); ?>