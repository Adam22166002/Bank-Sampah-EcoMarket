const CACHE_NAME = "eco-market-v1";
const OFFLINE_URL = "/offline.html";
const DYNAMIC_CACHE = "dynamic-v1";

const assetsToCache = [
  "/",
  "/vendor/twilio",
  "/vendor/dompdf",
  "/app/Config/Routes.php",
  "/app/Config/Email.php",
  "/app/Config/Filters.php",
  "/app/Config/Validation.php",
  "/app/Views/login/login",
  "/app/Views/Login/register",
  "/app/Views/Login/forgot_password",
  "/app/Views/Login/reset_password",
  "/app/Views/Login/reset_password_token",
  "/app/Views/user/index",
  "/app/Views/user/about",
  "/app/Views/user/contact",
  "/app/Views/user/detail_penukaran",
  "/app/Views/user/help",
  "/app/Views/user/jual_sampah",
  "/app/Views/user/riwayat_point",
  "/app/Views/user/riwayat_transaksi",
  "/app/Views/user/tentang_kita",
  "/app/Views/user/tukar_produk",
  "/app/Views/my_profile",
  "/app/Views/seller/index",
  "/app/Views/seller/riwayat_transaksi",
  "/app/Views/seller/produk/edit",
  "/app/Views/admin/",
  "/app/Views/admin/detail_user",
  "/app/Views/admin/detail",
  "/app/Views/admin/index",
  "/app/Views/admin/laporan",
  "/app/Views/admin/produk",
  "/app/Views/admin/total_sampah",
  "/app/Views/admin/transaksi",
  "/app/Views/admin/user_management",
  "/app/Views/emails/forgot_password",
  "/app/Views/ewallet/index",
  "/app/Views/ewallet/riwayat_penarikan",
  "/app/Views/notifikasi/index",
  "/app/Views/riwayat/point",
  "/app/Views/riwayat/saldo",
  "/app/Views/template/index",
  "/app/Views/template/sidebar",
  "/app/Views/template/topbar",
  "/public/offline.html",
  "/manifest.json",
  "/firebase-messaging-sw.js",
  "/sw.js",
  "/app/Views/admin/verifikasi_penarikan",
  "/app/Models/ContactModel",
  "/app/Models/KategoriSampahModel",
  "/app/Models/NotifikasiModel",
  "/app/Models/PasswordResetModel",
  "/app/Models/PenarikanEwalletModel",
  "/app/Models/PenukaranProdukModel",
  "/app/Models/ProdukModel",
  "/app/Models/RiwayatPointModel",
  "/app/Models/RiwayatSaldoModel",
  "/app/Models/TransaksiSampahModel",
  "/app/Models/UserManagementModel",
  "/app/Models/VerifikasiModel",
  "/app/Controller/",
  "/app/Controller/Admin",
  "/app/Controller/BaseController",
  "/app/Controller/Contact",
  "/app/Controller/EwalletController",
  "/app/Controller/ForgotPasswordController",
  "/app/Controller/Home",
  "/app/Controller/LaporanController",
  "/app/Controller/NotificationController",
  "/app/Controller/NotifikasiController",
  "/app/Controller/PenukaranController",
  "/app/Controller/ProdukController",
  "/app/Controller/ResetPasswordController",
  "/app/Controller/RiwayatController",
  "/app/Controller/Seller",
  "/app/Controller/TransaksiController",
  "/app/Controller/User",
  "/app/Controller/UserManagementController",
  "/public/Assets/css/sb-admin-2.min.css",
  "/public/Assets/js/sb-admin-2.min.js",
  "/public/Assets/vendor/jquery/jquery.min.js",
  "/public/Assets/vendor/bootstrap/js/bootstrap.bundle.min.js",
  "/public/Assets/vendor/jquery-easing/jquery.easing.min.js",
  "/public/Assets/vendor/fontawesome-free/css/all.min.css",
  "/public/Assets/img/logo.svg",
  "/public/Assets/img/ilustrasi.svg",
  "/public/Assets/img/ambil.svg",
  "/public/Assets/img/daur ulang.svg",
  "/public/Assets/img/default.svg",
  "/public/Assets/img/eco_market.svg",
  "/public/Assets/img/kumpul.svg",
  "/public/Assets/img/logo_point.svg",
  "/public/Assets/img/logo_tentang.svg",
  "/public/Assets/img/tukar.svg",
  "/public/Assets/img/hero.png",
  "/public/Assets/img/icons/icon-96x96.png",
  "/public/Assets/img/icons/icon-144x144.png",
  "/public/Assets/img/icons/icon-512x512.png",
  "//public/js/",
  "//public/uploads/bukti",
  "//public/uploads/fotoProduk",
  "//public/uploads/qrcodes",
];

// instalasi sw
self.addEventListener("install", (event) => {
  event.waitUntil(
    Promise.all([
      caches.open(CACHE_NAME).then((cache) => {
        console.log("Caching app shell and content");
        return cache.addAll(assetsToCache);
      }),
      caches.open(CACHE_NAME).then((cache) => {
        return cache.add(OFFLINE_URL);
      }),
    ])
  );
  self.skipWaiting();
});

// activate sw
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(
        keyList.map((key) => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Improved fetch event
self.addEventListener("fetch", (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-GET requests
  if (request.method !== "GET") {
    if (request.method === "POST" && !navigator.onLine) {
      event.respondWith(caches.match(OFFLINE_URL));
      return;
    }
    return;
  }

  event.respondWith(
    fetch(request)
      .then((response) => {
        if (response.ok) {
          const responseToCache = response.clone();
          caches
            .open(CACHE_NAME)
            .then((cache) => cache.put(request, responseToCache));
          return response;
        }
        throw new Error("Network response was not ok");
      })
      .catch(async () => {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
          return cachedResponse;
        }

        // Jika tidak ada cache, redirect ke offline.html
        if (request.mode === "navigate") {
          const cache = await caches.open(CACHE_NAME);
          return cache.match(OFFLINE_URL);
        }

        throw new Error("No cached response found");
      })
  );
});
