<?php
session_start();

// Check if the user is logged in (assuming session contains 'user_id')
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Fetch the user_id from session
$user_id = $_SESSION['user_id'];

// Database connection
$conn = new mysqli("localhost", "username", "password", "database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Output the user ID to confirm it's being set
error_log("User ID: " . $user_id);

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();

// Debugging: Output the result of the query
if ($user_result->num_rows == 0) {
    echo json_encode(['error' => 'User not found']);
    exit;
}

$user_data = $user_result->fetch_assoc();

// Debugging: Output the user data
error_log("User Data: " . print_r($user_data, true));

// Fetch user reservations
$reservation_query = "SELECT * FROM reservations WHERE user_id = ?";
$stmt = $conn->prepare($reservation_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reservation_result = $stmt->get_result();

// Debugging: Check if reservations are returned
$reservations = [];
while ($row = $reservation_result->fetch_assoc()) {
    $reservations[] = $row;
}

// Debugging: Output the reservations
error_log("Reservations: " . print_r($reservations, true));

// Prepare the response
$response = [
    'user' => $user_data,
    'reservations' => $reservations
];

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
