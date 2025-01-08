<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Eco Market</title>
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="theme-color" content="#4e73df">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom fonts for this template-->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="<?= base_url(); ?>/Assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="512x512" href="/Assets/img/icons/icon-512x512.png">
    <link rel="apple-touch-icon" href="/Assets/img/icons/icon-512x512.png">

    <!-- firebase -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"></script>

    <!-- regis service worker-->
    <script>
        // Register service worker dengan lebih baik
        if ('serviceWorker' in navigator) {
        window.addEventListener('load', async () => {
            try {
            // Unregister service worker lama jika ada
            const registrations = await navigator.serviceWorker.getRegistrations();
            for (let registration of registrations) {
                await registration.unregister();
            }

            // Register service worker baru
            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js', {
                scope: '/'
            });
            console.log('ServiceWorker registered with scope:', registration.scope);
            } catch (error) {
            console.error('ServiceWorker registration failed:', error);
            }
        });
        }
    </script>

    <style>
        #offline-banner {
        z-index: 9999;
        padding: 10px;
        background-color: #fff3cd;
        border-bottom: 1px solid #ffeeba;
        }

        .offline-mode {
            filter: grayscale(20%);
        }
        .navbar {
            transition: all 0.5s;
        }
        .navbar-scrolled {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .hero {
            padding: 120px 0;
            background: #f8f9fa;
        }
        .icon-box {
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s;
        }
        .icon-box:hover {
            transform: translateY(-5px);
        }
        .icon-box .icon {
            font-size: 32px;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .portfolio-item {
            margin-bottom: 30px;
        }
        .portfolio-item img {
            border-radius: 10px;
            transition: all 0.3s;
        }
        .portfolio-item:hover img {
            transform: scale(1.05);
        }
        .filter-button {
            border: none;
            padding: 8px 16px;
            margin: 5px;
            border-radius: 20px;
            background: transparent;
            cursor: pointer;
        }
        .filter-button.active {
            background: #0d6efd;
            color: white;
        }
        #scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
        }
        .modal-xl {
        max-width: 95%;
        }

        #nasabahTable {
            width: 100% !important;
        }

        .form-select {
            min-width: 100px;
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }

        .tracking-wide {
            letter-spacing: 0.05em;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate__bounce {
            animation: bounce 2s infinite;
        }
        @keyframes panah {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-10px); }
        }

        .animate__panah {
            animation: panah 2s infinite;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?= $this->include('template/sidebar'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?= $this->include('template/topbar'); ?>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $this->renderSection('page-content'); ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <footer
          class="text-center text-lg-start text-white"
          style="background-color: #1c2331"
          >
    <!-- Section: Social media -->
    <section
             class="d-flex justify-content-between p-4 bg-primary">
      <!-- Left -->
      <div class="me-5">
        <span>Terhubung dengan kami di jejaring sosial Eco Market:</span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <a href="#" class="text-white me-2">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="text-white me-2">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="text-white me-2">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="#" class="text-white me-2">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-6 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold">Eco Market</h6>
            <hr
                class="mt-0 d-inline-block mx-auto bg-primary"
                style="width: 60px; height: 2px"
                />
            <p>
              Platfrom Bank Sampah Digital.
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-6 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Layanan</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto bg-primary"
                style="width: 60px; height: 2px"
                />
            <p>
              <a href="#" class="text-white">Jual Sampah</a>
            </p>
            <p>
              <a href="#" class="text-white">Tukar Produk</a>
            </p>
            <p>
              <a href="#" class="text-white">Tentang Eco Market</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Contact</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p><i class="fas fa-home mr-3"></i> Kota Tgeal, Jawa Tengah</p>
            <p><i class="fas fa-envelope mr-3"></i> ecomarket@id.com</p>
            <p><i class="fas fa-phone mr-3"></i> +62 856 4060 0585</p>
            <p><i class="fas fa-print mr-3"></i> +62 852 2921 3855</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
      © 2024 Copyright:
      <a class="text-white" href="<?= base_url('/')?>"
         >Develop Eco Market</a
        >
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal Logout-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siap untuk Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Ya, Logout" di bawah jika Anda siap mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-danger" href="<?= base_url('logout'); ?> ">Ya, Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase Script -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
        import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-messaging.js";

        const firebaseConfig = {
            apiKey: "AIzaSyAQtUHYbmMRgjG5yzL7RLlmWPJWqaZOuwI",
            authDomain: "eco-market-cc4e6.firebaseapp.com",
            projectId: "eco-market-cc4e6",
            storageBucket: "eco-market-cc4e6.firebasestorage.app",
            messagingSenderId: "510650531763",
            appId: "1:510650531763:web:763c03728c8b036fe555c6",
            measurementId: "G-KXP1GP3RH4"
        };

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        // Improved notification handling
        async function requestNotificationPermission() {
            try {
                // Cek apakah permission sudah pernah diminta
                if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                    const permission = await Notification.requestPermission();
                    console.log('Permission:', permission);
                }

                if (Notification.permission === 'granted') {
                    const token = await getToken(messaging, {
                        vapidKey: "BIPCPyX0P9P0AvkEysYdlTgI0cGIrYl7UrOdren7rPWces7qkZswILnXfPqjU3JPBebm7CR851bwhome5drejlY"
                    });
                    
                    if (token) {
                        await saveToken(token);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function saveToken(token) {
            try {
                const response = await fetch('/notification/save-token', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token })
                });
                
                if (!response.ok) {
                    throw new Error('Failed to save token');
                }
            } catch (error) {
                console.error('Error saving token:', error);
            }
        }

        // Handle messages
        onMessage(messaging, (payload) => {
            const { title, body } = payload.notification;
            const notificationOptions = {
                body,
                icon: '/Assets/img/icons/icon-192x192.png',
                badge: '/Assets/img/icons/icon-96x96.png',
                data: payload.data
            };

            new Notification(title, notificationOptions);
        });

        document.addEventListener('DOMContentLoaded', requestNotificationPermission);
    </script>

    <script>
        window.addEventListener('beforeunload', () => {
        sessionStorage.setItem('lastPage', window.location.href);
        });
    </script>
    <!-- mode offline -->
    <script>
        let offlineTimer;
        const OFFLINE_TIMEOUT = 5000;
        async function checkInternetConnection() {
            try {
                const response = await fetch('/ping', {
                    method: 'HEAD',
                    cache: 'no-store'
                });
                return response.ok;
            } catch (error) {
                return false;
            }
        }

            function showOfflineNotification() {
                if (!navigator.onLine) {
                Swal.fire({
                    title: 'Koneksi Terputus',
                    text: 'Anda akan dialihkan ke mode offline...',
                    icon: 'warning',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    if (!navigator.onLine) {
                            sessionStorage.setItem('lastPage', window.location.href);
                            window.location.href = '/offline.html';
                        }
                });
            }
        }

        // Handle online/offline status
        async function updateOnlineStatus(event) {
            const isConnected = await checkInternetConnection();

            if (isConnected) {
                if (offlineTimer) {
                    clearTimeout(offlineTimer);
                    offlineTimer = null;
                }
                if (window.location.pathname === '/offline.html') {
                    const lastPage = sessionStorage.getItem('lastPage') || '/';
                    window.location.href = lastPage;
                }

                // Cek apakah ada transaksi pending
                const pendingTransactions = localStorage.getItem('pendingTransactions');
                if (pendingTransactions) {
                    try {
                        const transactions = JSON.parse(pendingTransactions);
                        processPendingTransactions(transactions)
                            .then(() => {
                                localStorage.removeItem('pendingTransactions');
                            })
                            .catch(error => {
                                console.error('Error processing pending transactions:', error);
                            });
                    } catch (error) {
                        console.error('Error parsing pending transactions:', error);
                    }
                }

                // Redirect ke halaman terakhir jika ada
                const lastPage = sessionStorage.getItem('lastPage');
                if (lastPage && window.location.pathname === '/offline.html') {
                    window.location.href = lastPage;
                }

                // Refresh data yang mungkin sudah berubah
                if (typeof refreshPageData === 'function') {
                    refreshPageData();
                }
                resetUIForOnlineMode();
            } else {
                if (!offlineTimer) {
                    offlineTimer = setTimeout(() => {
                        showOfflineNotification();
                    }, OFFLINE_TIMEOUT);
                }
            }
            
        }

        // Handle form submission saat offline
        function handleOfflineSubmit(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const transaction = {
                url: event.target.action,
                method: event.target.method,
                data: Object.fromEntries(formData),
                timestamp: new Date().toISOString()
            };

            // Simpan transaksi ke localStorage
            let pendingTransactions = localStorage.getItem('pendingTransactions');
            pendingTransactions = pendingTransactions ? JSON.parse(pendingTransactions) : [];
            pendingTransactions.push(transaction);
            localStorage.setItem('pendingTransactions', JSON.stringify(pendingTransactions));

            // Tampilkan pesan ke user
            showNotification('Transaksi akan diproses saat online', 'info');
        }

        // Proses transaksi pending saat online
        async function processPendingTransactions(transactions) {
            const results = [];
            
            for (const transaction of transactions) {
                try {
                    const response = await fetch(transaction.url, {
                        method: transaction.method,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(transaction.data)
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    results.push({
                        status: 'success',
                        transaction: transaction,
                        response: await response.json()
                    });

                    showNotification('Transaksi pending berhasil diproses', 'success');
                } catch (error) {
                    results.push({
                        status: 'error',
                        transaction: transaction,
                        error: error.message
                    });
                    
                    showNotification('Gagal memproses beberapa transaksi pending', 'error');
                }
            }

            return results;
        }

        // Update UI untuk mode offline
        function updateUIForOfflineMode() {
            if (!document.getElementById('offline-banner')) {
                const offlineBanner = document.createElement('div');
                offlineBanner.id = 'offline-banner';
                offlineBanner.className = 'alert alert-warning fixed-top text-center';
                offlineBanner.innerHTML = `
                    <i class="fas fa-wifi-slash"></i>
                    Koneksi terputus, mengalihkan ke mode offline...
                `;
                document.body.prepend(offlineBanner);
            }
        }

        // Reset UI ketika kembali online
        function resetUIForOnlineMode() {
            const offlineBanner = document.getElementById('offline-banner');
            if (offlineBanner) {
                offlineBanner.remove();
            }
        }
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', () => {
            if (!navigator.onLine) {
                showOfflineNotification();
            }
        });

        // Cek koneksi saat load halaman
        document.addEventListener('DOMContentLoaded', async () => {
            const isConnected = await checkInternetConnection();
            if (!isConnected) {
                showOfflineNotification();
            }
        });

        // Tangkap error fetch
        window.addEventListener('unhandledrejection', async event => {
            if (event.reason instanceof TypeError && 
                event.reason.message.includes('Failed to fetch')) {
                const isConnected = await checkInternetConnection();
                if (!isConnected) {
                    showOfflineNotification();
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/Assets/vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>/Assets/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>