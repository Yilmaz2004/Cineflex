<?php
include '../../private/conn.php';

$filmsid = $_GET['filmsid'];



    $sql1 = "DELETE FROM filmsclassification WHERE filmsid = :filmsid";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(':filmsid', $filmsid);
    $stmt1->execute();

    $sql = "DELETE FROM films WHERE filmsid = :filmsid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':filmsid', $filmsid);
    $stmt->execute();


    header('location: ../index.php?page=filmsview');
