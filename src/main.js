
requestNotificationPermission();

GetMainCuarteles();

function requestNotificationPermission() {
  // Check if the browser supports the Notification API
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notifications.");
    return;
  }

  // Request permission from the user
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      console.log("Notification permission granted.");
    } else {
      console.log("Notification permission denied.");
    }
  });
}


