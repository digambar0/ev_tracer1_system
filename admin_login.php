<?php
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Simple hardcoded admin check
    if ($username === 'evchargingtracer' && $password === '02fe23bca003') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid admin username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login - EV System</title>
  <link rel="stylesheet" href="style.css" />
  <style>
     body {
        background-image: url('ev.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: "Times New Roman", Times, serif !important;
        color: white;  /* adjust text color if needed */
    }
    .login-container {
      background: #1e1e1e;
      margin-top: 150px;
      padding: 30px;
      border-radius: 8px;
      width: 320px;
      box-shadow: 0 0 10px #00ffff;
      text-align: center;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0 20px 0;
      border: none;
      border-radius: 4px;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #00ffff;
      border: none;
      border-radius: 4px;
      font-size: 18px;
      color: #121212;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #00cccc;
    }
    .error {
      background: #ff4444;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 15px;
      font-weight: bold;
    }
    a.back-link {
      color: #00ffff;
      text-decoration: none;
      font-size: 14px;
      display: block;
      margin-top: 20px;
    }
    a.back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required autocomplete="off" />
      <input type="password" name="password" placeholder="Password" required autocomplete="off" />
      <button type="submit">Login</button>
    </form>

    <a class="back-link" href="loginform.php">Back to User Login</a>
  </div>

</body>
</html>
