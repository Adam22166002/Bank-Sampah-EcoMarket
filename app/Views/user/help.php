<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<!-- Hero Section -->
<div class="about-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 z-index-0 mb-3" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4 text-primary">Eco Market</h1>
                <p class="lead mb-4">Menjembatani masyarakat dengan ekonomi sirkular melalui pengelolaan sampah yang berkelanjutan.</p>
                <div class="d-flex gap-3">
                    <a href="#mission" class="btn btn-primary">Pelajari Lebih Lanjut</a>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#contactModal">
                        Hubungi Kami
                    </button>
                </div>
            </div>
            <div class="col-lg-5 z-index-0" data-aos="fade-left">
                <img src="<?= base_url();?>/Assets/img/ilustrasi.svg" style="width: 250px;" alt="Eco Market Profile">
            </div>
        </div>
    </div>
</div>

<!-- Mission Section -->
<section id="mission" class="mission-section py-5">
    <div class="container">
    <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Inovasi Eco Market</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="mission-card text-center p-4">
                    <div class="mission-icon mb-3">
                        <i class="fas fa-recycle text-primary"></i>
                    </div>
                    <h4>Daur Ulang</h4>
                    <p class="text-muted">Mendorong praktik daur ulang untuk mengurangi sampah di lingkungan</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="mission-card text-center p-4">
                    <div class="mission-icon mb-3">
                        <i class="fas fa-hand-holding-heart text-primary"></i>
                    </div>
                    <h4>Pemberdayaan</h4>
                    <p class="text-muted">Memberdayakan masyarakat melalui ekonomi sirkular</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="mission-card text-center p-4">
                    <div class="mission-icon mb-3">
                        <i class="fas fa-leaf text-primary"></i>
                    </div>
                    <h4>Keberlanjutan</h4>
                    <p class="text-muted">Menciptakan lingkungan yang lebih bersih dan berkelanjutan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Waste Types Section -->
<section class="waste-types py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Jenis Sampah Daur Ulang</h2>
                <p class="text-muted">Kenali berbagai jenis sampah yang dapat didaur ulang</p>
            </div>
        </div>
        <div class="row g-4">
            <!-- Plastic  Card -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="waste-card h-100">
                    <div class="waste-icon-wrapper mb-4">
                        <i class="fas fa-wine-bottle waste-icon"></i>
                    </div>
                    <h3 class="h4 mb-3">Sampah Plastik</h3>
                    <p class="text-muted">Sampah plastik sulit terurai dan mengandung zat kimia berbahaya. Dapat didaur ulang menjadi:</p>
                    <ul class="waste-list">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Botol Plastik</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Ember</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Toples Plastik</li>
                    </ul>
                </div>
            </div>

            <!-- Paper Card -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="waste-card h-100">
                    <div class="waste-icon-wrapper mb-4">
                        <i class="fas fa-newspaper waste-icon"></i>
                    </div>
                    <h3 class="h4 mb-3">Sampah Kertas</h3>
                    <p class="text-muted">Terurai dalam 2-5 bulan. Jenis sampah kertas yang dapat didaur ulang:</p>
                    <ul class="waste-list">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Kertas Buku</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Kardus</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Kertas Makanan</li>
                    </ul>
                </div>
            </div>

            <!-- Metal Card -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="waste-card h-100">
                    <div class="waste-icon-wrapper mb-4">
                        <i class="fas fa-cog waste-icon"></i>
                    </div>
                    <h3 class="h4 mb-3">Sampah Logam</h3>
                    <p class="text-muted">Dapat didaur ulang berkali-kali. Jenis logam yang dapat didaur ulang:</p>
                    <ul class="waste-list">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Besi</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Aluminium</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Tembaga & Kuningan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="cta-card text-center p-5" data-aos="zoom-in">
                    <h2 class="mb-4">Bergabung dengan Eco Market!</h2>
                    <p class="lead mb-4">Jual sampahmu dan tukarkan dengan produk kami. Jadikan sampah lebih bermanfaat!</p>
                    <a href="<?= base_url('contact')?>" class="btn btn-primary btn-lg">
                        Hubungi Kami <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
 <!-- Modal -->
 <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title fw-bold" id="contactModalLabel">Hubungi Kami</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-center text-muted">
            Silakan hubungi kami jika Anda tertarik menjadi nasabah 
            <h4 class="text-primary fw-bold text-center">Eco Market</h4>.
          </p>
          <form action="<?= base_url('/contact/save') ?>" method="post" id="contactForm">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control form-control-lg rounded-pill" id="name" name="name" placeholder="Nama.." required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control form-control-lg rounded-pill" id="email" name="email" placeholder="Email.." required>
    </div>
    <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control form-control-lg rounded-pill" id="subject" name="subject" placeholder="Subject.." required>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Pesan</label>
        <textarea id="message" class="form-control form-control-lg" name="message" rows="4" placeholder="Pesan..." required></textarea>
    </div>
    <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary rounded-pill">Kirim Pesan <i class="fa fa-paper-plane"></i></button>
        </div>
</form>
        </div>
      </div>
    </div>
  </div>
  <script>
  function sendWhatsApp() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();

    const adminNumber = '6285640600585'; 

    if (!name || !email || !subject || !message) {
      alert('Harap isi semua field sebelum mengirim pesan.');
      return;
    }
    const whatsappMessage = `
Halo Admin Bank Sampah,
Saya ${name} (${email}) ingin menghubungi Anda mengenai:
*${subject}*

Pesan:
${message}
    `;

    const whatsappURL = `https://wa.me/${adminNumber}?text=${encodeURIComponent(whatsappMessage)}`;

    window.open(whatsappURL, '_blank');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if (session()->getFlashdata('success')) : ?>
    Swal.fire({
      title: 'Berhasil!',
      text: "<?= session()->getFlashdata('success'); ?>",
      icon: 'success',
      confirmButtonText: 'OK Bang'
    });
  <?php elseif (session()->getFlashdata('error')) : ?>
    Swal.fire({
      title: 'Error!',
      text: "<?= session()->getFlashdata('error'); ?>",
      icon: 'error',
      confirmButtonText: 'OK'
    });
  <?php endif; ?>
</script>

<style>
    .about-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .mission-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .mission-card:hover {
        transform: translateY(-5px);
    }

    .mission-icon i {
        font-size: 2.5rem;
    }

    .waste-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .waste-card:hover {
        transform: translateY(-5px);
    }

    .waste-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(13,110,253,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .waste-icon {
        font-size: 1.8rem;
        color: #0d6efd;
    }

    .waste-list {
        list-style: none;
        padding-left: 0;
    }

    .waste-list li {
        margin-bottom: 0.5rem;
    }

    .cta-card {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-radius: 15px;
        color: white;
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
</script>
<?= $this->endSection(); ?>