<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title> Login </title>
</head>
<body>
<body>
<div class="login-page">
    <div class="form">
        <div class="login">
            <div class="login-header">
                <h3>Login klant</h3>
            </div>
        </div>
        <form class="login-form">
            <?php
            if (isset($_SESSION['notification'])) {
                echo '<p class="notification">' . $_SESSION['notification'] . '</p>';
                unset($_SESSION['notification']);
            } ?>
            <input type="text" placeholder="username"/>
            <input type="password" placeholder="password"/>
            <button>login</button>
            <p class="message">Not registered? <a href="index.php?page=registratieklant">Create an account</a></p>
        </form>
    </div>
</div>
</body>
</body>
</html>