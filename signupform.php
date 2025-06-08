<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css">
  <title>Sign Up - EV System</title>
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
  margin-top: 50px; /* Add this line to create space above the container */
}

</style>
<body>

  <div class="thunderbolt"></div>
  <div class="background"></div>

  <div class="container">
    <h2>Create Your Account</h2>
    <form action="signup.php" method="POST" autocomplete="off">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required />
      </div>
      <button type="submit" class="electric-btn">Sign Up ⚡</button>
      <div class="forgot">
      <a href="loginform.php">Already have an account? Login</a>
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
