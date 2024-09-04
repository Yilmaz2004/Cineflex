<?php

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']);

// Inclusie van het bestand met de databaseverbinding
include '../private/conn.php';

$filmid = $_GET['filmsid'];
$typeage = "age";

$sqlage = "SELECT * FROM classification where type = :type";
$stmtage = $conn->prepare($sqlage);
$stmtage->bindParam(':type', $typeage);
$stmtage->execute();

$sql2 = "SELECT * FROM films WHERE filmsid = :filmsid";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':filmsid', $filmid);
$stmt2->execute();
$resultmovie = $stmt2->fetch(PDO::FETCH_ASSOC);

$sqlother = "SELECT * FROM classification where type != 'age'";
$stmtother = $conn->prepare($sqlother);
$stmtother->execute();

$sql1 = "SELECT classificationid FROM filmsclassification where filmsid = :filmid";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':filmid',  $filmid);
$stmt1->execute();

$chosen = $stmt1->fetchAll(PDO::FETCH_COLUMN);
array_push($chosen, 0);

// Controleren of de filmsid-parameter is ingesteld en een getal is
if(isset($_GET['filmsid']) && is_numeric($_GET['filmsid'])) {
    // Filmsid uit de URL halen
    $filmsid = $_GET['filmsid'];

    // SQL-query om filmgegevens op te halen
    $sql = "SELECT *
        FROM films f
        JOIN languages l ON f.language = l.id
        JOIN genre g ON f.genre = g.genreid
        LEFT JOIN filmsclassification fc ON f.filmsid = fc.filmsid
        LEFT JOIN classification c ON fc.classificationid = c.id
        WHERE f.filmsid = :filmsid"; // LEFT JOIN gebruikt om te voorkomen dat de query stopt als er geen classification is

    // Voorbereiden van de SQL-query
    $stmt = $conn->prepare($sql);
    // Binden van parameters
    $stmt->bindParam(':filmsid', $filmsid, PDO::PARAM_INT);
    // Uitvoeren van de query
    $stmt->execute();
    // Ophalen van de resultaten
    $film = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verdergaan met de rest van de code, ook als de classification niet is ingesteld
} else {
    // Redirecten naar de indexpagina als filmsid-parameter ontbreekt of ongeldig is
    header("Location: index.php");
    exit();
}

?>

<body>
<div class="container">
    <div class="film-image">
        <?php if(isset($film)) : ?>
            <img src="./media/<?php echo $film['image']; ?>" width="200">
        <?php else : ?>
            <p>No Image Available</p>
        <?php endif; ?>
    </div>
    <div class="film-detail">
        <?php if(isset($film)) : ?>
            <h2>Title: <?= $film['title'] ?></h2>
            <p>Description: <?= $film['description'] ?></p>
            <p>gepubliceerd: <?= $film['release'] ?> </p>
            <p>Language: <?= $film['language'] ?></p>
            <p>Duration: <?= $film['length'] ?> minutes</p>
            <p>genre: <?= $film['genre'] ?> </p>
            <p>kijkwijzer:</p>
            <!-- Alleen de geselecteerde kijkwijzer voor leeftijd tonen -->
            <?php while ($resultage = $stmtage->fetch(PDO::FETCH_ASSOC)) {
                if ($resultage["id"] == $resultmovie["age"]) { ?>
                    <label>
                        <span class="checkmark"></span>
                        <img class="picture" src="<?= $resultage["classification"] ?>" width="80px" height="80px">
                    </label>
                <?php }
            } ?>
            <!-- Alleen de geselecteerde genre-pictogrammen weergeven -->
            <?php while ($resultother = $stmtother->fetch(PDO::FETCH_ASSOC)) {
                if (in_array($resultother['id'], $chosen)) { ?>
                    <label>
                        <span class="checkmark"></span>
                        <img class="picture" src="<?= $resultother["classification"] ?>" width="80px" height="80px">
                    </label>
                <?php }
            } ?>
        <?php else : ?>
            <p>Film not found.</p>
        <?php endif; ?>

    </div>
    <!-- Render buttons only if the user is logged in -->
    <?php if($isLoggedIn): ?>
        <div class="button-container">
            <button class="back-btn" onclick="window.location.href='index.php?page=filmsview'">
                films overzicht
            </button>
        </div>
    <?php endif; ?>
</div>
</body>

