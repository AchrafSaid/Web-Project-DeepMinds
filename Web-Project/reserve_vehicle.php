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
    die("Error: You must be logged in to make a reservation.");
}

$customer_id = $_SESSION['customer_id']; // Retrieve the customer ID from the session
$vehicle_id = $_POST['vehicle_id']; // Get the vehicle ID from the form

// Check if the vehicle is available
$sql_check = "SELECT status FROM vehicle WHERE id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $vehicle_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $row = $result_check->fetch_assoc();

    if ($row['status'] === 'available') {
        // Fetch the reservation ID where customer_id matches
        $sql_reservation = "SELECT id FROM reservation WHERE customer_id = ?";
        $stmt_reservation = $conn->prepare($sql_reservation);
        $stmt_reservation->bind_param("i", $customer_id);
        $stmt_reservation->execute();
        $result_reservation = $stmt_reservation->get_result();

        if ($result_reservation->num_rows > 0) {
            $reservation = $result_reservation->fetch_assoc();
            $reservation_id = $reservation['id'];

            // Update the vehicle with the reservation ID and change status to 'non-available'
            $sql_update = "UPDATE vehicle SET reservation_id = ?, status = 'non-available' WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $reservation_id, $vehicle_id);

            if ($stmt_update->execute()) {
                echo "Reservation successful! Vehicle status updated to 'non-available'.";
            } else {
                echo "Error updating vehicle: " . $conn->error;
            }
        } else {
            echo "No reservation found for this customer.";
        }
    } else {
        echo "Error: Vehicle is not available for reservation.";
    }
} else {
    echo "Error: Vehicle not found.";
}

// Close the connection
$conn->close();
?>
