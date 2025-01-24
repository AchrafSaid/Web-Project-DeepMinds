<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $house_number = $_POST['house_number'];
    $driving_licence = $_POST['driving_licence'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $password = $_POST['password'];

    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "SELECT * FROM customer WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<script>alert('Email is already registered. Please use a different email.'); window.history.back();</script>";
            exit();
        }

        $pdo->beginTransaction();

        $sql = "INSERT INTO customer (first_name, last_name, state, city, house_number, driving_licence, email, password) 
                VALUES (:first_name, :last_name, :state, :city, :house_number, :driving_licence, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':house_number', $house_number);
        $stmt->bindParam(':driving_licence', $driving_licence);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        $customer_id = $pdo->lastInsertId();

        $sql = "INSERT INTO phonenumbers (customer_num, customer_id) VALUES (:phone_number, :customer_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();

        $pdo->commit();

        echo "<script>alert('Sign-up successful!'); window.location.href = '/Web-Project/html_1.html';</script>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
