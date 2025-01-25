<?php
session_start();
require 'db.php';

// Assuming user is logged in, retrieve customer info
$email = $_SESSION['email'] ?? null;
$customer_id = $_SESSION['customer_id'] ?? null;

if ($customer_id) {
    try {
        // Get user info
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE id = :id");
        $stmt->bindParam(':id', $customer_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get user reservations
        $stmt = $pdo->prepare("SELECT * FROM reservation WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Shark <span>Rental</span></div>
        <ul class="nav-links">
            <li><a href="html_1.html">Log out</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="shark.html">Make a Reservation</a></li>
            <li><a href="manage_account.php">Manage your Account</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?></h1>
        <div class="small">
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>State: <?php echo htmlspecialchars($user['state']); ?></p>
            <p>City: <?php echo htmlspecialchars($user['city']); ?></p>
            <p>house number: <?php echo htmlspecialchars($user['house_number']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Driving Licence: <?php echo htmlspecialchars($user['driving_licence']); ?></p>
        </div>

        <h2>Your Reservations</h2>
        <ul>
            <?php if ($reservations): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <li>
                        <p>Reservation ID: <?php echo htmlspecialchars($reservation['id']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($reservation['pickup_date']); ?></p>

                        <form method="POST" action="cancel_res.php">
                            <button type="submit">Cancel Reservation</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No reservations found.</li>
            <?php endif; ?>
        </ul>

        <h3>Reset Password</h3>
<form method="POST" action="rese_pass.php">
    <label for="old_password">Old Password:</label>
    <input type="password" name="old_password" id="old_password" required>
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>
    <button type="submit">Reset Password</button>
</form>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="about.html">About Us</a>
                <a href="contact.html">Contact Us</a>
            </div>
            <div class="contact-us">
                <h4>Contact Us</h4>
                <p>Email: <a href="mailto:support@sharkrental.com">support@sharkrental.com</a></p>
                <p>Phone: 01xxxxxxxxx</p>
            </div>
            <div class="social-media">
                <h4>Follow Us</h4>
                <a href="https://www.instagram.com/" target="_blank" class="social-icon instagram-icon">IG</a>
                <a href="https://www.facebook.com/" target="_blank" class="social-icon facebook-icon">FB</a>
                <a href="https://twitter.com/" target="_blank" class="social-icon twitter-icon">X</a>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2024 SharkRental. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
