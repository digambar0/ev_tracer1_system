<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css">
  <title>Vehicle Selector</title>
  <style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color:rgba(255, 255, 255, 0.1);
  }

  .vehicle-dealer-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    padding: 20px;
  }

  .vehicle-selector,
  .charge-section {
    background-color:rgba(255, 255, 255, 0.1);
    box-shadow:  rgba(0, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow:  rgba(0, 255, 255, 0.2);
    width: 100%;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .vehicle-type-options {
    display: flex;
    gap: 30px;
    margin-bottom: 20px;
  }

  .radio-container {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #fff;
  }

  .sub-options {
    display: none;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
    color: #fff;
  }

  .sub-options.active {
    display: flex;
  }

  .sub-options label {
    display: block;
    margin: 5px 0;
  }

  .sub-options .options-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .selected-option {
    margin-top: 20px;
    font-size: 1.2em;
    font-weight: bold;
    color: #fff;
  }

  .charge-section input[type="number"] {
    margin-top: 10px;
    padding: 10px;
    font-size: 1em;
    width: 200px;
    border-radius: 5px;
    border: none;
  }
  

  .charge-section button {
    padding: 10px 20px;
    border-radius: 8px;
    background: linear-gradient(90deg, #00ffff, #00ffcc);
    color: #000;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background 0.3s ease, box-shadow 0.3s ease;
  }

  .charge-section button:hover {
     background: linear-gradient(90deg, #00ccff, #00ffff);
    box-shadow: 0 0 10px #00ffff;
  }

  .total-amount {
    font-size: 1.5em;
    color: #fff;
    font-weight: bold;
    margin-top: 20px;
  }

  h2, h3 {
    color: #ecf0f1;
  }
</style>
</head>

<body>
  <div class="background"></div>
  <div class="thunderbolt"></div>

  <div class="vehicle-dealer-wrapper">
    <!-- Vehicle Selection Section -->
    <div class="vehicle-selector">
      <h2>Select Your Vehicle Type</h2>

      <div class="vehicle-type-options">
        <label class="radio-container">
          <input type="radio" name="vehicle" value="two-wheeler" onclick="showOptions('two')">
          <span class="radio-label">Two Wheeler</span>
        </label>

        <label class="radio-container">
          <input type="radio" name="vehicle" value="four-wheeler" onclick="showOptions('four')">
          <span class="radio-label">Four Wheeler</span>
        </label>
      </div>

      <!-- Two Wheeler Options -->
      <div id="two-options" class="sub-options">
        <div class="options-group">
          <label><input type="radio" name="tw-option" value="Scooter" onclick="updateSelection('Two Wheeler', 'Ola Electric')">Ola Electric</label>
          <label><input type="radio" name="tw-option" value="Bike" onclick="updateSelection('Two Wheeler', 'Ather Energy')">Ather Energy</label>
          <label><input type="radio" name="tw-option" value="Moped" onclick="updateSelection('Two Wheeler', 'Tork Motors')">Tork Motors</label>
          <label><input type="radio" name="tw-option" value="Electric Bike" onclick="updateSelection('Two Wheeler', 'Revolt Motors')">Revolt Motors</label>
          <!-- <label><input type="radio" name="tw-option" value="Sport Bike" onclick="updateSelection('Two Wheeler', 'Ultraviolet Automotive')"> Sport Bike</label> -->
        </div>
      </div>

      <!-- Four Wheeler Options -->
      <div id="four-options" class="sub-options">
        <div class="options-group">
          <label><input type="radio" name="fw-option" value="Sedan" onclick="updateSelection('Four Wheeler', 'Mahindra XEV 9e')">Mahindra XEV 9e</label>
          <label><input type="radio" name="fw-option" value="SUV" onclick="updateSelection('Four Wheeler', 'Tata Curvv EV')">Tata Curvv EV</label>
          <label><input type="radio" name="fw-option" value="Hatchback" onclick="updateSelection('Four Wheeler', 'MG Comet EV')">MG Comet EV</label>
          <label><input type="radio" name="fw-option" value="Convertible" onclick="updateSelection('Four Wheeler', 'Tata Punch EV')">Tata Punch EV</label>
          <label><input type="radio" name="fw-option" value="Truck" onclick="updateSelection('Four Wheeler', 'BYD Atto')">BYD Atto</label>
        </div>
      </div>

      <!-- Display selected option -->
      <div class="selected-option" id="selected-option">
        Please select a vehicle type and model.
      </div>
    </div>

    <!-- Charge & Form Submission Section -->
    <div class="charge-section">
      <form action="store_selection.php" method="POST" onsubmit="return prepareFormData()">
        <h3>Enter Percentage Charge</h3>
        <input type="number" id="charge-input" placeholder="Enter percentage charge" max="100" />
        <div id="charge-error" class="error-message"></div>


        <div class="total-amount" id="total-amount">Total Amount: 0 Rs</div>

        <!-- Hidden Fields -->
        <input type="hidden" name="vehicle_type" id="vehicle_type">
        <input type="hidden" name="vehicle_model" id="vehicle_model">
        <input type="hidden" name="charge_percentage" id="hidden_charge">
        <input type="hidden" name="total_amount" id="hidden_total">

        <button type="button" onclick="calculateTotal()">Calculate Total</button>
        <button type="submit">Select Ur Time</button>
      </form>
    </div>
  </div>

  <script>
    let vehicleType = '';
    let selectedModel = '';

    function showOptions(type) {
      document.getElementById('two-options').classList.remove('active');
      document.getElementById('four-options').classList.remove('active');

      if (type === 'two') {
        document.getElementById('two-options').classList.add('active');
        vehicleType = 'Two Wheeler';
      } else {
        document.getElementById('four-options').classList.add('active');
        vehicleType = 'Four Wheeler';
      }
    }

    function updateSelection(vehicle, model) {
      const selection = `${vehicle}: ${model}`;
      document.getElementById('selected-option').textContent = `Selected: ${selection}`;
      selectedModel = model;
      document.getElementById('vehicle_type').value = vehicle;
      document.getElementById('vehicle_model').value = model;
      hideOptions(vehicle);
    }

    function hideOptions(vehicle) {
      const optionsDiv = vehicle === 'Two Wheeler' ? document.getElementById('two-options') : document.getElementById('four-options');
      optionsDiv.style.display = 'none';
    }

        function calculateTotal() {
      const chargeInput = document.getElementById('charge-input');
      const chargePercentage = parseFloat(chargeInput.value);
      const errorDiv = document.getElementById('charge-error');

      if (isNaN(chargePercentage) || chargePercentage < 1 || chargePercentage > 100) {
        errorDiv.textContent = "Invalid Entry(1-100 Only)";
        document.getElementById('total-amount').textContent = `Total Amount: 0 Rs`;
        document.getElementById('hidden_charge').value = '';
        document.getElementById('hidden_total').value = '';
        return;
      }

      errorDiv.textContent = ""; // Clear previous error message

      let baseAmount = 0;
      if (vehicleType === 'Two Wheeler') {
        baseAmount = chargePercentage * 1;
      } else if (vehicleType === 'Four Wheeler') {
        baseAmount = chargePercentage * 3;
      }

      document.getElementById('total-amount').textContent = `Total Amount: ${baseAmount.toFixed(2)} Rs`;
      document.getElementById('hidden_charge').value = chargePercentage;
      document.getElementById('hidden_total').value = baseAmount.toFixed(2);
    }


    function prepareFormData() {
      calculateTotal();
      return true;
    }
  </script>
  <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built With ❤️ For A Cleaner Future.</small>
    </div>
  </footer>

</body>
</html>
