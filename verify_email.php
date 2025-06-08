<?php
session_start();
require 'db.php'; 

$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format. <a href='forgot_password.php'>Try again</a>";
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit;
    } else {
        echo "Incorrect email ID. <a href='forgot_password.php'>Try again</a>";
    }
} catch (PDOException $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
