<?php
include '../../private/conn.php';
session_start();

// Assuming you are passing the film id in the form data
$filmid = $_POST['filmid'];
$filename = $_FILES["image"]["name"];
$tempname = $_FILES["image"]["tmp_name"];
$folder = "../media/" . $filename;
var_dump($_POST['genre']);

// Extracting form data
$filmsData = [
    'title' => $_POST['title'],
    'length' => $_POST['length'],
    'release' => $_POST['release'],
    'language' => $_POST['language'],
    'genre' => $_POST['genre'],
    'age' => $_POST['classificationage'],
    'description' => $_POST['description'],
];

$classifications = $_POST['classification'];

echo "<pre>", print_r($classifications), "</pre>";

try {
    if ($filename) {
        $stmt = $conn->prepare("UPDATE films 
                       SET `title` = :title, `length` = :length, 
                           `image` = :image, `release` = :release, 
                           `language` = :language, `genre` = :genre, 
                           `description` = :description,`age` = :age
                       WHERE `filmsid` = :filmid");
        $filmsData['filmid'] = $filmid;
        $filmsData['image'] = $filename;
        $stmt->execute($filmsData);

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }
    }else{
        $stmt = $conn->prepare("UPDATE films 
                       SET `title` = :title, `length` = :length, 
                           `release` = :release, 
                           `language` = :language, `genre` = :genre, 
                           `description` = :description,`age` = :age
                       WHERE `filmsid` = :filmid");
        $filmsData['filmid'] = $filmid;
        $stmt->execute($filmsData);
    }


    // Deleting old classifications
    $stmt = $conn->prepare("DELETE FROM filmsclassification WHERE filmsid = :filmid");
    $stmt->execute(['filmid' => $filmid]);

    // Inserting new classifications
    foreach ($classifications as $classification) {
        $sql = "INSERT INTO filmsclassification (filmsid, classificationid)
                            VALUES (:filmsid, :classificationid)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':filmsid' => $filmid,
            'classificationid'=> $classification
        ));
    }

    // Redirecting to view films page
    header('location: ../index.php?page=filmsview');
} catch (PDOException $e) {
    // Handle the exception
    echo "error: " . $e->getMessage();
}
?>
