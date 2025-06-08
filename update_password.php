<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Update</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="thunderbolt"></div>
  <div class="background"></div>

  <div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
        $newPassword = $_POST['new_password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];

        try {
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);
            session_unset();
            session_destroy();
            echo "<h2>✅ Password Updated!</h2>";
            echo "<p class='forgot'><a href='index.php'>Click here to login</a></p>";
        } catch (PDOException $e) {
            echo "<h2>❌ Error!</h2><p>Failed to update password.</p>";
        }
    } else {
        echo "<h2>❌ Invalid Request</h2>";
    }
    ?>
  </div>
   <footer class="text-center mt-5">
    <div class="container">
      <p class="mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small>Built With ❤️ For A Cleaner Future.</small>
    </div>
  </footer>

</body>
</html>
