<?php
require_once '../../private/conn.php';

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$cpassword = $_POST['confirmpassword'];
$adress = $_POST['address'];
$zipcode = $_POST['zipcode'];
$role = '0';
// hash password
if ($password == $cpassword) {
    $hashedpsw = password_hash($password, PASSWORD_DEFAULT);
} else {
    echo 'Passwords do not match';
}
// check if email exist
$sql = "SELECT * FROM accounts WHERE `email` = :email";
$sth = $conn->prepare($sql);
$sth->bindParam(':email', $email);
$sth->execute();
if ($sth->rowCount() == 0) {
    $sql = "INSERT INTO accounts(`email`, `password`, `name`, `adress`, `zipcode`, `role`) VALUES(:email, :password, :name, :adress, :zipcode, :role)";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':email', $email);
    $sth->bindParam(':password', $hashedpsw);
    $sth->bindParam(':name', $name);
    $sth->bindParam(':adress', $adress);
    $sth->bindParam(':zipcode', $zipcode);
    $sth->bindParam(':role', $role);
    $sth->execute();
    header("location: ../index.php?page=loginklant");
} else {
    // error duplicate email
    header("Location: ../index.php?page=register&error=email");
}
?>
