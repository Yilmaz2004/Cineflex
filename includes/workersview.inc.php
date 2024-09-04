<?php
include '../private/conn.php';
    $sql = "SELECT *
            FROM users 
            INNER JOIN roles ON users.roleid = roles.rolesid
            WHERE roleid = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();?>

<div class="container">
    <div class="row">
        <div class="col">
            <button style="float:right" class="btn btn-success" onclick="window.location.href='index.php?page=addworker'">
                Add Worker
            </button>
        </div>
        <div class="col-xxl-">
            <table class="table">
                <thead>
                <td >id</td>
                <td >First name</td>
                <td>role</td>
                <td>Email</td>
                <td>Edit</td>
                <td>Delete</td>
                </thead>
                <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["role"] ?></td>
                            <td><?= $row["email"] ?></td>
                            <td>
                                <button class="btn btn-warning" onclick="window.location.href='index.php?page=editworker&id=<?= $row["id"] ?>'">Edit</button>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="if(confirm('Are you sure you want to delete this worker?')) window.location.href='php/deleteworker.php?id=<?= $row["id"] ?>'">Delete</button>
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






