<!doctype html>
<html lang="en">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>getMusician</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="playedWithMiles.css">
</head>


<?php

$q = intval($_GET['q']);

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM musicians WHERE musician_id = '" . $q . "'");
$statement->execute();
$musician = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="musician">
    <h2> <?php echo ($musician['firstname'] . " " . $musician['lastname']); ?> </h2>
    <img src=<?php echo ($musician['imagelocation']); ?> alt=<?php echo ($musician['imagelocation']); ?> />
    <p> <?php echo ($musician['bio']); ?></p>
</div>

<?php
function getTracks($musician_id, $album_id)
{
    require 'credentials.php';
    $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $trackSet = $pdo->prepare("SELECT tracks.title FROM albums
                                    INNER JOIN albumtracks ON albums.album_ID = albumtracks.album_ID 
                                    INNER JOIN tracks ON albumtracks.track_ID = tracks.track_ID 
                                    INNER JOIN musicianplaysTrack ON tracks.track_ID = musicianPlaysTrack.track_id 
                                    INNER JOIN musicians ON musicianPlaysTrack.musician_id = musicians.musician_id 
                                    WHERE musicians.musician_id = '" .  $musician_id . "'
                                    AND albums.album_id =  '" .  $album_id . "'");
    $trackSet->execute();
    $tracks = $trackSet->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tracks as $track) {
        echo ($track['title']); ?><br>
<?php }
}
?>

<?php
function getAlbums($musician_id)
{
    require 'credentials.php';
    $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $albumSet = $pdo->prepare("SELECT albums.albumtitle, albums.imageLocation , albums.album_id FROM albums
                                    INNER JOIN musicianAlbum ON albums.album_id = musicianAlbum.album_id
                                    WHERE musicianAlbum.musician_id = '" .  $musician_id . "'
                                    ORDER BY albums.releasedate");
    $albumSet->execute();
    $albums = $albumSet->fetchAll(PDO::FETCH_ASSOC); ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Appeared on album: </th>
                <th scope="col">Played on tracks:</th>
            </tr>
        </thead>
        <?php foreach ($albums as $album) { ?>
            <tbody>
                <tr>
                    <td>
                        <?php echo ($album['albumtitle']); ?><br>
                        <img src=<?php echo ($album['imagelocation']); ?> alt=<?php echo ($album['imagelocation']);  ?> /><br>
                    </td>
                    <td>
                        <?php getTracks($musician_id, $album['album_id']) ?><br>
                    </td>
                </tr>
            </tbody>
        <?php } ?>
    </table>
<?php } ?>


<?php getAlbums($q) ?>



</html>