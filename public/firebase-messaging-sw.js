


importScripts('https://www.gstatic.com/firebasejs/9.6.5/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.5/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyDWm0zQyh_OQLao_v8jMekOJl61ZZzOHaE",
    authDomain: "restaurantappnotifiy.firebaseapp.com",
    projectId: "restaurantappnotifiy",
    storageBucket: "restaurantappnotifiy.appspot.com",
    messagingSenderId: "1078066996552",
    appId: "1:1078066996552:web:20ba6d0ab2ffc99c317f7d",
    measurementId: "G-4PPNB0R262"
  };

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();





