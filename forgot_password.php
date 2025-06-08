<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="thunderbolt"></div>
  <div class="background"></div>

  <div class="container">
    <h2>Forgot Password</h2>
    <form action="verify_email.php" method="POST">
      <div class="form-group">
        <label for="email">Enter your registered email</label>
        <input type="email" name="email" id="email" placeholder="you@example.com" required />
      </div>
      <button type="submit" class="electric-btn">Verify Email</button>
      <div class="forgot">
        <a href="loginform.php">Back to Login</a>
      </div>
    </form>
  </div>
 <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built with ❤️ for a cleaner future.</small>
    </div>
  </footer>
</body>
</html>
