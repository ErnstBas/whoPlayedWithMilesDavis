
 <?php

    require 'credentials.php';
    $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['submit'])) {

            $title = $_POST['tracktitle'];
            $musician_ids = $_POST['musician'];
            $album_id = $_POST['album_id'];

            $tracks = $pdo->prepare("INSERT INTO tracks(title) VALUES (:title)");
            $tracks->bindValue(':title', $title);
            $tracks->execute();

            $getTrack_id = $pdo->prepare("SELECT track_id FROM tracks WHERE title = :title");
            $getTrack_id->bindValue(':title', $title);
            $getTrack_id->execute();
            $getTrack_id = $getTrack_id->fetchcolumn();

            $albumtracks = $pdo->prepare("INSERT INTO albumtracks(album_id, track_id) VALUES (:album_id, :track_id)");
            $albumtracks->bindValue(':track_id', $getTrack_id);
            $albumtracks->bindValue(':album_id', $album_id);
            $albumtracks->execute();

            foreach ($musician_ids as $musician_id) {
                $musicianplaystracks = $pdo->prepare("INSERT INTO musicianplaystrack(musician_id, track_id) VALUES (:musician_id, :track_id) 
                                                    ON CONFLICT (musician_id, track_id) DO NOTHING");
                $musicianplaystracks->bindValue(':musician_id', $musician_id);
                $musicianplaystracks->bindValue(':track_id', $getTrack_id);
                $musicianplaystracks->execute();
            }

            $_SESSION['message'] = 'Track has been added';
            $_SESSION['msg_type'] = "success";

            header("location: readTracks.php");
        }
    }
    ?>
