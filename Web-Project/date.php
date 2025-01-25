<?php
include('db.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pick_up_date = $_POST['pick_up_date'];
        $return_date = $_POST['return_date'];
        $customer_id = $_SESSION['customer_id'];



        $sql = "INSERT INTO reservation (booking_date, pickup_date, return_date, customer_id) 
                VALUES (CURDATE(), :pick_up_date, :return_date, :customer_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pick_up_date', $pick_up_date);
        $stmt->bindParam(':return_date', $return_date);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();

        $reservation_id = $pdo->lastInsertId();

        $_SESSION['reservation_id'] = $reservation_id;

        header('Location: SR.html');
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
