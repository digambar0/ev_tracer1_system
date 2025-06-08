<?php
session_start(); // Only once at the top

$user_id = $_SESSION['user_id'] ?? null;

// Database connection using PDO
$host = 'localhost';
$db   = 'ev_system';
$user = 'root'; 
$pass = '';     
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $features = $_POST['features'] ?? [];
    $feedback = $_POST['feedback'] ?? '';

    // Convert features array to comma-separated string
    $features_str = implode(", ", $features);

    if ($rating > 0 && !empty($feedback) && $user_id) {
        $stmt = $pdo->prepare("INSERT INTO ev_feedback (rating, features, feedback, user_id) VALUES (:rating, :features, :feedback, :user_id)");
        $stmt->execute([
            ':rating' => $rating,
            ':features' => $features_str,
            ':feedback' => $feedback,
            ':user_id' => $user_id
        ]);

        echo "<script>alert('Thanks for your feedback!'); window.location.href=window.location.href;</script>";
        exit();
    } elseif (!$user_id) {
        echo "<script>alert('Please log in to submit feedback.');</script>";
    }
}

// Fetch all feedback entries
$stmt = $pdo->query("
  SELECT f.*, u.username 
  FROM ev_feedback f 
  JOIN users u ON f.user_id = u.id 
  ORDER BY f.submitted_at DESC
");

$feedbacks = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EV Charging Tracker Feedback</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #101820;
      color:rgb(255, 255, 255);
      margin: 0;
      padding: 20px;
    }
    h2 {
      color: #00ffcc;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
    }
    .rating-section,
    .feedback-section,
    .features-section {
      margin-top: 30px;
      background-color: #1b1b2f;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px #00ffcc33;
    }
    .stars {
      font-size: 2rem;
      color: #555;
      cursor: pointer;
    }
    .stars .selected {
      color: #00ffcc;
    }
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 15px;
      border-radius: 10px;
      border: none;
      resize: vertical;
      font-size: 1rem;
    }
    label {
      display: block;
      margin: 15px 0 5px;
    }
    .checkbox-group label {
      margin-right: 15px;
      display: inline-block;
      cursor: pointer;
    }
    input[type="checkbox"] {
      margin-right: 5px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #00ffcc;
      color: #101820;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #00d9b3;
    }
    .feedback-list {
        margin-top: 50px;
        width: 100%;
        padding: 0 20px;
        box-sizing: border-box;
        }

    .feedback-item {
        background-color: #1b1b2f;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 0 8px #00ffcc33;
        margin-bottom: 20px;
        color: #00ffcc;
        width: 100%;
        box-sizing: border-box;
    }

    .feedback-item p {
      margin: 5px 0;
      color: #fff;
    }
    .feedback-header {
      font-weight: bold;
      margin-bottom: 10px;
      color: #00ffcc;
    }
  </style>
</head>
<body>
    <div class="container">
      <h2>Give Feedback on EV Charging Tracker</h2>

      <form method="post" action="">
        <div class="rating-section">
          <h3>Rate your experience</h3>
          <div class="stars" id="rating-stars">
            <span data-value="1">&#9733;</span>
            <span data-value="2">&#9733;</span>
            <span data-value="3">&#9733;</span>
            <span data-value="4">&#9733;</span>
            <span data-value="5">&#9733;</span>
          </div>
          <input type="hidden" name="rating" id="rating-value" required>
        </div>

        <div class="features-section">
          <h3>What did you like?</h3>
          <div class="checkbox-group">
            <label><input type="checkbox" name="features[]" value="Fast Charging Speed"> Fast Charging Speed</label>
            <label><input type="checkbox" name="features[]" value="Accurate Station Location"> Accurate Station Location</label>
            <label><input type="checkbox" name="features[]" value="Easy to Use Interface"> Easy to Use Interface</label>
            <label><input type="checkbox" name="features[]" value="Real-time Availability"> Real-time Availability</label>
          </div>
        </div>

        <div class="feedback-section">
          <h3>Write your feedback</h3>
          <textarea rows="4" name="feedback" placeholder="Tell us more about your experience..." required></textarea>
          
          <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit">Submit</button>
            <button type="submit"><a href="payment.php">Back</a></button>
          </div>
        </div>
      </form>
    </div>


  <div class="feedback-list">
    <!-- <h2>All Feedback</h2> -->
    <?php if (!empty($feedbacks)): ?>
      <?php foreach ($feedbacks as $row): ?>
        <div class="feedback-item">
          <h4 style="color:#00ffcc; font-weight: normal; font-size: 1rem; margin-bottom: 8px;">Reviews</h4>
              <p style="margin: 0; color: #00cc99; display: flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#00cc99" width="18" height="18" viewBox="0 0 24 24">
                  <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.2c-3.3 0-9.9 1.7-9.9 5v2.7h19.8v-2.7c0-3.3-6.6-5-9.9-5z"/>
                </svg>
                <?= htmlspecialchars($row['username']) ?>
              </p>
          <div class="feedback-header">
            <?php
            $rating = (int)$row['rating'];
            for ($i = 1; $i <= 5; $i++) {
              echo '<span style="color:' . ($i <= $rating ? '#00ffcc' : '#555') . '; font-size:1.2rem;">&#9733;</span>';
            }
            ?>
          </div>
              <p style="display: flex; align-items: center; gap: 8px; color: #00cc99;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#00cc99" width="18" height="18" viewBox="0 0 24 24">
                  <path d="M20 6H4v12h16V6zm-8 7l-3-3 1.4-1.4L12 10.2l4.6-4.6L18 7l-6 6z"/>
                </svg>
                <strong>Features liked:</strong> <?= htmlspecialchars($row['features']) ?>
              </p>

              <p style="display: flex; align-items: center; gap: 8px; color: #00cc99;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#00cc99" width="18" height="18" viewBox="0 0 24 24">
                  <path d="M21 6h-2v9H5v2h14v-11zM5 3v2h14v11h2V5a2 2 0 0 0-2-2H5z"/>
                </svg>
                <strong>Feedback:</strong> <?= nl2br(htmlspecialchars($row['feedback'])) ?>
              </p>

              <p style="display: flex; align-items: center; gap: 8px; font-size:0.8rem; color:#888;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#888" width="16" height="16" viewBox="0 0 24 24">
                  <path d="M12 7a5 5 0 1 1-5 5 5 5 0 0 1 5-5zm0 12a9 9 0 1 0-9-9 9 9 0 0 0 9 9zM11 11h2v6h-2zM12 6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/>
                </svg>
                Submitted on: <?= htmlspecialchars($row['submitted_at']) ?>
              </p>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No feedback submitted yet.</p>
    <?php endif; ?>
  </div>

  <footer class="bg-gray-900 text-white text-center mt-5">
    <div class="container mx-auto px-4 py-4">
      <p class="text-sm sm:text-base mb-1">&copy; <?= date("Y"); ?> EV System. All rights reserved.</p>
      <small class="text-xs sm:text-sm">Built with ❤️ for a cleaner future.</small>
    </div>
  </footer>

  <script>
    const stars = document.querySelectorAll('#rating-stars span');
    const ratingValue = document.getElementById('rating-value');

    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        stars.forEach((s, i) => {
          s.classList.toggle('selected', i <= index);
        });
        ratingValue.value = index + 1;
      });
    });
  </script>
</body>
</html>
