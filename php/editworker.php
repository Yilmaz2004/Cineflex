<?php
session_start();
include '../../private/conn.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password']; // Plain text password from the form
$id = $_POST['id'];

// Check if the email already exists
$stmt_check = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
$stmt_check->bindParam(':email', $email);
$stmt_check->bindParam(':id', $id);
$stmt_check->execute();
$row = $stmt_check->fetch(PDO::FETCH_ASSOC);
if ($stmt_check->rowCount() > 0 ){
    // Email already exists, handle the situation (maybe display an error message)
    $_SESSION['notification'] = "Email already exists.";
    header('location: ../index.php?page=editworker');
    exit; // Stop further execution
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update user information
$stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashed_password); // Use the hashed password
$stmt->bindParam(':id', $id);
$stmt->execute();
header('location: ../index.php?page=workersview');
?>
