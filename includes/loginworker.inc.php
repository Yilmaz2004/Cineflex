<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title> Login </title>
</head>
<body>
<body>
<form action="php/loginworker.php" method="post">
    <div class="login-page" >
        <?php
        if (isset($_SESSION['notification'])) {
            echo '<p class="notification">' . $_SESSION['notification'] . '</p>';
            unset($_SESSION['notification']);
        } ?>
        <div class="form">
            <div class="login">
                <div class="login-header">
                    <h3>Login medewerker/admin</h3>
                </div>
            </div>
                <input type="text" placeholder="email" name="email" required/>
                <input type="password" placeholder="password" name="password" required/>
                <button class="btn btn-outline-dark btn-lg px-5" type="submit" value="login">Sign in</button>
        </div>
    </div>
</form>
</body>
</body>
</html>