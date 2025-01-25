<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Ensure password is at least 8 characters
    if (strlen($new_password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.history.back();</script>";
        exit();
    }

    try {
        // Fetch the user with the provided email
        $sql = "SELECT * FROM customer WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $sql = "UPDATE customer SET password = :password WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                echo "<script>alert('Password reset successful!'); window.location.href = 'html_1.html';</script>";
            } else {
                echo "<script>alert('Failed to update password. Please try again later.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Email not found. Please check and try again.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
