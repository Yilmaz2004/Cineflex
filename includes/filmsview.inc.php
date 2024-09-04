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
    <div class="row">
        <div class="col">
            <button style="float:right" class="btn btn-success" onclick="window.location.href='index.php?page=addfilms'">
                Add film
            </button>
        </div>
        <div class="col-xxl-">
            <table class="table table-dark ">
                <thead>
                <td>foto</td>
                <td >titel</td>
                <td >beschrijving</td>
                <td>taal</td>
                <td>duur</td>
                <td>inhoud</td>
                <td>Edit</td>
                <td>Delete</td>
                </thead>
                <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><img src="./media/<?php echo $row['image']; ?>" width="100"></td>
                            <td><?= $row["title"] ?></td>
                            <td><?= $row["description"] ?></td>
                            <td><?= $row["language"] ?></td>
                            <td><?= $row["length"] ?></td>
                            <td>
                                <button class="btn btn-primary"  onclick="window.location.href='index.php?page=filmsdetails&filmsid=<?= $row["filmsid"] ?>'">inhoud</button>
                            </td>
                            <td>
                                <button class="btn" style="background-color: yellow" onclick="window.location.href='index.php?page=editfilms&filmsid=<?= $row["filmsid"] ?>'">Edit</button>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick=" if(confirm('Are you sure you want to delete this film?'))window.location.href='php/deletefilms.php?filmsid=<?= $row["filmsid"] ?>'">Delete</button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col">
        </div>
    </div>
</div>
