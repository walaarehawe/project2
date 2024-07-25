import './bootstrap';
// // // import './bootstrap.js';  // تأكد من وجود ملف bootstrap.js في resources/js

// // // Import the functions you need from the SDKs you need
// // import { initializeApp } from "firebase/app";
// // import { getAnalytics } from "firebase/analytics";
// // import { getMessaging, getToken } from "firebase/messaging";
// // // TODO: Add SDKs for Firebase products that you want to use
// // // https://firebase.google.com/docs/web/setup#available-libraries

// // // Your web app's Firebase configuration
// // // For Firebase JS SDK v7.20.0 and later, measurementId is optional
// // const firebaseConfig = {
// //     apiKey: "AIzaSyDWm0zQyh_OQLao_v8jMekOJl61ZZzOHaE",
// //     authDomain: "restaurantappnotifiy.firebaseapp.com",
// //     projectId: "restaurantappnotifiy",
// //     storageBucket: "restaurantappnotifiy.appspot.com",
// //     messagingSenderId: "1078066996552",
// //     appId: "1:1078066996552:web:20ba6d0ab2ffc99c317f7d",
// //     measurementId: "G-4PPNB0R262"
// //   };
  

// // // Initialize Firebase
// // const app = initializeApp(firebaseConfig);
// // const analytics = getAnalytics(app);

// // const messaging = getMessaging();
// // getToken(messaging, { vapidKey: 'BI4U-Xyg8uQU5QdIk12U1jtwDnwb2Kfsq82bgJxgmrXCW2OVslsvL-TybJWEldP2wXoVxMAOMjBNFnaOUUIOcnw' }).then((currentToken) => {
// //   if (currentToken) {
// //     console.log(currentToken);
// //   } else {
// //     // Show permission request UI
// //     console.log('No registration token available. Request permission to generate one.');
// //   }
// // }).catch((err) => {
// //   console.log('An error occurred while retrieving token. ', err);
// // });







// // firebase-config.js

// import { initializeApp } from "firebase/app";
// import { getMessaging, getToken,onMessage } from "firebase/messaging";

// const firebaseConfig = {
//     apiKey: "AIzaSyDWm0zQyh_OQLao_v8jMekOJl61ZZzOHaE",
//     authDomain: "restaurantappnotifiy.firebaseapp.com",
//     projectId: "restaurantappnotifiy",
//     storageBucket: "restaurantappnotifiy.appspot.com",
//     messagingSenderId: "1078066996552",
//     appId: "1:1078066996552:web:20ba6d0ab2ffc99c317f7d",
//     measurementId: "G-4PPNB0R262"
//   };

// const app = initializeApp(firebaseConfig);
// const messaging = getMessaging(app);

// export { messaging, getToken };



// // app.js



// getToken(messaging, { vapidKey: 'BI4U-Xyg8uQU5QdIk12U1jtwDnwb2Kfsq82bgJxgmrXCW2OVslsvL-TybJWEldP2wXoVxMAOMjBNFnaOUUIOcnw' }).then((currentToken) => {
//   if (currentToken) {
//     console.log('Current token:', currentToken);
//   } else {
//     console.log('No registration token available. Request permission to generate one.');
//   }
// }).catch((err) => {
//   console.log('An error occurred while retrieving token:', err);
// });


// onMessage(messaging, (payload) => {
//     console.log('Message received. ', payload);
//     // ...
//   });

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDWm0zQyh_OQLao_v8jMekOJl61ZZzOHaE",
  authDomain: "restaurantappnotifiy.firebaseapp.com",
  projectId: "restaurantappnotifiy",
  storageBucket: "restaurantappnotifiy.appspot.com",
  messagingSenderId: "1078066996552",
  appId: "1:1078066996552:web:20ba6d0ab2ffc99c317f7d",
  measurementId: "G-4PPNB0R262"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Get token
getToken(messaging, { vapidKey: 'BI4U-Xyg8uQU5QdIk12U1jtwDnwb2Kfsq82bgJxgmrXCW2OVslsvL-TybJWEldP2wXoVxMAOMjBNFnaOUUIOcnw' }).then((currentToken) => {
  if (currentToken) {
    console.log('Current token:', currentToken);
  } else {
    console.log('No registration token available. Request permission to generate one.');
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token:', err);
});

// Listen for messages
onMessage(messaging, (payload) => {
  console.log('Message received. ', payload);

  // Assuming payload.data contains order details
  const orderDetails = JSON.parse(payload.data.order_details);

  // Create a new element for the order
  const orderElement = document.createElement('div');
  orderElement.textContent = `Order ID: ${orderDetails.id}, Order Details: ${orderDetails.details}`;
  document.getElementById('orders').appendChild(orderElement);
});
