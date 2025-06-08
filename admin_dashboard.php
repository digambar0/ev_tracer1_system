<?php
$mysqli = new mysqli("localhost", "root", "", "ev_system");

// Handle Dealer Deletion
if (isset($_GET['delete_dealer'])) {
    $id = intval($_GET['delete_dealer']);
    $mysqli->query("DELETE FROM dealer_selections WHERE id = $id");
    header("Location: admindashboard.php#dealers");
    exit();
}

// Handle Dealer Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_dealer'])) {
    $id = intval($_POST['dealer_id']);
    $location = $_POST['location'];
    $mysqli->query("UPDATE dealer_selections SET location='$location' WHERE id=$id");
    header("Location: admindashboard.php#dealers");
    exit();
}

// Handle Dealer Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_dealer'])) {
    $location = $_POST['location'];
    $mysqli->query("INSERT INTO dealer_selections (location) VALUES ('$location')");
    header("Location: admindashboard.php#dealers");
    exit();
}

// Fetch Data
$users = $mysqli->query("SELECT * FROM users");
$dealers = $mysqli->query("SELECT * FROM dealer_selections");
$feedbacks = $mysqli->query("
  SELECT ev_feedback.*, users.username 
  FROM ev_feedback
  JOIN users ON ev_feedback.user_id = users.id
  ORDER BY ev_feedback.submitted_at DESC
");
$vehicles = $mysqli->query("SELECT * FROM vehicle_selections");
$times = $mysqli->query("SELECT * FROM time_selections");
$payments = $mysqli->query("SELECT * FROM payments");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - EV System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
    .star {
        color: gold;
        font-size: 1.2rem;
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="d-flex ms-auto">
      <a href="index.php" class="btn btn-outline-light">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Admin Dashboard - EV System</h2>

  <ul class="nav nav-tabs" id="adminTabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#dealers">Location Selections</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#feedback">Feedback</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#users">Users</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#vehicles">Vehicles</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#times">Time Selections</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payments">Payments</a></li>
  </ul>

  <div class="tab-content mt-4">
    <!-- Dealers Tab -->
    <div class="tab-pane fade show active" id="dealers">
        <h4>Location Selections</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Location</th>
                <th>Selected At</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($dealer = $dealers->fetch_assoc()): ?>
                <tr>
                <td><?= $dealer['id'] ?></td>
                <td><?= htmlspecialchars($dealer['location']) ?></td>
                <td><?= $dealer['selected_at'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Feedback Tab -->
    <div class="tab-pane fade" id="feedback">
      <h4>User Feedback</h4>
      <?php while ($fb = $feedbacks->fetch_assoc()): ?>
        <div class="card mb-3 p-3 w-100">
          <small class="text-muted">
            <i class="bi bi-person-circle"></i>
            <strong><?= htmlspecialchars($fb['username']) ?></strong>
          </small>
          <div>
            <?php for ($i = 0; $i < $fb['rating']; $i++): ?>
              <span class="star">&#9733;</span>
            <?php endfor; ?>
            <?php for ($i = $fb['rating']; $i < 5; $i++): ?>
              <span class="star text-secondary">&#9733;</span>
            <?php endfor; ?>
          </div>
          <p><?= nl2br(htmlspecialchars($fb['feedback'])) ?></p>
          <?php if ($fb['features']): ?>
            <p><strong>Features:</strong> <?= htmlspecialchars($fb['features']) ?></p>
          <?php endif; ?>
          <small class="text-muted">Submitted at: <?= $fb['submitted_at'] ?></small>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Users Tab -->
    <div class="tab-pane fade" id="users">
      <h4>Registered Users</h4>
      <table class="table table-striped table-bordered">
        <thead><tr><th>ID</th><th>Email</th><th>Username</th></tr></thead>
        <tbody>
          <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= $user['email'] ?></td>
              <td><?= $user['username'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Vehicles Tab -->
    <div class="tab-pane fade" id="vehicles">
      <h4>Vehicle Selections</h4>
      <table class="table table-striped table-bordered">
        <thead><tr><th>ID</th><th>Type</th><th>Model</th><th>Charge %</th><th>Total</th></tr></thead>
        <tbody>
          <?php while ($veh = $vehicles->fetch_assoc()): ?>
            <tr>
              <td><?= $veh['id'] ?></td>
              <td><?= $veh['vehicle_type'] ?></td>
              <td><?= $veh['vehicle_model'] ?></td>
              <td><?= $veh['charge_percentage'] ?>%</td>
              <td>₹<?= $veh['total_amount'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Time Selections Tab -->
    <div class="tab-pane fade" id="times">
      <h4>Time Selections</h4>
      <table class="table table-striped table-bordered">
        <thead><tr><th>ID</th><th>Start Time</th><th>End Time</th></tr></thead>
        <tbody>
          <?php while ($time = $times->fetch_assoc()): ?>
            <tr>
              <td><?= $time['id'] ?></td>
              <td><?= $time['start_time'] ?></td>
              <td><?= $time['end_time'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Payments Tab -->
    <div class="tab-pane fade" id="payments">
      <h4>Payments</h4>
      <table class="table table-striped table-bordered">
        <thead><tr><th>ID</th><th>User ID</th><th>Method</th><th>Details</th><th>Date</th></tr></thead>
        <tbody>
          <?php while ($pay = $payments->fetch_assoc()): ?>
            <tr>
              <td><?= $pay['id'] ?></td>
              <td><?= $pay['user_id'] ?></td>
              <td><?= $pay['payment_method'] ?></td>
              <td><?= $pay['details'] ?></td>
              <td><?= $pay['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
