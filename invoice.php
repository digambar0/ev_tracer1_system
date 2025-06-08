<?php
$host = 'localhost';
$db = 'ev_system';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$user = $pdo->query("SELECT * FROM users ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$dealer = $pdo->query("SELECT * FROM dealer_selections ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$time = $pdo->query("SELECT * FROM time_selections ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$vehicle = $pdo->query("SELECT * FROM vehicle_selections ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$payment = null;
if ($user) {
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$user['id']]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EV Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    background-color: #eef2f5;
    font-family: 'Times New Roman', Times, serif;
    font-size: 14px;
}
  .full-width-line {
        border: 0;
        border-top: 5px solid #000; 
        width: 100%; 
        margin: 20px 0; 
  }



  .invoice-box {
  background-color: #ffffff;
  padding: 25px;
  margin: 30px auto;
  /* border-radius: 12px; */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  max-width: 800px;
}


 .section-title {
    font-family: 'Times New Roman', Times, serif;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
 }



  .table th, .table td {
    vertical-align: middle;
  }

  .seal-img {
    max-width: 160px;
    width: 100%;
    opacity: 1;
    margin-top: 10px;
  }

  .print-grayscale {
    transition: all 0.3s ease-in-out;
  }

  /* ✅ PRINT SETTINGS TO FIT ON ONE PAGE */
  @media print {
    body {
      background-color: white;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      margin: 0;
      padding: 0;
      font-size: 12px;
      zoom: 90%;
    }

    .no-print {
      display: none !important;
    }

    .invoice-box {
      box-shadow: none;
      margin: 0;
      padding: 10px;
      width: 100%;
      page-break-inside: avoid;
    }

    .invoice-box * {
      page-break-inside: avoid !important;
    }

    table, tr, td, th {
      page-break-inside: avoid !important;
    }

    /* ✅ Apply grayscale to specific images */
    .print-grayscale {
      filter: grayscale(100%) !important;
    }
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .invoice-box {
      padding: 15px;
    }

    .d-flex {
      flex-direction: column;
      align-items: center;
    }

    .d-flex img {
      margin-bottom: 10px;
      max-height: 60px;
    }

    .section-title {
      font-size: 1.2rem;
    }

    .table th, .table td {
      font-size: 12px;
    }
  }

  @media (max-width: 576px) {
    .invoice-box {
      padding: 10px;
    }

    .d-flex img {
      max-height: 50px;
    }

    .d-flex h4 {
      font-size: 1.4rem;
    }

    .d-flex p {
      font-size: 0.9rem;
    }
  }
</style>


</head>
<body>

<div class="container">
  <div class="invoice-box">
    <!-- Print Button -->
    <div class="text-end mb-3 no-print">
      <button class="btn btn-primary" onclick="window.print()">🖨️ Print Invoice</button>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex flex-column align-items-center">
        <!-- Logo Image -->
          <img src="logo.jpg" alt="EV Logo" class="print-grayscale" style="width: 250px; height: 120px; display: block; border-radius: 12px; margin-top: -10px;">
        <!-- Heading -->
        <h4 class="fw-bold mb-1" style="font-size: 1.6rem;">EV-Charging Tracer</h4>
        <!-- <p class="text-muted mb-0">Date: <?= date("Y-m-d") ?></p> -->
      </div>

      <!-- INVOICE Text -->
      <div>
        <h1 class="fw-bold text-uppercase mb-0">INVOICE</h1>
      </div>
    </div>
    <hr class="full-width-line">


    <!-- Customer Details -->
    <div class="row mb-3">
      <div class="col-md-6">
        <h6 class="section-title">Customer Information</h6>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      </div>
    </div>

    <!-- Dealer Information -->
    <div class="row mb-3">
      <div class="col-md-6">
        <h6 class="section-title">Dealer Location</h6>
        <p><strong>Location:</strong> <?= htmlspecialchars($dealer['location']) ?></p>
        <p><strong>Selected At:</strong> <?= $dealer['selected_at'] ?></p>
      </div>
    </div>

    <!-- Charging Slot Info -->
    <div class="row mb-3">
      <div class="col-md-6">
        <h6 class="section-title">Charging Slot</h6>
        <p><strong>Start:</strong> <?= $time['start_time'] ?></p>
        <p><strong>End:</strong> <?= $time['end_time'] ?></p>
      </div>
    </div>

    <!-- Vehicle Details Table -->
    <div class="mb-3">
      <h6 class="section-title">Vehicle Details</h6>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="table-light">
            <tr>
              <th>Vehicle Type</th>
              <th>Model</th>
              <th>Charge %</th>
              <th>Amount (Rs)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= htmlspecialchars($vehicle['vehicle_type']) ?></td>
              <td><?= htmlspecialchars($vehicle['vehicle_model']) ?></td>
              <td><?= $vehicle['charge_percentage'] ?>%</td>
              <td><?= number_format($vehicle['total_amount'], 2) ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Payment Info + Seal + Total -->
    <?php if ($payment): ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <h6 class="section-title">Payment Information</h6>
        <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment['payment_method']) ?></p>
        <p><strong>Details:</strong> <?= htmlspecialchars($payment['details']) ?></p>
        <p><strong>Payment Time:</strong> <?= $payment['created_at'] ?></p>
        <p><strong>Payment Status:</strong> Paid</p>
      </div>
      <div class="col-md-6 text-md-end text-center">
          <img src="paidlogo.png" alt="Paid Seal" class="img-fluid seal-img print-grayscale">      </div>
    </div>
        <div class="row mb-2">
          <div class="col text-end">
            <div class="border border-dark rounded p-2 d-inline-block">
            <h5 class="mb-0" style="color: black;">Total: <?= number_format($vehicle['total_amount'], 2) ?> Rs</h>
          </div>
    </div>
</div>

    </div>

    <?php endif; ?>

    <!-- Footer -->
    <div class="text-center mt-3">
      <small class="text-muted">&copy; <?= date("Y") ?> EV System — Clean energy for a better tomorrow.</small>
    </div>
  </div>
</div>

</body>
</html>
