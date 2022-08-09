<!-- Sources: https://www.w3schools.com/php/php_file_upload.asp 
and https://www.youtube.com/watch?v=2eebptXfEvw&list=WL&index=6-->



<?php
$target_dir = "Images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
    $deathdate = date('Y-m-d', strtotime($_POST['deathdate']));
    $bio = $_POST['bio'];
    $imagelocation = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // Check if musician already exists in database
    $nameCheck = $pdo->prepare("SELECT firstname, lastname FROM musicians WHERE firstname = '" .  $firstname . "' AND lastname = '" .  $lastname . "'");
    $nameCheck->execute();
    $user = $nameCheck->fetch();
    if ($user) {
        exit("Sorry, musician already in database. Database was not updated");
    } else {
        if ($_POST['deathdate'] == "") {
            $deathdate = NULL;
        }
        $statement = $pdo->prepare(
            "INSERT INTO musicians (firstname, lastname, birthdate, deathdate, bio, imagelocation)
                          VALUES (:firstname, :lastname, :birthdate, :deathdate, :bio, :imagelocation)"
        );

        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':birthdate', $birthdate);
        $statement->bindValue(':deathdate', $deathdate);
        $statement->bindValue(':bio', $bio);
        $statement->bindValue(':imagelocation', $imagelocation);

        $statement->execute();
    }
}

?>