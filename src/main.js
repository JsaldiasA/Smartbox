

GetMainCuarteles();
// Step 1: Register the Service Worker

async function initNotifications( ) {
  
  if (!('serviceWorker' in navigator) || !('Notification' in window)) {
    console.error('Service Workers or Notifications are not supported.');
    return;
  }

  try {
    // Register the background script file
    const registration = await navigator.serviceWorker.register('sw.js');
    console.log('Service Worker registered successfully:', registration);

    // Step 2: Request user permission
    const permission = await Notification.requestPermission();
    if (permission === 'granted') {
      console.log('Notification permission granted.');
      
      // Step 3: Trigger a local test notification
     // showLocalNotification(registration, text);
     registration.showNotification('Notifications activated');

    } else {
      console.warn('Notification permission denied.');
    }
  } catch (error) {
    console.error('Initialization failed:', error);
  }
}

//function showLocalNotification( registration ) {
//  const options = {
 //   body: text,
//  };

  // The service worker registration must call the method, not the global window object
  //registration.showNotification('Alert', options);
//}

//initNotifications();



