<?php
session_start();
$message = '';

// Check for the flash message session variable
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="style.css"> -->
 <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
  }

  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #000;
    position: relative;
  }

  /* New header bar */
  header {
    width: 100%;
    background: rgba(0, 255, 255, 0.1);
    padding: 10px 20px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,255,255,0.2);
    backdrop-filter: blur(10px);
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .logout-button-header {
    padding: 10px 18px;
    font-size: 14px;
    color: #000;
    font-weight: bold;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    background: linear-gradient(90deg, #00ffff, #00ffcc);
    transition: background 0.3s ease, box-shadow 0.3s ease;
  }

  .logout-button-header:hover {
    background: linear-gradient(90deg, #00ccff, #00ffff);
    box-shadow: 0 0 10px #00ffff;
  }

  .wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 10px;
  }

  .background,
  .thunderbolt {
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    z-index: -2;
  }

  .thunderbolt {
    background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbf1yKH6neB6wtwkuGLxz524SKX7lKQMygdkqEneLEloDARC9BSV-fa1mM_oOF7wNg9jc&usqp=CAU') no-repeat center center;
    background-size: cover;
    opacity: 0.1;
    animation: thunderboltEffect 3s infinite;
    z-index: -1;
  }

  @keyframes thunderboltEffect {
    0%, 100% { opacity: 0.1; }
    50% { opacity: 0.3; }
  }

  .background {
    background: radial-gradient(circle, rgba(0, 255, 255, 0.2), rgba(0, 0, 0, 0.8));
    animation: waveBackground 5s ease-in-out infinite;
  }

  @keyframes waveBackground {
    0% { background-position: 0% 0%; }
    100% { background-position: 100% 100%; }
  }

  .container {
    max-width: 450px;
    width: 100%;
    background: rgba(255, 255, 255, 0.1);
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    color: #fff;
  }

  h2 {
    text-align: center;
    color: #00ffff;
    margin-bottom: 25px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  label {
    color: #aef;
    font-size: 14px;
    display: block;
    margin-bottom: 6px;
  }

  select, input[type="text"] {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    outline: none;
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff; 
  }

  select option {
    color: black; 
  }

  .button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
  }

  .button-group button {
    width: 48%;
    padding: 12px;
    color: #000;
    font-weight: bold;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    background: linear-gradient(90deg, #00ffff, #00ffcc);
    transition: background 0.3s ease, box-shadow 0.3s ease;
  }

  .button-group button:hover {
    background: linear-gradient(90deg, #00ccff, #00ffff);
    box-shadow: 0 0 10px #00ffff;
  }

  .flash-message {
    margin-bottom: 20px;
    text-align: center;
    padding: 10px;
    background: rgba(0, 255, 0, 0.1);
    color: #00ffcc;
    font-weight: bold;
    border: 1px solid #00ffcc;
    border-radius: 10px;
    box-shadow: 0 0 10px #00ffcc;
  }

  .thank-you {
    margin-top: 20px;
    text-align: center;
    color: #00ffcc;
    font-size: 18px;
    font-weight: bold;
  }

  .logout-container {
    width: 100%;
    display: flex;
    justify-content: center;
    margin: 40px 0 20px;
  }

  footer {
    background-color: #f8f9fa;
    padding: 20px 0;
    text-align: center;
    width: 100%;
    color: #000;
  }

  footer .container {
    max-width: 600px;
    margin: 0 auto;
  }

  /* Media Queries for responsiveness */
  @media (max-width: 768px) {
    .container {
      padding: 20px;
    }

    .button-group {
      flex-direction: column;
      align-items: center;
    }

    .button-group button {
      width: 100%;
      margin-bottom: 15px;
    }

    .flash-message {
      font-size: 14px;
    }

    .thank-you {
      font-size: 16px;
    }

    footer p {
      font-size: 14px;
    }
  }

  @media (max-width: 480px) {
    body {
      padding: 10px;
    }

    .wrapper {
      padding: 20px 10px;
    }

    h2 {
      font-size: 24px;
    }

    .form-group input,
    .form-group select {
      padding: 10px;
      font-size: 14px;
    }

    .thank-you {
      font-size: 14px;
    }

    footer p {
      font-size: 12px;
    }
  }
</style>

</head>
<body>

<header>
  <form method="post" action="logout.php" style="margin:0;">
    <button type="submit" class="logout-button-header">Logout</button>
  </form>
</header>

<div class="background"></div>
<div class="thunderbolt"></div>

<div class="wrapper">
  <div class="container">
    <h2>Choose Payment Method</h2>

    <?php if (!empty($message)): ?>
      <div class="flash-message" id="flash-message">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="process_payment.php">
      <div class="form-group">
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" required>
          <option value="">-- Select Payment Option --</option>
          <option value="upi">UPI</option>
          <option value="card">Credit/Debit Card</option>
          <option value="net_banking">Net Banking</option>
          <option value="wallet">Wallet (Paytm/PhonePe)</option>
          <option value="cod">Cash On Delivery</option>
        </select>
      </div>

      <div class="form-group">
        <label for="details">Payment Details</label>
        <input type="text" name="details" id="details" placeholder="e.g., abhay@upi or **** **** **** 1234" required>
      </div>

      <div class="button-group">
        <button type="submit">Confirm Slot</button>
        <button type="button" onclick="window.location.href='invoice.php'">Download Invoice</button>
      </div>
    </form>
  </div>

    <div class="thank-you">
      Thank you for using our services!
    </div>

    <div class="logout-container">
      <!-- <form method="get" action="feedback.php">
        <button type="submit" class="logout-button">Give Feedback</button>
      </form> -->
       <form method="post" action="feedback.php" style="margin:0;">
          <button type="submit" class="logout-button-header">Give Feedback</button>
       </form>
    </div>

</div>

<script>
  window.onload = function() {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
      setTimeout(() => {
        flashMessage.style.display = 'none';
      }, 5000);
    }
  };
</script>

<footer>
  <p>&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
  <small>Built With ❤️ For A Cleaner Future.</small>
</footer>

</body>
</html>
