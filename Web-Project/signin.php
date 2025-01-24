<?php
require 'db.php'; 
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
       
        $sql = "SELECT * FROM customer WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
           
            if (password_verify($password, $user['password'])) {
               
                $_SESSION['customer_id'] = $user['id']; 
                
                
                header("Location: /Web-Project/shark.html");
                exit();
            } else {
                
                echo "<script>alert('Incorrect password!'); window.history.back();</script>";
            }
        } else {
            
            echo "<script>alert('Email not found!'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
