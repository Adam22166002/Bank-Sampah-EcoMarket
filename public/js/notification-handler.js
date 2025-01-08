// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAQtUHYbmMRgjG5yzL7RLlmWPJWqaZOuwI",
  authDomain: "eco-market-cc4e6.firebaseapp.com",
  projectId: "eco-market-cc4e6",
  storageBucket: "eco-market-cc4e6.firebasestorage.app",
  messagingSenderId: "510650531763",
  appId: "1:510650531763:web:763c03728c8b036fe555c6",
  measurementId: "G-KXP1GP3RH4",
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// Request permission and get token
async function initializeNotifications() {
  try {
    const permission = await Notification.requestPermission();
    if (permission === "granted") {
      const token = await messaging.getToken();
      if (token) {
        sendTokenToServer(token);
      }
    }
  } catch (error) {
    console.log("Notification permission denied");
  }
}

// Send token to server
function sendTokenToServer(token) {
  fetch("/notification/save-token", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token }),
  })
    .then((response) => response.json())
    .then((data) => console.log("Token saved:", data))
    .catch((error) => console.error("Error saving token:", error));
}

// Handle foreground messages
messaging.onMessage((payload) => {
  const { title, body } = payload.notification;
  new Notification(title, {
    body,
    icon: "/Assets/img/icons/icon-192x192.png",
  });
});

// Initialize when document is ready
document.addEventListener("DOMContentLoaded", initializeNotifications);
