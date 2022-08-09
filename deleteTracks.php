
<?php require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_GET['id'])) {


    $track_id = $_GET['id'];
    $statement3 = $pdo->prepare("DELETE FROM musicianplaystrack WHERE track_id='" . $track_id . "'");
    $statement1 = $pdo->prepare("DELETE FROM albumtracks WHERE track_id='" . $track_id . "'");
    $statement2 = $pdo->prepare("DELETE FROM tracks WHERE track_id='" . $track_id . "'");

    $statement3->execute();
    $statement1->execute();
    $statement2->execute();


    if ($statement2 == TRUE) {

        echo "Record deleted successfully.";
    } else {

        echo "Error";
    }


    header("location: readTracks.php");
}
?>
