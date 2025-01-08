<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section bg-light py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-5 fw-bold text-primary mb-3">Eco Market</h1>
                    <p class="lead mb-4">Bersama Menciptakan Indonesia yang Lebih Hijau dan Berkelanjutan</p>
                    <div class="d-flex gap-3">
                        <a href="#learn-more" class="btn btn-primary">Pelajari Lebih Lanjut</a>
                        <a href="/register" class="btn btn-outline-primary">Bergabung Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6 align-items-center" data-aos="fade-left">
                    <img src="<?= base_url();?>Assets/img/hero.png" alt="Eco Market Hero" class="items-center" style="width: 300px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Key Features -->
    <section class="features py-5">
        <div class="container">
            <h2 class="text-center mb-5">Mengapa Memilih Eco Market?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 bg-light">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-recycle fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Sistem Daur Ulang Digital</h3>
                            <p class="text-muted">Platform digital yang memudahkan Anda mengelola sampah dengan sistem poin yang menguntungkan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 bg-light">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-store fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Pemberdayaan UMKM</h3>
                            <p class="text-muted">Mendukung UMKM lokal dalam menghasilkan produk berkualitas dari bahan daur ulang.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 bg-light">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-leaf fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Dampak Lingkungan</h3>
                            <p class="text-muted">Berkontribusi dalam menciptakan lingkungan yang lebih bersih dan berkelanjutan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Bagaimana Cara Kerjanya?</h2>
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up">
                    <div class="text-center">
                        <div class="step-number mb-3">
                            <span class="badge bg-primary rounded-circle p-3">1</span>
                        </div>
                        <h4 class="h6">Kumpulkan Sampah</h4>
                        <p class="small text-muted">Kumpulkan sampah dari lingkungan sekitarmu. Pilah sesuai jenisnya untuk memudahkan proses daur ulang.</p>
                    </div>
                </div>
                <div class="col-md-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="step-number mb-3">
                            <span class="badge bg-primary rounded-circle p-3">2</span>
                        </div>
                        <h4 class="h6">Setor ke Bank Sampah</h4>
                        <p class="small text-muted">Kunjungi dan Tukarkan sampahmu di lokasi Bank Sampah Eco Market terdekat</p>
                    </div>
                </div>
                <div class="col-md-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="step-number mb-3">
                            <span class="badge bg-primary rounded-circle p-3">3</span>
                        </div>
                        <h4 class="h6">Dapatkan Poin</h4>
                        <p class="small text-muted">Jika Setor Sampah disetujui, Poin untuk setiap sampah yang kamu tukar akan masuk ke akun Anda</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="step-number mb-3">
                            <span class="badge bg-primary rounded-circle p-3">4</span>
                        </div>
                        <h4 class="h6">Tukar Poin</h4>
                        <p class="small text-muted">Kumpulkan Poin anda sebanyak-banyaknya, dan Tukar Point anda dengan Penarikan Dana atau Penukaran Produk menarik kami</p>
                    </div>
                </div>
                <div class="col-md-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="step-number mb-3">
                            <span class="badge bg-primary rounded-circle p-3">4</span>
                        </div>
                        <h4 class="h6">Ambil Produk</h4>
                        <p class="small text-muted">Ambil Produk anda di lokasi Bank Sampah Eco Market terdekat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Statistics -->
    <section class="impact py-5">
        <div class="container">
            <h2 class="text-center mb-5">Dampak Bersama</h2>
            <div class="row g-4 text-center">
                <div class="col-md-3" data-aos="fade-up">
                    <h3 class="display-4 fw-bold text-primary">5K+</h3>
                    <p>Pengguna Aktif</p>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="display-4 fw-bold text-primary">10T</h3>
                    <p>Sampah Terkelola</p>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="display-4 fw-bold text-primary">50+</h3>
                    <p>UMKM Mitra</p>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="display-4 fw-bold text-primary">100+</h3>
                    <p>Bank Sampah</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .badge.rounded-circle {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    [data-aos] {
        transition-duration: 800ms;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
// Initialize AOS
AOS.init({
    duration: 800,
    once: true
});
</script>
<?= $this->endSection(); ?>