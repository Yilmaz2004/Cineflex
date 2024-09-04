
<body>
<div class="header">
    <h1>Welkom bij Cineflex</h1>
</div>
<div class="header">
    <h2>Hieronder zie je de informatie over ons bioscoop</h2>
</div>
<div class="row1">
    <div class="card">
        <h2>Gedragsnormen</h2>
        <img src="images/Foto 4.jpg" class="fakeimg" style="height:180px;">
        <p>Om al onze gasten nu en in de toekomst zo comfortabel mogelijk te kunnen laten genieten van een voorstelling in onze bioscoop hebben wij gedragsnormen opgesteld. Onderstaande gedragsnormen zullen mede in uw belang gehandhaafd worden in onze bioscoop:</p>
    </div>
    <div class="card">
        <h2>Gasten met een beperking</h2>
        <div>
            <img src="images/kassa.jpg" class="fakeimg" style="height:200px;">
        </div>
        <p>Alle twee de zalen zijn toegankelijk voor mindervaliden en de plaatsen zijn zowel telefonisch als online te reserveren. Tevens is er een mindervalidentoilet aanwezig.</p>
    </div>
    <div class="card">
        <h2>Stijlvol</h2>
        <img src="images/Foto 2.jpg" class="fakeimg" style=" width:300px; height:200px;">
        <p>De inrichting, die met veel zorg is samengesteld door een gerenommeerde architect, ademt een luxueuze sfeer en straalt een rust uit die past bij een ontspannen avond of middag uit.</p>
    </div>
    <div class="card">
        <h2>Persoonlijke aandacht</h2>
        <img src="images/Foto 3.jpg" class="fakeimg" style=" width:320px; height:200px;">
        <p>Gasten kunnen rekenen op persoonlijke aandacht. Deze benadering wordt wellicht eerder tijdens een luxe cruise verwacht dan in een bioscoop.</p>
    </div>
</div>
<?php
include '../private/conn.php';

$sql = "SELECT f.filmsid, f.title, f.length, f.image, l.language, f.description
        FROM films f
        JOIN languages l ON f.language = l.id
        ORDER BY filmsid DESC;"; // Sort films by the order they were added
$stmt = $conn->prepare($sql);
$stmt->execute();
?>

<div class="container" style="background-color: transparent">
    <div class="row" >
        <div class="col-xxl-" >
            <div class="row row-cols-1 row-cols-md-3 g-4"> <!-- Change to grid of 3 by 3 -->
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="col" style="background-color: transparent " > <!-- Add col class -->
                            <div class="card h-100" style="background-color: transparent"> <!-- Add h-100 class -->
                                <a href="index.php?page=filmsdetails&filmsid=<?= $row["filmsid"] ?>"> <!-- Wrap image in anchor tag -->
                                    <img class="card-img-top img-button" src="./media/<?php echo $row['image']; ?>" alt="Card image cap" width="150"> <!-- Reduce image size -->
                                </a>
                                <div class="card-body" style="background-color: transparent">
                                    <h5 class="card-title"><?= $row["title"] ?></h5>
                                    <p class="card-text"><?= $row["description"] ?></p>
                                    <p class="card-text">Language: <?= $row["language"] ?></p>
                                    <p class="card-text">Duration: <?= $row["length"] ?> minutes</p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col">
        </div>
    </div>
</div>
</body>
</html>
