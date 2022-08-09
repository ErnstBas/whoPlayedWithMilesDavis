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
    <title>getTracks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="AlbumTracksMusicians.css">
</head>

<?php
require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {

        $title = $_POST['tracktitle'];
        $musician_ids = $_POST['musician'];
        $track_id = $_POST['track_id'];


        //UPDATE title on tracks on that specific album!
        $tracks = $pdo->prepare("UPDATE tracks SET title=:title WHERE track_id='" . $track_id . "'");
        $tracks->bindValue(':title', $title);
        $tracks->execute();

        //update musicians on musicianplaystrack
        $statement3 = $pdo->prepare("DELETE FROM musicianplaystrack WHERE track_id='" . $track_id . "'");
        $statement3->execute();
        foreach ($musician_ids as $musician_id) {
            $musicianplaystracks = $pdo->prepare("INSERT INTO musicianplaystrack(musician_id, track_id) VALUES (:musician_id, :track_id) 
                                                    ON CONFLICT (musician_id, track_id) DO NOTHING");
            $musicianplaystracks->bindValue(':musician_id', $musician_id);
            $musicianplaystracks->bindValue(':track_id', $track_id);
            $musicianplaystracks->execute();
        }
        header('Location: readTracks.php');
    }
}



if (isset($_POST['edit'])) {

    $track_id = $_POST['track_id'];
    $album_id = $_POST['album_id'];

    $result = $pdo->prepare("SELECT musicians.firstname, musicians.lastname, musicians.musician_id FROM musicians 
                                INNER JOIN musicianalbum ON musicians.musician_id = musicianalbum.musician_id 
                                WHERE musicianalbum.album_id = '" . $album_id . "'
                                ORDER BY musicians.lastname");
    $result->execute();


    $track = $pdo->prepare("SELECT title FROM tracks WHERE track_id = '" . $track_id . "'");
    $track->execute();
    $tracktitle = $track->fetch();
} ?>

<form action="" method="post">

    <h2>Update Tracks</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Edit previous track title</th>
                <th>Select musicians</th>
                <th>Submit edited track</th>
            </tr>
        </thead>
        <tbody>
            <label for="hiddenField"></label>
            <input type="hidden" name="album_id" id="album_id" value="<?php echo $id; ?>" />
            <tr>
                <td>
                    <div class="form-group">
                        <input type="text" id="tracktitle" name="tracktitle" value="<?php echo $tracktitle['title'] ?>" class="form-control">
                    </div>
                </td>
                <td>
                    <?php $musicians = $pdo->prepare("SELECT musicians.firstname, musicians.lastname, musicians.musician_id FROM musicians
                        INNER JOIN musicianalbum ON musicians.musician_id = musicianalbum.musician_id
                        INNER JOIN musicianplaystrack ON musicians.musician_id = musicianplaystrack.musician_id
                        INNER JOIN tracks ON musicianplaystrack.track_id = tracks.track_id
                        WHERE musicianalbum.album_id = '" . $album_id . "'
                        AND tracks.track_id = '" . $track_id . "'
                        ORDER BY musicians.lastname");
                    $musicians->execute();
                    $musicians = $musicians->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $musician) { ?>
                        <input type="checkbox" id="<?php echo $musician['firstname'] . " " . $musician['lastname']; ?>" name='musician[]' value="<?php echo $musician['musician_id']; ?>">
                        <label for="<?php echo $musician['firstname'] . " " . $musician['lastname']; ?>"><?php echo $musician['firstname'] . " " . $musician['lastname']; ?></label><br>
                    <?php } ?><br>
                </td>
                <td>
                    <label for="hiddenField"></label>
                    <input type="hidden" name="track_id" id="track_id" value="<?php echo $track_id ?>" />
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="submit" name="submit">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>

</html>