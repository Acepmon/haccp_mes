importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js');

var config = {
    apiKey: "AIzaSyCME99yTOTC4LKPIqUqSOuyxsLSqGRIUg8",
    authDomain: "haccp-mes.firebaseapp.com",
    projectId: "haccp-mes",
    storageBucket: "haccp-mes.appspot.com",
    messagingSenderId: "518404578173",
    appId: "1:518404578173:web:3a85c5553012e22826ca14",
    measurementId: "G-NJTD4RD45T"
};

firebase.initializeApp(config);

const messaging = firebase.messaging();