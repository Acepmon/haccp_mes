 importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js');

 firebase.initializeApp({
    apiKey: "AIzaSyCME99yTOTC4LKPIqUqSOuyxsLSqGRIUg8",
    authDomain: "haccp-mes.firebaseapp.com",
    projectId: "haccp-mes",
    storageBucket: "haccp-mes.appspot.com",
    messagingSenderId: "518404578173",
    appId: "1:518404578173:web:3a85c5553012e22826ca14",
    measurementId: "G-NJTD4RD45T"
});

const messaging = firebase.messaging()

messaging.usePublicVapidKey('BIPX6O-78pp9Ftw4rBEEaXB4c5JciYDcB22_y-ZlYgJemT1MkkESk5Qwt3wCk89Ey1SIvb8OITQVNVaWW5VHgqQ');

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// messaging.onBackgroundMessage(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   // Customize notification here
//   const notificationTitle = 'Background Message Title';
//   const notificationOptions = {
//     body: 'Background Message body.',
//     icon: '/firebase-logo.png'
//   };

//   self.registration.showNotification(notificationTitle,
//     notificationOptions);
// });