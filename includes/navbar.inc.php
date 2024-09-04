<?php
$current_page = $_GET['page'] ?? 'homepage'; // assuming 'home' as default

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        $navitems = array(
            array('homepage', 'homepagina'),
            array('workersview', 'workersview'),
            array('filmsview','filmsview' ),
            array('films inplannen','inplannen' ),
            array('logout', 'Uitloggen'),
        );
    } elseif ($_SESSION['role'] == 'medewerker') {
            $navitems = array(
                array('homepage', 'homepagina'),
                array('filmsview', 'filmsview'),
                array('films inplannen', 'inplannen'),
                array('logout', 'Uitloggen'),
            );
        } else {
            $navitems = array(
                array('logout', 'Uitloggen'),
            );
        }

} else {
    $navitems = array(
        array('homepage', 'homepagina'),
        array('loginklant', 'Login'),
        array('registratieklant', 'Register'),
    );
}
?>

<div class="hover">
    <nav class="navbar navbar-expand-sm navbar-dark">
        <ul class="navbar-nav">
            <?php foreach ($navitems as $navitem) { ?>
                <li <?php if ($navitem[0] === $current_page) echo 'class="active"'; ?>>
                    <a class=" nav-link " href="index.php?page=<?= $navitem[0] ?>">
                        <?= $navitem[1] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>


