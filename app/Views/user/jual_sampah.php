<?= $this->extend('template/index'); ?>
<?= $this->section('page-content'); ?>
<!-- Hero Section -->
<div class="hero-section py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="text-primary font-weight-bold mb-2">Bersama ciptakan lingkungan bersih!</h3>
                <p class="text-muted medium mb-0">Kumpulkan sampah sebanyak mungkin dan tukarkan dengan produk unggulan UMKM lokal</p>
            </div>
            <div class="col-md-4 d-none d-sm-block align-items-end">
                <img style="width: 150px;" src="<?= base_url();?>/Assets/img/daur ulang.svg" alt="Ilustrasi daur ulang">
            </div>
        </div>
    </div>
</div>


<div class="container-fluid mb-5 py-4">
    <!-- Stats Cards -->
    <div class="row mb-4">
    <!-- Card 1 - Total Transaksi -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                <div class="h5 mb-0 fw-bold text-gray-800"><?= number_format($stats['total_transaksi']) ?></div>
            </div>
        </div>
    </div>
    
    <!-- Card 2 - Total Berat -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Berat (kg)</div>
                <div class="h5 mb-0 fw-bold text-gray-800"><?= number_format($stats['total_berat']) ?></div>
            </div>
        </div>
    </div>
    
    <!-- Card 3 - Total Point -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Point</div>
                <div class="h5 mb-0 fw-bold text-gray-800"><?= number_format($stats['total_point']) ?></div>
            </div>
        </div>
    </div>
    
    <!-- Card 4 - Pending -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Pending</div>
                <div class="h5 mb-0 fw-bold text-gray-800"><?= $stats['pending_count'] ?></div>
            </div>
        </div>
    </div>
</div>
    <!-- tabel riwayat sampah -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tabel Riwayat Transaksi Sampah</h5>
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modalJualSampah">
                <i class="fas fa-plus"></i> Jual Sampah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Kategori Sampah</th>
                                    <th>Berat Sampah</th>
                                    <th>Point</th>
                                    <th>Status</th>
                                    <th>Foto Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi as $t) : ?>
                                    <tr>
                                    <td>
                                        <?php 
                                        echo date('d/m/Y H:i:s', strtotime($t['created_at']));
                                        ?>
                                    </td>
                                        <td><?= $t['nama_kategori'] ?></td>
                                        <td><?= number_format($t['berat_sampah'],) ?> kg</td>
                                        <td><?= number_format($t['point_sampah_dijual']) ?></td>
                                        <td>
                                            <?php
                                            $badges = [
                                                'pending' => ['class' => 'bg-warning text-dark', 'text' => 'Menunggu'],
                                                'approved' => ['class' => 'bg-success text-white', 'text' => 'Diterima'],
                                                'rejected' => ['class' => 'bg-danger text-white', 'text' => 'Ditolak']
                                            ];
                                            $status = $t['status'];
                                            $currentStatus = $badges[$status] ?? ['class' => 'bg-secondary', 'text' => $status];
                                            ?>
                                            <span class="badge <?= $currentStatus['class'] ?>">
                                                <?= $currentStatus['text'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('uploads/bukti/' . $t['bukti_foto']) ?>" 
                                               class="btn btn-sm btn-info" target="_blank">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Jual Sampah -->
<div class="modal fade" id="modalJualSampah" tabindex="-1" aria-labelledby="modalJualSampahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold" id="modalJualSampahLabel">Form Jual Sampah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('transaksi/store') ?>" method="POST" enctype="multipart/form-data" id="formJualSampah">
                    <input type="hidden" name="id" value="<?= user()->id; ?>">
                    <input type="hidden" name="username" value="<?= user()->username; ?>">

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Sampah</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori Sampah</option>
                            <?php foreach ($kategoris as $item): ?>
                                <option value="<?= $item['kategori_id'] ?>">
                                    <?= $item['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Berat Sampah -->
                    <div class="mb-3">
                        <label for="berat_sampah" class="form-label">Berat Sampah (kg)</label>
                        <input type="number" class="form-control" id="berat_sampah" name="berat_sampah" required step="0.01">
                    </div>
                    
                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>

                    <!-- Foto Bukti -->
                    <div class="mb-3">
                        <label class="form-label">Foto Bukti</label>
                        <input type="file" name="bukti_foto" class="form-control" required accept="image/jpeg,image/png">
                        <small class="text-muted">Maksimal 2MB, format: JPG, PNG</small>
                    </div>

                    <!-- Info Harga dan Point -->
                    <div class="mb-3">
                        <label for="harga_per_kg" class="form-label">Harga per KG</label>
                        <input type="text" class="form-control" id="harga_per_kg" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="point_sampah_dijual" class="form-label">Point yang akan didapat</label>
                        <input type="text" class="form-control" id="point_sampah_dijual" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button data-requires-connection type="submit" form="formJualSampah" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('kategori').addEventListener('change', function() {
        const kategori_id = this.value;
        if (kategori_id) {
            fetch(`<?= base_url('transaksi/getHarga') ?>/${kategori_id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById('harga_per_kg').value = data.harga;
                        calculatePoints();
                    }
                });
        }
    });

    document.getElementById('berat_sampah').addEventListener('input', calculatePoints);

    function calculatePoints() {
        const berat = document.getElementById('berat_sampah').value;
        const harga = document.getElementById('harga_per_kg').value;
        if (berat && harga) {
            const points = Math.floor(berat * harga / 100);
            document.getElementById('point_sampah_dijual').value = points;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formJualSampah');
        if(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const kategori = document.getElementById('kategori').value;
                const berat = document.getElementById('berat_sampah').value;
                const lokasi = document.getElementById('lokasi').value;
                const foto = document.querySelector('input[name="bukti_foto"]').files[0];

                if (!kategori) {
                    Swal.fire('Error', 'Pilih kategori sampah', 'error');
                    return false;
                }
                if (!berat || berat <= 0) {
                    Swal.fire('Error', 'Berat sampah harus lebih dari 0', 'error');
                    return false;
                }
                if (!lokasi || lokasi.length < 5) {
                    Swal.fire('Error', 'Lokasi minimal 5 karakter', 'error');
                    return false;
                }
                if (!foto) {
                    Swal.fire('Error', 'Pilih foto bukti', 'error');
                    return false;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Pastikan data yang diinput sudah benar",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }

        <?php if (session()->getFlashdata('message')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('message') ?>',
                showConfirmButton: true,
                timer: 3000
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: false,
                timer: 3000
            });
        <?php endif; ?>

        <?php if (session('errors')) : ?>
            <?php 
            $errorMessages = [];
            foreach (session('errors') as $error) {
                $errorMessages[] = $error;
            }
            ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: '<?= implode("<br>", $errorMessages) ?>',
                showConfirmButton: false,
                timer: 3000
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection(); ?>