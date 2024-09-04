<?php
require '../private/conn.php';

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

$test = $conn->prepare("SELECT * FROM genre");
$test->execute();
$test2 = $test->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT f.*, g.genre FROM genre g 
        JOIN films f ON g.genreid = f.genre;";
$stmt3 = $conn->prepare($sql);
$stmt3->execute();

$sql = "SELECT * FROM languages";
$stmt2 = $conn->prepare($sql);
$stmt2->execute();

$sqlother = "SELECT * FROM classification where type != 'age'";
$stmtother = $conn->prepare($sqlother);
$stmtother->execute();

$sql1 = "SELECT classificationid FROM filmsclassification where filmsid = :filmid";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':filmid',  $filmid);
$stmt1->execute();

$chosen = $stmt1->fetchAll(PDO::FETCH_COLUMN);
array_push($chosen, 0);

?>


<body>
<h2>edit film</h2>
<form action="php/editfilms.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label>foto:</label>
        <input type="file" class="form-control" placeholder="Naam" name="image">
    </div>
    <div class="mb-3 mt-3">
        <label>titel:</label>
        <input type="text" class="form-control" placeholder="Title" name="title" value="<?= $resultmovie['title'] ?>">
    </div>
    <div class="mb-3 mt-3">
        <label>beschrijving:</label>
        <input class="form-control" aria-label="With textarea" placeholder="description"
               value="<?= $resultmovie['description'] ?>" name="description">
    </div>
    <div class="mb-3 mt-3">
        <label>duur van film:</label>
        <input type="number" class="form-control" placeholder="Length" name="length" value="<?= $resultmovie['length'] ?>">
    </div>
    <div class="mb-3 mt-3">
        <label>jaartal:</label>
        <input type="number" class="form-control" placeholder="Length" name="release" value="<?= $resultmovie['release'] ?>">
    </div>
    <div class="mb-3 mt-3">
        <label>taal:</label>
        <select class="form-control" class="form-select" name="language" value="<?= $resultmovie['language'] ?>">
            <?php while ($resultlang = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $resultlang["id"] ?>"><?= $resultlang["language"] ?></option>
            <?php } ?>
        </select>
    </div>

    <label>
        <?php foreach ($test2 as $testRecord) { ?>
            <input type="radio" name="genre" value="<?= $testRecord['genreid'] ?>"
                <?php if($testRecord['genreid'] == $resultmovie['genre']) echo 'checked'; ?>>
            <?= $testRecord['genre'] ?><br>
        <?php } ?>
    </label>
    <br>

    <?php while ($resultage = $stmtage->fetch(PDO::FETCH_ASSOC)) { ?>
        <label>
            <input type="radio" name="classificationage" value="<?= $resultage["id"] ?>"<?php if($resultage["id"] == $resultmovie["age"]){ ?> checked="checked" <?php } ?>>
            <span class="checkmark"></span>
            <img class="picture" src="<?= $resultage["classification"] ?>" width="80px" height="80px">
        </label>
    <?php }

    while ($resultother = $stmtother->fetch(PDO::FETCH_ASSOC)) { ?>
        <label>
            <?php if($chosen[0] == $resultother['id']){ ?>
                <input type="checkbox" name="classification[]" value="<?= $resultother['id'] ?>" checked>
                <?php
                array_shift($chosen);
            }else{ ?>
                <input type="checkbox" name="classification[]" value="<?= $resultother['id'] ?>">
            <?php } ?>
            <span class="checkmark"></span>
            <img class="picture" src="<?= $resultother["classification"] ?>" width="80px" height="80px">
        </label>
    <?php } ?>
    <input type="hidden" name="filmid" value="<?= $filmid ?>">
    <button name="submit" type="submit" class="btn btn-success">edit film</button>
</form>
</body>
