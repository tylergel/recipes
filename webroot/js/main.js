/*
Copyright 2016 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

var app = (function() {
  'use strict';


  var isSubscribed = false;
  var swRegistration = null;

  var notifyButton = document.querySelector('.js-notify-btn');
  var pushButton = document.querySelector('.js-push-btn');

  if (!('Notification' in window)) {
    console.log('This browser does not support notifications!');
    return;
  }

  Notification.requestPermission(function(status) {
    console.log('Notification permission status:', status);
  });

  function displayNotification() {

    if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {

      var options = {
         tag: 'id1',
  body: 'First notification!',
  icon: 'images/notification-flat.png',
  vibrate: [100, 50, 100],
  data: {
    dateOfArrival: Date.now(),
    primaryKey: 1
  },

  actions: [
    {action: 'explore', title: 'Go to the site',
      icon: 'images/checkmark.png'},
    {action: 'close', title: 'Close the notification',
      icon: 'images/xmark.png'},
  ]

  // TODO 5.1 - add a tag to the notification

};

    reg.showNotification('Hello world!', options);
    });
  }

  }

  function initializeUI() {

    pushButton.addEventListener('click', function() {
  pushButton.disabled = true;
  if (isSubscribed) {
    unsubscribeUser();
  } else {
    subscribeUser();
  }
});

swRegistration.pushManager.getSubscription()
.then(function(subscription) {
  isSubscribed = (subscription !== null);

  updateSubscriptionOnServer(subscription);

  if (isSubscribed) {
    console.log('User IS subscribed.');
  } else {
    console.log('User is NOT subscribed.');
  }

  updateBtn();
});

  }

  // TODO 4.2a - add VAPID public key

  function subscribeUser() {

    swRegistration.pushManager.subscribe({
  userVisibleOnly: true
})
.then(function(subscription) {
  console.log('User is subscribed:', subscription);
  updateSubscriptionOnServer(subscription);

  isSubscribed = true;

  updateBtn();
})
.catch(function(err) {
  if (Notification.permission === 'denied') {
    console.warn('Permission for notifications was denied');
  } else {
    console.error('Failed to subscribe the user: ', err);
  }
  updateBtn();
});

  }

  function unsubscribeUser() {

    swRegistration.pushManager.getSubscription()
.then(function(subscription) {
  if (subscription) {
    return subscription.unsubscribe();
  }
})
.catch(function(error) {
  console.log('Error unsubscribing', error);
})
.then(function() {
  updateSubscriptionOnServer(null);

  console.log('User is unsubscribed');
  isSubscribed = false;

  updateBtn();
});

  }

  function updateSubscriptionOnServer(subscription) {
    // Here's where you would send the subscription to the application server
    console.log(subscription);
    if(subscription) {
    var var_data = JSON.stringify(subscription);
    $.ajax({
                      type: "POST",
                            url: 'testing.php',

                             data: { data: var_data },
                             success: function(data) {
                               alert(data);

                             }
                         });
                       }
    var subscriptionJson = document.querySelector('.js-subscription-json');
    var endpointURL = document.querySelector('.js-endpoint-url');
    var subAndEndpoint = document.querySelector('.js-sub-endpoint');

    if (subscription) {
      subscriptionJson.textContent = JSON.stringify(subscription);
      endpointURL.textContent = subscription.endpoint;
      subAndEndpoint.style.display = 'block';
    } else {
      subAndEndpoint.style.display = 'none';
    }
  }

  function updateBtn() {
    if (Notification.permission === 'denied') {
      pushButton.textContent = 'Push Messaging Blocked';
      pushButton.disabled = true;
      updateSubscriptionOnServer(null);
      return;
    }

    if (isSubscribed) {
      pushButton.textContent = 'Disable Push Messaging';
    } else {
      pushButton.textContent = 'Enable Push Messaging';
    }

    pushButton.disabled = false;
  }

  function urlB64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
  }

  notifyButton.addEventListener('click', function() {
    displayNotification();
  });

  if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('sw.js')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg);

      swRegistration = swReg;

      initializeUI();

    })
    .catch(function(error) {
      console.error('Service Worker Error', error);
    });
  } else {
    console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push Not Supported';
  }

})();
