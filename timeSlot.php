<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Time Selector</title>
  <link rel="stylesheet" href="style.css" />
</head>
<style>
  .container {
  max-width: 400px;
  width: 100%;
  background: rgba(255, 255, 255, 0.1);
  padding: 30px 25px;
  border-radius: 20px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
  margin-bottom: 30px;
  color: #fff;
  margin-top: 30px; /* Add this line to create space above the container */
}

</style>
<body>
  <!-- Background Effects -->
  <div class="background"></div>
  <div class="thunderbolt"></div>

  <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">

    <!-- Time Selection Form -->
    <form action="save_time.php" method="post" style="width: 100%; max-width: 400px;" onsubmit="return validateTimeRange()">
      <div class="container">
        <h2>Select Start and End Time</h2>

        <div class="form-group">
          <label for="start-date">Start Date and Time:</label>
          <input type="datetime-local" id="start-date" name="start_date" required>
        </div>

        <div class="form-group">
          <label for="end-date">End Date and Time:</label>
          <input type="datetime-local" id="end-date" name="end_date" required>
        </div>

        <div class="vehicle-selector" id="clock">
          <h3 style="color: #00ffff;">Current Time (24-Hour Format):</h3>
          <div id="time-display" style="font-size: 20px; margin-top: 10px;"></div>
        </div>

        <!-- Buttons below the container -->
        <div style="margin-top: 20px;">
          <button class="electric-btn" type="submit" name="add_time" style="margin-bottom: 15px;">Add Time</button>
          <button class="electric-btn" type="button" onclick="handlePayment()">Proceed to Payment</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Clock Script -->
  <script>
    // Function to format the time into 12-hour format
    function formatTime(date) {
      let hours = date.getHours();
      let minutes = date.getMinutes();
      let seconds = date.getSeconds();
      let ampm = hours >= 12 ? 'PM' : 'AM';

      hours = hours % 12;
      hours = hours ? hours : 12;
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      return hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    }

    // Update clock every second
    function updateClock() {
      const currentTime = new Date();
      document.getElementById('time-display').textContent = formatTime(currentTime);
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Validate if end time is greater than start time
    function validateTimeRange() {
      const start = document.getElementById('start-date').value;
      const end = document.getElementById('end-date').value;

      if (start && end && new Date(start) >= new Date(end)) {
        alert("End time must be later than start time.");
        return false; 
      }
      return true;
    }

    // Redirect to payment page
    function handlePayment() {
      window.location.href = 'payment.php'; 
    }
  </script>
  <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built with ❤️ for a cleaner future.</small>
    </div>
  </footer>

</body>
</html>
