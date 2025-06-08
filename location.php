<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dealer = $_POST['dealerLocation'] ?? '';

    if (!empty($dealer)) {
        $stmt = $pdo->prepare("INSERT INTO dealer_selections (location) VALUES (:location)");
        $stmt->execute(['location' => $dealer]);

        header("Location: dealer.php");
        exit;
    } else {
        $errorMessage = "Please select a dealer location.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Vehicle & Dealer Selection</title>
  <style>
    .dealer-selector {
      width: 420px;
      margin: 60px auto;
      padding: 25px;
      border: 1px solid #ccc;
      border-radius: 10px;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.1);
      box-shadow: rgba(0, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dealer-selector select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 20px;
    }

    .dealer-selector button {
      padding: 10px 20px;
      font-size: 16px;
      margin: 10px 5px;
      cursor: pointer;
    }

    .error-message {
      margin: 10px 0;
      color: red;
    }
  </style>
</head>

<body>
  <div class="thunderbolt"></div>
  <div class="background"></div>

  <!-- Location Selector -->
  <form action="location.php" method="POST">
    <div class="dealer-selector">
      <h2>Select Location</h2>

      <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?= $errorMessage ?></div>
      <?php endif; ?>

      <select name="dealerLocation" id="dealerSelect" required>
        <option value="">--Select Location--</option>
        <option value="STATION ROAD">STATION ROAD</option>
        <option value="Chatrapati Sambhaji road">Chatrapati Sambhaji road</option>
        <option value="Deshmukh road">Deshmukh road</option>
        <option value="Vadagav main road">Vadagav main road</option>
        <option value="Ambedkar road">Ambedkar road</option>
        <option value="Tashildar galli">Tashildar galli</option>
        <option value="Hutatma chow">Hutatma chow</option>
        <option value="Pai resort">Pai resort</option>
        <option value="Anjaneya nagar">Anjaneya nagar</option>
        <option value="Railway station Wall socket">Railway station Wall socket</option>
        <option value="Farfield by Marriott kakti">Farfield by Marriott kakti</option>
      </select>
      <br />
      <button type="button" onclick="showDealerLocation()">Show Location</button>
      <button type="submit" id="bookSlotBtn">Book Slot</button>
    </div>
  </form>

  <script>
    function showDealerLocation() {
      const selectedLocation = document.getElementById("dealerSelect").value;
      const locationLinks = {
        "STATION ROAD": "https://maps.app.goo.gl/jM6bs37qcszLSCxR9",
        "Chatrapati Sambhaji road": "https://maps.app.goo.gl/fQCPvQr7JukNvBE69",
        "Deshmukh road": "https://maps.app.goo.gl/yvBtYUe6a2GyXeBWA",
        "Vadagav main road": "https://maps.app.goo.gl/JUGECqxvgKQmMPhs5",
        "Ambedkar road": "https://maps.app.goo.gl/nLsWuL28TGMvEshr8",
        "Tashildar galli": "https://maps.app.goo.gl/CUDJq5brvridU1Dq5",
        "Hutatma chow": "https://maps.app.goo.gl/CYd3bHsyEbLwsZLy6",
        "Pai resort": "https://maps.app.goo.gl/V5wNs2sjQMtPkvQo6",
        "Anjaneya nagar": "https://maps.app.goo.gl/mw7uEgb3J489YiWP9",
        "Railway station Wall socket": "https://maps.app.goo.gl/qwxbakSkJgNbXT4S6",
        "Farfield by Marriott kakti": "https://maps.app.goo.gl/mjxngWDDk5yzGUuu5"
      };

      if (locationLinks[selectedLocation]) {
        window.open(locationLinks[selectedLocation], "_blank");
      } else if (selectedLocation === "") {
        alert("Please select a dealer location.");
      } else {
        alert(`Location for dealer "${selectedLocation}" not found.`);
      }
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
