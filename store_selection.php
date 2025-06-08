<?php
require 'db.php'; 

// Get POST data safely
$vehicleType = $_POST['vehicle_type'] ?? '';
$vehicleModel = $_POST['vehicle_model'] ?? '';
$charge = isset($_POST['charge_percentage']) ? (int)$_POST['charge_percentage'] : 0;
$total = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0.0;

try {
    // Use a prepared statement with PDO
    $stmt = $pdo->prepare("INSERT INTO vehicle_selections (vehicle_type, vehicle_model, charge_percentage, total_amount) 
                           VALUES (:vehicle_type, :vehicle_model, :charge_percentage, :total_amount)");

    // Bind parameters to the statement
    $stmt->bindParam(':vehicle_type', $vehicleType);
    $stmt->bindParam(':vehicle_model', $vehicleModel);
    $stmt->bindParam(':charge_percentage', $charge, PDO::PARAM_INT);
    $stmt->bindParam(':total_amount', $total, PDO::PARAM_STR); 

    // Execute and redirect
    if ($stmt->execute()) {
        header("Location: timeSlot.php");
        exit(); 
    } else {
        echo "Error: " . $stmt->errorInfo()[2]; 
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage(); 
}
?>
