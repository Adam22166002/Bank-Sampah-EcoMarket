// public/firebase-messaging-sw.js

importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"
);
importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
  apiKey: "AIzaSyAQtUHYbmMRgjG5yzL7RLlmWPJWqaZOuwI",
  authDomain: "eco-market-cc4e6.firebaseapp.com",
  projectId: "eco-market-cc4e6",
  storageBucket: "eco-market-cc4e6.appspot.com",
  messagingSenderId: "510650531763",
  appId: "1:510650531763:web:763c03728c8b036fe555c6",
});

const messaging = firebase.messaging();
const CACHE_NAME = "eco-market-v1";
const OFFLINE_URL = "/offline.html";
let pendingRequests = [];

// Simpan cache saat install
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.add(OFFLINE_URL))
  );
});

// Handle fetch requests
self.addEventListener("fetch", (event) => {
  if (event.request.method === "POST") {
    event.respondWith(
      fetch(event.request.clone()).catch(async (error) => {
        // Simpan request yang gagal
        pendingRequests.push({
          url: event.request.url,
          method: event.request.method,
          body: await event.request.clone().text(),
          headers: Array.from(event.request.headers.entries()),
        });

        // Redirect ke halaman offline
        return caches.match(OFFLINE_URL);
      })
    );
  }
});

// Cek koneksi online dan kirim pending requests
self.addEventListener("online", async () => {
  while (pendingRequests.length > 0) {
    const request = pendingRequests.shift();
    try {
      await fetch(
        new Request(request.url, {
          method: request.method,
          body: request.body,
          headers: new Headers(request.headers),
        })
      );
    } catch (error) {
      console.error("Failed to send pending request:", error);
      pendingRequests.unshift(request);
      break;
    }
  }
});

// Handle notifikasi background
messaging.onBackgroundMessage((payload) => {
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: "/Assets/img/icons/icon-192x192.png",
    badge: "/Assets/img/icons/icon-96x96.png",
    data: payload.data,
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
