<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: location.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Login - EV System</title>
  <style>
    /* General Styles (Your existing styles) */
    .error-message {
      background: linear-gradient(90deg, #00ffff, #00ffcc);
      color: white;
      border-left: 4px solid #5dade2;
      padding: 14px 18px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-weight: bold;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .error-message.hidden {
      opacity: 0;
      max-height: 0;
      padding: 0;
      border: none;
      margin: 0;
    }

    .error-message:hover {
      background: linear-gradient(90deg, #00ccff, #00ffff);
      box-shadow: 0 0 10px #00ffff;
    }

    .error-icon {
      font-size: 20px;
      color: #5dade2;
    }

    .error-text {
      display: flex;
      flex-direction: column;
    }

    .error-subtext {
      font-size: 0.85em;
      color: white;
      margin-top: 2px;
    }

    /* Add this section to make the page responsive */
    /* Mobile Devices */
    @media (max-width: 767px) {
      body {
        font-size: 14px; /* Adjusting base font size for mobile */
      }

      .container {
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
      }

      h2 {
        font-size: 24px; /* Adjust heading size for smaller screens */
      }

      .form-group {
        margin-bottom: 15px;
      }

      .form-group label {
        font-size: 14px; /* Smaller label font size */
      }

      .form-group input {
        width: 100%; /* Ensure input fields are full width */
        padding: 12px;
      }

      .electric-btn {
        width: 100%; /* Make the button full-width */
        padding: 15px;
        font-size: 16px;
      }

      .forgot {
        text-align: center;
      }

      .forgot a {
        display: block;
        margin-top: 10px;
      }

      footer .container {
        padding: 10px;
      }
    }

    /* Tablets and small screens (up to 1024px) */
    @media (max-width: 1024px) {
      .container {
        width: 80%;
      }

      h2 {
        font-size: 28px;
      }

      .electric-btn {
        padding: 14px;
      }

      footer .container {
        padding: 15px;
      }
    }

    /* Larger Screens (Desktops) */
    @media (min-width: 1025px) {
      .container {
        width: 50%;
        margin: 0 auto;
      }

      h2 {
        font-size: 32px;
      }

      .electric-btn {
        padding: 16px;
      }

      footer .container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="thunderbolt"></div>
  <div class="background"></div>

  <div class="main-content"> 
    <div class="container">
      <h2>Login to Your Account</h2>

      <?php if (!empty($error)): ?>
        <div id="errorBox" class="error-message">
          <span class="error-icon">ℹ️</span>
          <span><?php echo htmlspecialchars($error); ?></span>
        </div>
      <?php endif; ?>

      <form action="" method="POST" autocomplete="off">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
        </div>
        <button type="submit" class="electric-btn">Login ⚡</button>
       <div class="forgot d-flex justify-content-between align-items-center" style="gap:10px;">
              <a href="forgot_password.php">Forgot Password?</a>
              <a href="admin_login.php" class="admin-btn-link">Admin Login</a>
        </div>
        <div class="forgot">
              <a href="signupform.php">Don't have an account? Sign up</a>
        </div>

      </form>
    </div>
  </div>

  <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built With ❤️ For A Cleaner Future.</small>
    </div>
  </footer>

  <script>
    setTimeout(() => {
      const errorBox = document.getElementById('errorBox');
      if (errorBox) {
        errorBox.classList.add('hidden');
      }
    }, 3000);
  </script>

</body>
</html>
