<?php
include 'db.php';

$message = ''; 

if (isset($_POST['add_time'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    // Validate that start time is before end time
    if ($start >= $end) {
        $message = "Error: Start time must be earlier than end time.";
    } else {
        // Check if the selected time range is already booked
        $sql = "SELECT * FROM time_selections 
                WHERE (start_time BETWEEN :start AND :end) 
                   OR (end_time BETWEEN :start AND :end)";
        $stmt = $pdo->prepare($sql);
        // $stmt->execute([
        //     'start' => $start,
        //     'end' => $end
        // ]);

        if ($stmt->rowCount() > 0) {
            $message = "Error: The selected time range is already booked.";
        } else {
            $sql = "INSERT INTO time_selections (start_time, end_time) VALUES (:start_time, :end_time)";
            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute([
                'start_time' => $start,
                'end_time' => $end
            ]);
                if ($success) {
                    header("Location: timeslot.php");
                    exit();
                } else {
                    $errorInfo = $stmt->errorInfo();
                    $message = "Error: " . ($errorInfo[2] ?? "Unknown database error.");
                }

        }
    }
}
?>

<!-- Display the message -->
<div style="text-align: center; margin-top: 20px; color: red;">
    <?php if (!empty($message)) echo htmlspecialchars((string)$message); ?>
</div>
