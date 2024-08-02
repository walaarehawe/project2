<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('0f97a4ae81688bc63a71', {
      cluster: 'ap4'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      displayData(data);
    });

    function displayData(data) {
      // Display the data on the page
      var messageElement = document.createElement('div');
      messageElement.innerText = data.message;
      document.body.appendChild(messageElement);

      // Add an edit button
      var editButton = document.createElement('button');
      editButton.innerText = 'Edit';
      editButton.addEventListener('click', function() {
        // Add functionality to edit the data here
        // For example, redirect to an edit page with the data
      });
      document.body.appendChild(editButton);
    }
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
</html>