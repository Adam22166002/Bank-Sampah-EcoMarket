<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-5">
    <div class="container text-center">
        <h1 class="display-4 text-primary font-weight-bold">Eco Market Selalu Memberikan Bantuan!</h1>
        <p class="lead">Kami siap membantu Anda dalam mengelola sampah dan mendukung lingkungan yang lebih bersih.</p>
    </div>
</div>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-3 col-6 text-center mb-4" data-aos="fade-up">
          <div class="icon btn btn-primary d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
            <i class="fa fa-map-marker"></i>
          </div>
          <p class="mt-3">
            <span class="fw-bold">Alamat :</span><br> Jl. Ki Gede Sebayu No. 12 Tegal
          </p>
        </div>
        <div class="col-md-3 col-6 text-center mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="icon btn btn-primary d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
            <i class="fa fa-phone"></i>
          </div>
          <p class="mt-3">
            <span class="fw-bold">Telp:</span><br>
            <a href="https://wa.me/6285640600585/?text=teksberkodeurl" class="text-decoration-none">+6285640600585</a>
          </p>
        </div>
        <div class="col-md-3 col-6 text-center mb-4" data-aos="fade-up" data-aos-delay="200">
          <div class="icon btn btn-primary d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
            <i class="fa fa-paper-plane"></i>
          </div>
          <p class="mt-3">
            <span class="fw-bold">Email:</span><br>
            <a href="mailto:ecomarket84@gmail.com" class="text-decoration-none">ecomarket84@gmail.com</a>
          </p>
        </div>
        <div class="col-md-3 col-6 text-center mb-4" data-aos="fade-up" data-aos-delay="300">
          <div class="icon btn btn-primary d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
            <i class="fa fa-globe"></i>
          </div>
          <p class="mt-3">
            <span class="fw-bold">Website:</span><br>
            <a href="./index.html" class="text-decoration-none">ecomarket.com.id</a>
          </p>
        </div>
      </div>

      <div class="row align-items-stretch">
        <div class="col-md-6" data-aos="fade-right">
          <div class="card border-0 shadow p-4">
            <h2 class="text-senter">Contact Us</h2>
            <hr>
            <p class="text-center">Silahkan hubungi kami jika anda tertarik menjadi nasabah<h4 class="text-primary text-center">Eco Market</h4></p>
            <form action="<?= base_url('/contact/save') ?>" method="post" id="contactForm">
              <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama.." required>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email.." required>
              </div>
              <div class="mb-3">
                  <label for="subject" class="form-label">Subject</label>
                  <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject.." required>
              </div>
              <div class="mb-3">
                  <label for="message" class="form-label">Pesan</label>
                  <textarea id="message" class="form-control" name="message" rows="4" placeholder="Pesan..." required></textarea>
              </div>
              <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Kirim Pesan <i class="fa fa-envelope"></i></button>
              </div>
          </form>

          </div>
        </div>

        <div class="col-md-6" data-aos="fade-left">
          <div class="card border-0 shadow p-4">
            <h2 class="text-center">Our Location</h2>
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.54171192807638!2d109.19683378189814!3d-6.93030029764738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fc7b551932785%3A0xd49fc77da083411d!2sToko%20Ulya!5e0!3m2!1sid!2sid!4v1719284949258!5m2!1sid!2sid"
              width="100%" height="450" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
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

    // Encode pesan untuk URL
    const whatsappURL = `https://wa.me/${adminNumber}?text=${encodeURIComponent(whatsappMessage)}`;

    // Buka WhatsApp
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


<?= $this->endSection(); ?>