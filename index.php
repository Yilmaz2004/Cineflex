<?php
session_start();
$page = $_GET['page'] ?? 'homepage';

?>

<!doctype html>
<html lang="en">
<head>
    <title>CineFlex</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.inc.php'; ?>
<?php include 'includes/'.$page.'.inc.php'; ?>
</body>
</html>