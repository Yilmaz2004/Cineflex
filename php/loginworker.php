<?php
session_start();
include '../../private/conn.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT users.*, roles.role FROM users INNER JOIN roles ON users.roleid = roles.rolesid WHERE email = :email";
$query = $conn->prepare($sql);
$query->execute(array(':email' => $email));
$query = $query->fetch();

if ($query) {
    if (password_verify($password, $query['password'])) {
        $_SESSION['id'] = $query['id'];
        $_SESSION['role'] = $query['role'];
        $_SESSION['name'] = $query['name'];

        if ($query['role'] == 'admin' || $query['role'] == 'medewerker') {
            // Both admins and medewerkers can log in
            if ($query['role'] == 'admin') {
                header('Location: ../index.php?page=workersview');
            } else { // It's a medewerker
                header('Location: ../index.php?page=filmsview');
            }
            exit();
        } else {
            $_SESSION['notification'] = 'Toegang geweigerd: onbekende rol.';
        }
    } else {
        $_SESSION['notification'] = 'Combinatie gebruikersnaam en wachtwoord onjuist.';
    }
} else {
    $_SESSION['notification'] = 'Gebruiker niet gevonden.';
}
header('Location: ../index.php?page=loginworker');
?>
