<?php

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {

    $album_id = $_GET['id'];

    $statement = $pdo->prepare("DELETE FROM albums WHERE album_id='" .  $album_id . "'");

    $statement->execute();

    if ($statement == TRUE) {

        echo "Record deleted successfully.";
    } else {

        echo "Error";
    }
}
