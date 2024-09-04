<?php
session_start();
include '../../private/conn.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = 'medewerker'; // Assuming 'medewerker' is a valid role

// First, let's fetch the role ID corresponding to the 'medewerker' role from the roles table
$sql_role = 'SELECT rolesid FROM roles WHERE role = :role';
$stmt_role = $conn->prepare($sql_role);
$stmt_role->bindParam(':role', $role);
$stmt_role->execute();
$role_row = $stmt_role->fetch(PDO::FETCH_ASSOC);

if ($role_row) { // Role found
    $role_id = $role_row['rolesid'];

    // Now, proceed with inserting the user into the users table
    // Check if the email already exists in the users table
    $sql_check_email = 'SELECT id FROM users WHERE email = :email';
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bindParam(':email', $email);
    $stmt_check_email->execute();
    $row = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

    if (!$row) { // Email does not exist, proceed with insertion
        // Hash the password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert_user = 'INSERT INTO users (name, email, password, roleid)
                            VALUES (:name, :email, :password, :roleid)';
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bindParam(':name', $name);
        $stmt_insert_user->bindParam(':email', $email);
        $stmt_insert_user->bindParam(':password', $hashed_password); // Store the hashed password
        $stmt_insert_user->bindParam(':roleid', $role_id); // Assign the role ID
        $stmt_insert_user->execute();
        header('Location: ../index.php?page=workersview');
        exit(); // Terminate script execution after redirection
    } else {
        $_SESSION['notification'] = 'This email is already registered.';
        header('Location: ../index.php?page=addworker');
        exit(); // Terminate script execution after redirection
    }
} else {
    // If the role 'medewerker' does not exist in the roles table, handle the error accordingly
    $_SESSION['notification'] = 'Error: Role not found.';
    header('Location: ../index.php?page=addworker');
    exit(); // Terminate script execution after redirection
}
?>
