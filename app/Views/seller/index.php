<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <?php if(session('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <h5 class="mt-4 ml-2 mb-4 text-gray-800"><i class="fa fa-home"></i>  Dashboard Seller</h5>

    <!-- Stats Cards -->
<div class="row mb-4">
    <!-- Card 1 - Saldo Pendapatan -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start mb-3">
                    <div class="text-center text-md-start mb-2 mb-md-0">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                    <div class="text-center text-md-start ms-md-2 flex-grow-1">
                        <div class="text-xs fw-bold text-primary text-uppercase">Saldo Pendapatan</div>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start mt-2">
                            <span class="h5 mb-0 fw-bold text-gray-800"><?= user()->total_point ?> Point</span>
                            <a class="ml-3 ms-2 text-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-arrow-right text-primary animate__animated animate__panah"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 - Total Stock -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start mb-3">
                    <div class="text-center text-md-start mb-2 mb-md-0">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                    <div class="text-center text-md-start ms-md-2 flex-grow-1">
                        <div class="text-xs fw-bold text-success text-uppercase">Total Stock</div>
                        <div class="h5 mb-0 fw-bold text-gray-800 mt-2"><?= $stats['total_stok'] ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 - Total Terjual -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start mb-3">
                    <div class="text-center text-md-start mb-2 mb-md-0">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                    <div class="text-center text-md-start ms-md-2 flex-grow-1">
                        <div class="text-xs fw-bold text-info text-uppercase">Total Terjual</div>
                        <div class="h5 mb-0 fw-bold text-gray-800 mt-2"><?= $stats['total_terjual'] ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 - Total Produk -->
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start mb-3">
                    <div class="text-center text-md-start mb-2 mb-md-0">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                    <div class="text-center text-md-start ms-md-2 flex-grow-1">
                        <div class="text-xs fw-bold text-warning text-uppercase">Total Produk</div>
                        <div class="h5 mb-0 fw-bold text-gray-800 mt-2"><?= $stats['total_produk'] ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List -->
    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Daftar Produk</h5>
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createModal" data-bs-whatever="@fat"><i class="fas fa-plus"></i> Add Produk</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga(Point)</th>
                            <th>Stok</th>
                            <th>Terjual</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $product['nama_produk'] ?></td>
                            <td><?= number_format($product['harga_produk'], 0, ',', '.') ?></td>
                            <td><?= $product['stok'] ?></td>
                            <td><?= $product['terjual'] ?></td>
                            <td>
                                <?php 
                                $badgeClass = '';
                                $statusText = '';
                                
                                switch($product['status']) {
                                    case 'pending':
                                        $badgeClass = 'bg-warning';
                                        $statusText = 'Menunggu Verifikasi';
                                        break;
                                    case 'active':
                                        $badgeClass = 'bg-success';
                                        $statusText = 'Disetujui';
                                        break;
                                    case 'inactive':
                                        $badgeClass = 'bg-danger';
                                        $statusText = 'Ditolak';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $statusText ?>
                                </span>
                                <?php if($product['status'] !== 'pending' && isset($product['tanggal_verifikasi'])): ?>
                                    <br>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($product['tanggal_verifikasi'])) ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <img src="<?= base_url('uploads/fotoProduk/' . $product['foto_produk']) ?>" 
                                     alt="<?= $product['nama_produk'] ?>" 
                                     width="50">
                            </td>
                            <td>
                                <?php if($product['status'] == 'pending'): ?>
                                    <a href="<?= base_url('seller/produk/edit/' . $product['produk_id']) ?>" 
                                    class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <a href="#" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="confirmDelete('<?= base_url('seller/produk/delete/' . $product['produk_id']) ?>')">
                                    <i class="fas fa-trash"></i> Delete
                                    </a>
                                <?php else: ?>
                                    <span class="badge <?= $product['status'] == 'active' ? 'bg-success' : ($product['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                        <?= ($product['status'] == 'active') ? 'Active' : 
                                            ($product['status'] == 'pending' ? 'Menunggu verifikasi' : 'Produk ditolak') ?>
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

<?php 
$valid_points = [250, 500, 1000];
?>
<!-- Modal Form Penarikan -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="penarikanModalLabel">
          <i class="bi bi-wallet2 me-2"></i>
          <?= ($role === 'seller') ? 'Form Pencairan Saldo' : 'Form Pencairan Point' ?> ke DANA
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
        $formAction = ($role === 'seller') ? 
            base_url('seller/ewallet/store') : 
            base_url('nasabah/ewallet/store');
        ?>
        <form action="<?= $formAction ?>" method="POST">
          <?= csrf_field() ?>

          <div class="alert alert-info">
            <i class="fas fa-info me-2"></i>
            Point tersedia: <?= number_format(user()->total_point) ?> point
            <br>
            <small class="m-2">1 Point = Rp 100</small>
          </div>

          <div class="mb-4">
            <label for="jumlah_point" class="form-label fw-semibold">
              <i class="bi bi-currency-exchange me-1 text-primary"></i> Pilih Jumlah Point
            </label>
            <select name="jumlah_point" id="jumlah_point" class="form-select" >
              <option value="">-- Pilih Jumlah Point --</option>
              <?php foreach($valid_points as $point): ?>
                <option value="<?= $point ?>" <?= user()->total_point < $point ? 'disabled' : '' ?>>
                  <?= number_format($point) ?> Point (Rp <?= number_format($point * 100) ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <small class="text-muted">Pilih jumlah point yang ingin ditarik</small>
          </div>

          <div class="mb-4">
            <label for="no_ewallet" class="form-label fw-semibold">
              <i class="bi bi-phone me-1 text-primary"></i> Nomor DANA
            </label>
            <input type="text" name="no_ewallet" class="form-control" 
                   pattern="08[0-9]{9,11}" title="Nomor DANA harus diawali 08 dan memiliki 11-13 digit"
                   placeholder="08xxxxxxxxxx">
            <small class="text-muted">Masukkan nomor DANA yang terdaftar</small>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
            <button type="submit" class="btn btn-primary" <?= user()->total_point < min($valid_points) ? 'disabled' : '' ?>>
              <i class="bi bi-send-fill me-1"></i> Submit Pencairan
            </button>
          </div>
          </div>
        </form>
      </div>
    </div>
</div>

<!-- Modal Create Produk-->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary" id="createModalLabel">Form Tambah Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (session('errors')) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?php foreach (session('errors') as $error) : ?>
                                                <?= $error ?><br>
                                            <?php endforeach ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif ?>

                                    <form action="<?= base_url('seller/produk/store') ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        
                                        <input type="hidden" name="user_id" value="<?= user()->id ?>">
                                        
                                        <div class="mb-3">
                                            <label for="nama_produk" class="form-label">Nama Produk</label>
                                            <input type="text" 
                                                class="form-control <?= session('errors.nama_produk') ? 'is-invalid' : '' ?>" 
                                                id="nama_produk" 
                                                name="nama_produk" 
                                                value="<?= old('nama_produk') ?>" 
                                                required>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nama_produk') ?>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Spesifikasi Produk</label>
                                            <textarea class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" 
                                                    id="deskripsi" 
                                                    name="deskripsi" 
                                                    rows="3" 
                                                    required><?= old('deskripsi') ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= session('errors.deskripsi') ?>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="harga_produk" class="form-label">Harga Produk</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Point</span>
                                                <input type="number" 
                                                    class="form-control <?= session('errors.harga_produk') ? 'is-invalid' : '' ?>" 
                                                    id="harga_produk" 
                                                    name="harga_produk" 
                                                    value="<?= old('harga_produk') ?>" 
                                                    required>
                                                    
                                                <div class="invalid-feedback">
                                                    <?= session('errors.harga_produk') ?>
                                                </div>
                                            </div>
                                            <small class="text-muted">1 Point = Rp 100</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok</label>
                                            <input type="number" 
                                                class="form-control <?= session('errors.stok') ? 'is-invalid' : '' ?>" 
                                                id="stok" 
                                                name="stok" 
                                                value="<?= old('stok') ?>" 
                                                required>
                                            <div class="invalid-feedback">
                                                <?= session('errors.stok') ?>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="foto_produk" class="form-label">Foto Produk</label>
                                            <input type="file" 
                                                class="form-control <?= session('errors.foto_produk') ? 'is-invalid' : '' ?>" 
                                                id="foto_produk" 
                                                name="foto_produk"
                                                accept="image/*"
                                                onchange="previewImg()"
                                                required>
                                            <div class="invalid-feedback">
                                                <?= session('errors.foto_produk') ?>
                                            </div>
                                            <div class="mt-1">
                                                <img src="/img/default.jpg" class="img-thumbnail img-preview" width="100">
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Produk</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formPencairan = document.querySelector('form[action*="ewallet/store"]');
    if(formPencairan) {
        formPencairan.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedPoint = document.getElementById('jumlah_point').value;
            const noEwallet = document.querySelector('input[name="no_ewallet"]').value;

            if(!selectedPoint) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Silakan pilih jumlah point yang ingin ditarik'
                });
                return false;
            }

            if(!noEwallet || !noEwallet.match(/^08[0-9]{9,11}$/)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Nomor DANA tidak valid! Harus diawali 08 dan memiliki 11-13 digit'
                });
                return false;
            }

            Swal.fire({
                title: 'Konfirmasi Pencairan',
                html: `
                    <div class="text-start">
                        <p>Detail pencairan:</p>
                        <ul>
                            <li>Jumlah Point: ${selectedPoint} point</li>
                            <li>Jumlah Rupiah: Rp ${new Intl.NumberFormat('id-ID').format(selectedPoint * 100)}</li>
                            <li>Nomor DANA: ${noEwallet}</li>
                        </ul>
                        <p>Pastikan nomor DANA sudah benar!</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Cairkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }
    <?php if (session()->getFlashdata('message')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('message') ?>',
            timer: 3000,
            showConfirmButton: true
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?= session()->getFlashdata('error') ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>

    <?php if (session('errors')) : ?>
        <?php 
        $errorMessages = [];
        foreach (session('errors') as $error) {
            $errorMessages[] = $error;
        }
        $errorMessage = implode("<br>", $errorMessages);
        ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: '<?= $errorMessage ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
});

function confirmDelete(deleteUrl) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Produk yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Buat form untuk delete method
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '<?= csrf_token() ?>';
            csrfToken.value = '<?= csrf_hash() ?>';
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?= $this->endSection(); ?>