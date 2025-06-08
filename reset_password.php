<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="thunderbolt"></div>
  <div class="background"></div>

  <div class="container">
    <h2>Reset Password</h2>
    <form action="update_password.php" method="POST">
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required />
      </div>
      <button type="submit" class="electric-btn">Reset Password</button>
      <div class="forgot">
        <a href="loginform.php">Back to Login</a>
      </div>
    </form>
  </div>
 <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built With ❤️ For A Cleaner Future.</small>
    </div>
  </footer>
</body>
</html>
