<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>

<!-- Hero Section -->
<div class="help-hero py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Pusat Bantuan Eco Market</h1>
                <p class="lead mb-4">Temukan jawaban untuk pertanyaan Anda seputar layanan Eco Market</p>
                <div class="search-box mx-auto">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Cari pertanyaan...">
                        <button class="btn btn-light" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="quick-links py-4 bg-light">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-3 col-6">
           <a href="<?= base_url('tentangKita')?>" class="text-decoration-none">
                <div class="quick-link-card text-center p-3" data-aos="fade-up">
                    <i class="fas fa-recycle mb-2"></i>
                    <h6 class="mb-0">Layanan</h6>
                </div>
           </a>
            </div>
            <div class="col-md-3 col-6">
           <a href="<?= base_url('user/riwayat_point')?>" class="text-decoration-none">
                <div class="quick-link-card text-center p-3" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-coins mb-2"></i>
                    <h6 class="mb-0">Poin</h6>
                </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
           <a href="<?= base_url('jualSampah')?>" class="text-decoration-none">
                <div class="quick-link-card text-center p-3" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-trash mb-2"></i>
                    <h6 class="mb-0">Sampah</h6>
                </div>
           </a>
            </div>
            <div class="col-md-3 col-6">
           <a href="<?= base_url('/user')?>" class="text-decoration-none">
                <div class="quick-link-card text-center p-3" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-leaf mb-2"></i>
                    <h6 class="mb-0">Lingkungan</h6>
                </div>
           </a>
            </div>
        </div>
    </div>
</div>
<!-- FAQ Section -->
<section class="faq-section py-4">
    <div class="container-fuild">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion custom-accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="fas fa-question-circle me-2"></i>
                                Apa Layanan Eco Market?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Eco Market menyediakan layanan pengumpulan dan daur ulang sampah, serta memberikan informasi tentang cara mengelola sampah dengan baik.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                <i class="fas fa-question-circle me-2"></i>
                                Apa yang saya dapatkan?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Dengan bergabung di Eco Market, Anda akan mendapatkan poin untuk setiap sampah yang Anda jual, yang dapat ditukarkan dengan produk menarik.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                <i class="fas fa-question-circle me-2"></i>
                                Sampah apa saja yang bisa dijual?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Anda dapat menjual berbagai jenis sampah seperti plastik, kertas, dan logam. Pastikan sampah dalam kondisi bersih dan terpisah.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                <i class="fas fa-question-circle me-2"></i>
                                Sampah apa saja yang belum bisa diterima?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Sampah yang terkontaminasi, seperti makanan atau bahan kimia berbahaya, tidak dapat diterima. Pastikan untuk memisahkan sampah tersebut.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                <i class="fas fa-question-circle me-2"></i>
                                Apa dampaknya bagi lingkungan?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Dengan mendaur ulang sampah, kita dapat mengurangi limbah yang masuk ke tempat pembuangan akhir dan mengurangi pencemaran lingkungan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                <i class="fas fa-question-circle me-2"></i>
                                Sejauh apa layanan Eco Market saat ini?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Saat ini, Eco Market melayani berbagai daerah dan terus memperluas jangkauannya untuk menjangkau lebih banyak masyarakat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Contact Section -->
<section class="contact-support py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="support-card p-4" data-aos="zoom-in">
                    <h3>Masih Punya Pertanyaan?</h3>
                    <p class="text-muted mb-4">Tim support kami siap membantu Anda 24/7</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= base_url('contact')?>" class="btn btn-primary">
                            <i class="fas fa-comments me-2"></i>Chat dengan Kami
                        </a>
                        <a href="mailto:ecomarket84@gmail.com" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>Email Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .help-hero {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .search-box {
        max-width: 600px;
    }

    .quick-link-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .quick-link-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .quick-link-card i {
        font-size: 24px;
        color: #0d6efd;
    }

    .custom-accordion .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .custom-accordion .accordion-button {
        padding: 1.25rem;
        font-weight: 500;
        background: white;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
        background: #0d6efd;
        color: white;
    }

    .support-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    [data-aos] {
        transition-duration: 800ms;
    }
</style>

<script>
AOS.init({
    duration: 800,
    once: true
});

const searchInput = document.querySelector('.search-box input');
searchInput.addEventListener('keyup', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const accordionItems = document.querySelectorAll('.accordion-item');
    
    accordionItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        if(text.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

<?= $this->endSection(); ?>