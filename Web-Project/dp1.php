<?php
require "db.php"; // Include database connection

try {
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!<br>";

    // Array of vehicles
    $vehicles = [
        ['ABC123', 'Jeep Compass', 'available', 20000, 50, 'SUV'],
        ['DEF456', 'Land Rover Defender', 'available', 15000, 80, 'SUV'],
        ['GHI789', 'Toyota Land Cruiser', 'available', 30000, 70, 'SUV'],
        ['JKL101', 'Range Rover', 'available', 25000, 90, 'SUV'],
        ['MNO112', 'Mercedes Benz', 'available', 10000, 100, 'SUV'],
        ['PQR131', 'BMW X3', 'available', 12000, 85, 'SUV'],
        ['STU415', 'Hyundai Sonata', 'available', 18000, 40, 'Sedan'],
        ['VWX516', 'Mazda 3 Saloon', 'available', 22000, 45, 'Sedan'],
        ['YZA617', 'BMW 4 Series', 'available', 16000, 60, 'Sedan'],
        ['BCD718', 'Maserati Ghibli', 'available', 14000, 110, 'Sedan'],
        ['EFG819', 'Toyota Camry', 'available', 20000, 50, 'Sedan'],
        ['HIJ920', 'Toyota Mark X', 'available', 28000, 55, 'Sedan'],
    ];

    // SQL query for inserting data
    $stmt = $pdo->prepare("INSERT INTO vehicle (plat_number, model, status, distance_traveled, price_per_day, type) 
                            VALUES (?, ?, ?, ?, ?, ?)");

    // Loop through the array and insert data into the table
    foreach ($vehicles as $vehicle) {
        $stmt->execute($vehicle);
    }

    echo "Vehicles inserted successfully!";
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
?>
