<?php
include '../../private/conn.php';
session_start();


$filename = $_FILES["image"]["name"];
$tempname = $_FILES["image"]["tmp_name"];
$folder = "../media/" . $filename;
var_dump($tempname);

// Extracting form data
$filmsData = [
    'title' => $_POST['title'],
    'length' => $_POST['length'],
    'image' => $filename ,
    'release' => $_POST['release'],
    'language' => $_POST['language'],
    'genre' => $_POST['genreid'],
    'description' => $_POST['description'],
    'age' => $_POST['classificationage'],
];

$genreid = $_POST['genreid'];
$classifications = $_POST['classification'];

try {

    // Inserting movie data into movies table
        $stmt = $conn->prepare("INSERT INTO films (`title`, `length`, `image`, `release`, `language`, `genre`, `description`, `age`)
                            VALUES (:title, :length, :image, :release, :language, :genre, :description, :age)");
    $stmt->execute($filmsData);

    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
    // Getting the last inserted movie ID
    $filmid = $conn->lastInsertId();

//     Inserting movie viewpoint data into movieviewpoint table

    foreach ($classifications as $classification) {
        $sql = "INSERT INTO filmsclassification (filmsid, classificationid)
                            VALUES (:filmsid, :classificationid)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':filmsid' =>$filmid,
            'classificationid'=> $classification
        ));
    }

    // Committing the transaction

    // Redirecting to view films page
        header('location: ../index.php?page=filmsview');
} catch (PDOException $e) {
    // Handle the exception
    echo "error: " . $e->getMessage();
}?>
