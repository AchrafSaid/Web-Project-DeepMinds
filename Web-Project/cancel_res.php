<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id'];
    $reservation_id = $_SESSION['reservation_id'];

    try {
        $sql = "DELETE FROM reservation WHERE id = :reservation_id AND customer_id = :customer_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

            unset($_SESSION['reservation_id']);
            echo "<script>alert('Reservation cancelled successfully.'); window.location.href = 'Shark.html';</script>";

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
