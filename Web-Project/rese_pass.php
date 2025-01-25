<?php
session_start();
include('db.php'); // Include the database connection

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id']; // Use customer ID from session
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    try {
        // Fetch the user's current password from the database
        $query = $pdo->prepare("SELECT password FROM customer WHERE id = :id");
        $query->execute(['id' => $customer_id]);
        $user = $query->fetch();

        // Check if the old password matches
        if ($user && password_verify($oldPassword, $user['password'])) {
            // Hash the new password and update in the database
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = $pdo->prepare("UPDATE customer SET password = :new_password WHERE id = :id");
            $updateQuery->execute(['new_password' => $hashedNewPassword, 'id' => $customer_id]);

            echo "<script>alert('Password updated successfully!'); window.location.href = 'manage_account.php';</script>";
        } else {
            echo "<script>alert('Old password is incorrect.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
