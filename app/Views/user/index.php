<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<!-- Hero Section -->
<div class="container-fluid py-3 position-relative overflow-hidden bg-light">
        <div class="row align-items-center gy-4">
            <!-- Welcome Text Section -->
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-leaf text-success animate__animated animate__bounce fs-2"></i>
                    <h4 class="display-6 fw-bold mb-0">
                        Selamat Datang,
                        <span class="text-primary"><?= user()->username; ?></span>
                    </h4>
                </div>
                <p class="lead text-muted mb-4">
                    Mari bergabung dalam perjalanan menuju lingkungan yang lebih bersih!
                </p>
            </div>

            <!-- Points Card Section -->
            <div class="col-lg-4">
                <div class="card border-0 bg-primary rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-circle bg-primary-subtle">
                                <i class="fas fa-coins text-primary fs-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="text-white text-uppercase text-xs fw-bold tracking-wide">
                                    Point Eco Market
                                </h4>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fs-4 fw-bold text-white">
                                        <?= number_format(user()->total_point) ?> Point
                                    </div>
                                    <a type="button" role="button" class="p-3 focus:border-none animate__animated animate__panah" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#exampleModal">
                                        <i class="fas fa-arrow-right text-white"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Main Features Section -->
<div class="container py-4" id="main">
    <div class="row mb-3">
        <div class="col-xl-4 col-md-4 mb-4">
        <a href="<?= base_url('jualSampah');?>" class="text-decoration-none">
            <div class="card border-left-primary shadow hover-shadow transition-all h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Jual Sampah</div>
                            <div class="h6 mb-0 text-gray-800">Tukarkan sampahmu menjadi poin dan dapatkan keuntungan lebih!</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trash fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
        <a href="<?= base_url('tukarProduk');?>" class="text-decoration-none">
            <div class="card border-left-success shadow hover-shadow transition-all h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-success text-uppercase mb-1">Tukar Produk</div>
                            <div  class="h6 text-gray-800">Tukarkan poinmu dengan berbagai produk menarik!</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
        <a href="<?= base_url('tentangKita');?>" class="text-decoration-none">
            <div class="card border-left-info shadow hover-shadow transition-all h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-info text-uppercase mb-1">Tentang Eco Market</div>
                            <div  class="h6 text-gray-800">Pelajari lebih lanjut tentang misi dan visi kami!</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>
</div>

<!--Cara kerja Section -->
<div class="container-fluid bg-light py-2">
    <h3 class="text-center mb-5 fw-bold text-primary">CARA KERJA ECO MARKET</h3>
    <div class="row g-4" data-aos="fade-up">
        <div class="col-lg-4 col-md-6">
            <div class="text-center p-2 mb-3 rounded-3 bg-light">
                <div class="mb-4">
                    <img src="<?= base_url();?>/Assets/img/kumpul.svg" class="img-fluid" alt="Kumpul" style="width: 100px;">
                </div>
                <h4 class="fw-bold mb-3 text-primary">Jual Sampah</h4>
                <p class="text-muted">Mulailah dengan mengumpulkan sampah dari lingkungan sekitar Anda. Pisahkan jenis sampah (Plastik, Kertas, dan Logam), dan pastikan untuk mengumpulkan sampah yang dapat diberikan kembali kepada kami di Bank Sampah Eco Market.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="text-center p-2 mb-3 rounded-3 bg-light">
                <div class="mb-4">
                    <img src="<?= base_url();?>/Assets/img/tukar.svg" class="img-fluid" alt="Tukar" style="width: 100px;">
                </div>
                <h4 class="fw-bold mb-3 text-primary">Tukar Produk</h4>
                <p class="text-muted">Setelah sampah Anda disetujui oleh kami, Anda akan mendapatkan poin. Gunakan poin tersebut untuk menukarkan produk atau menarik pencairan dana melalui platform kami.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mx-auto">
            <div class="text-center p-2 mb-3 rounded-3 bg-light">
                <div class="mb-4">
                    <img src="<?= base_url();?>/Assets/img/logo_tentang.svg" class="img-fluid" alt="Ambil" style="width: 90px;">
                </div>
                <h4 class="fw-bold mb-3 text-primary">Tentang Kami</h4>
                <p class="text-muted">Eco Market adalah platform yang memungkinkan Anda untuk menukarkan sampah menjadi produk atau dana. Kami berkomitmen untuk mengurangi sampah dengan mendaur ulang dan memberikan insentif kepada pengguna kami melalui sistem poin.</p>
            </div>
        </div>
    </div>
</div>
<!-- step section -->
<section class="how-it-works py-5 bg-light">
    <div class="container">
        <h2 class="text-center text-primary mb-5">Bagaimana Cara Kerjanya?</h2>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6" data-aos="fade-up">
                <div class="text-center">
                    <div class="step-number mb-3">
                        <span class="badge bg-primary rounded-circle p-3"><div class="h6 text-white mb-0">1</div></span>
                    </div>
                    <h4 class="h6">Kumpulkan Sampah</h4>
                    <p class="small text-muted">Kumpulkan sampah dari lingkungan sekitarmu. Pilah sesuai jenisnya untuk memudahkan proses daur ulang.</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="step-number mb-3">
                        <span class="badge bg-primary rounded-circle p-3"><div class="h6 text-white mb-0">2</div></span>
                    </div>
                    <h4 class="h6">Setor ke Bank Sampah</h4>
                    <p class="small text-muted">Kunjungi dan Tukarkan sampahmu di lokasi Bank Sampah Eco Market terdekat. Lokasi ini dapat ditemukan di berbagai area.</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="step-number mb-3">
                        <span class="badge bg-primary rounded-circle p-3"><div class="h6 text-white mb-0">3</div></span>
                    </div>
                    <h4 class="h6">Dapatkan Poin</h4>
                    <p class="small text-muted">Jika Setor Sampah disetujui, Poin untuk setiap sampah yang kamu tukar akan masuk ke akun Anda. Poin tersebut dapat digunakan untuk berbagai penukaran produk atau penarikan dana.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="step-number mb-3">
                        <span class="badge bg-primary rounded-circle p-3"><div class="h6 text-white mb-0">4</div></span>
                    </div>
                    <h4 class="h6">Tukar Poin</h4>
                    <p class="small text-muted">Kumpulkan Poin anda sebanyak-banyaknya, dan Tukar Poin anda dengan Penarikan Dana atau Penukaran Produk menarik kami. Kami menawarkan berbagai pilihan produk yang bisa Anda pilih.</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="step-number mb-3">
                        <span class="badge bg-primary rounded-circle p-3"><div class="h6 text-white mb-0">5</div></span>
                    </div>
                    <h4 class="h6">Ambil Produk</h4>
                    <p class="small text-muted">Ambil Produk anda di lokasi Bank Sampah Eco Market terdekat. Pastikan untuk membawa bukti penukaran untuk memperoleh produk yang Anda pilih.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$valid_points = [250, 500, 1000];
?>
<!-- Modal Form Penarikan -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">
          <i class="bi bi-wallet2 me-2"></i> Form Pencairan Point
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('user/ewallet/store'); ?>" method="POST" id="formPencairan">
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
            <select name="jumlah_point" id="jumlah_point" class="form-select">
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
        </form>
      </div>
    </div>
  </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form pencairan point
    const formPencairan = document.querySelector('form[action*="ewallet/store"]');
    if(formPencairan) {
        formPencairan.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedPoint = document.getElementById('jumlah_point').value;
            const noEwallet = document.querySelector('input[name="no_ewallet"]').value;

            // Validasi input
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

            // Konfirmasi pencairan
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

    // Handle flash messages
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
</script>

<!-- Add custom styles -->
<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.transition-all {
    transition: all .3s ease-in-out;
}
</style>

<?= $this->endSection(); ?>