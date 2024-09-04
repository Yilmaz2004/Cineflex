<?php
include '../private/conn.php';

$id = $_GET['id'];

$sql = "SELECT name, email FROM users
        WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body>
<div class="container mt-3">
    <h2>Edit A Worker</h2>
    <?php
    if (isset($_SESSION['notification'])) {
        echo '<p class="notification">' . $_SESSION['notification'] . '</p>';
        unset($_SESSION['notification']);
    } ?> 
    <form action="php/editworker.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
            <label>Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" value="<?= $row['name'] ?>"
                   name="name">
        </div>
        <div class="mb-3 mt-3">
            <label>Email:</label>
            <input type="text"  class="form-control" placeholder="Enter email" value="<?= $row['email'] ?>" name="email">
        </div>

        <div class="mb-3 mt-3">
            <label>Password:</label>
            <input type="password" class="form-control" placeholder="Enter new password" name="password" required>
        </div>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button name="submit" type="submit" class="btn btn-success">Update</button>
    </form>
</div>
</body>
