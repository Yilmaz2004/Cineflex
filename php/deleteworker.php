<?php
include '../../private/conn.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
header('location: ../index.php?page=workersview');
?>