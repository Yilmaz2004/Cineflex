<?php
if($_SESSION['role'] = 'medewerker'){

    session_start();
    session_destroy();
    session_unset();
    header('location: index.php?page=loginworker');
}elseif ($_SESSION['role'] = 'admin'){

    session_start();
    session_destroy();
    session_unset();
    header('location: index.php?page=loginworker');
}elseif ($_SESSION['role'] = 'klant'){

    session_start();
    session_destroy();
    session_unset();
    header('location: index.php?page=loginklant');
}

?>
