<?php
session_start();
require 'db.php';

// Simulating user_id — make sure it's set during login
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['payment_method'] ?? '';
    $details = $_POST['details'] ?? '';

    if ($method && $details && $user_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO payments (user_id, payment_method, details) VALUES (:user_id, :method, :details)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':method' => $method,
                ':details' => $details
            ]);

            $_SESSION['flash_message'] = "Slot booked successfully using $method.";
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = "Database Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['flash_message'] = "Error: Missing payment details or not logged in.";
    }

    header("Location: payment.php");
    exit;
}
?>
