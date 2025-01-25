<?php
session_start(); // Start the session

// Database connection (adjust these variables to match your setup)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Error: You must be logged in to cancel a reservation.");
}

$customer_id = $_SESSION['customer_id']; // Retrieve the customer ID from the session

// Get the reservation associated with the customer
$sql_reservation = "SELECT id FROM reservation WHERE customer_id = ?";
$stmt_reservation = $conn->prepare($sql_reservation);
$stmt_reservation->bind_param("i", $customer_id);
$stmt_reservation->execute();
$result_reservation = $stmt_reservation->get_result();

if ($result_reservation->num_rows > 0) {
    $reservation = $result_reservation->fetch_assoc();
    $reservation_id = $reservation['id'];

    // Find the vehicle associated with this reservation
    $sql_vehicle = "SELECT id FROM vehicle WHERE reservation_id = ?";
    $stmt_vehicle = $conn->prepare($sql_vehicle);
    $stmt_vehicle->bind_param("i", $reservation_id);
    $stmt_vehicle->execute();
    $result_vehicle = $stmt_vehicle->get_result();

    if ($result_vehicle->num_rows > 0) {
        $vehicle = $result_vehicle->fetch_assoc();
        $vehicle_id = $vehicle['id'];

        // Update the vehicle's status and reservation_id
        $sql_update = "UPDATE vehicle SET status = 'available', reservation_id = NULL WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $vehicle_id);

        if ($stmt_update->execute()) {
            echo "Reservation canceled successfully! The vehicle is now available.";
        } else {
            echo "Error updating vehicle: " . $conn->error;
        }
    } else {
        echo "No vehicle found for this reservation.";
    }
} else {
    echo "No reservation found for this customer.";
}

// Close the connection
$conn->close();
?>
