<?php
require '../private/conn.php';

$sql = "SELECT * FROM classification where type = 'age' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body>
<h2>Add a film</h2>
<form action="php/addfilms.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label>foto:</label>
        <input type="file" class="form-control" placeholder="Naam" name="image">
    </div>
    <div class="mb-3 mt-3">
        <label>titel:</label>
        <input type="text" class="form-control" placeholder="Title" name="title">
    </div>
    <div class="mb-3 mt-3">
        <label>beschrijving:</label>
        <textarea class="form-control" aria-label="With textarea" placeholder="description"
                  name="description"></textarea>
    </div>
    <div class="mb-3 mt-3">
        <label>duur:</label>
        <input type="number" class="form-control" placeholder="Length" name="length">
    </div>
    <div class="mb-3 mt-3">
        <label>jaartal:</label>
        <input type="number" class="form-control" placeholder="Length" name="release">
    </div>
    <div class="mb-3 mt-3">
        <label>taal:</label>
        <select class="form-control" class="form-select" name="language">
            <?php
            $sql = "SELECT * FROM languages";
            $stmt2 = $conn->prepare($sql);
            $stmt2->execute();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?= $row2["id"] ?>"><?= $row2["language"] ?></option>
            <?php } ?>
        </select>
    </div>
    <?php
    $sql = "SELECT * FROM genre";
    $stmt2 = $conn->prepare($sql);
    $stmt2->execute();
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
        <label>
            <input type="radio" name="genreid" value="<?= $row2["genreid"] ?>"><?= $row2["genre"] ?>
            <span class="checkmark"></span>
        </label>
    <?php } ?>
    <br>

    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <label>
            <input type="radio" name="classificationage" value="<?= $row["id"] ?>">
            <span class="checkmark"></span>
            <img class="picture" src="<?= $row["classification"] ?>" width="80px" height="80px">
        </label>
    <?php }
    $sql = "SELECT * FROM classification where type != 'age'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <label>
            <input type="checkbox" name="classification[]" value="<?= $row2["id"] ?>">
            <span class="checkmark"></span>
            <img class="picture" src="<?= $row2["classification"] ?>" width="80px" height="80px">
        </label>
    <?php } ?>
    <button name="submit" type="submit" class="btn btn-success">Add film</button>
</form>
</body>