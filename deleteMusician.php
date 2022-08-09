<?php

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {

    $musician_id = $_GET['id'];

    $statement = $pdo->prepare("DELETE FROM musicians WHERE musician_id='" .  $musician_id . "'");

    $statement->execute();

    if ($statement == TRUE) {

        echo "Record deleted successfully.";
    } else {

        echo "Error";
    }
}
