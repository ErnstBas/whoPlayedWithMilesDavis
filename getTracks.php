 <!-- source: https://www.youtube.com/watch?v=3xRMUDC74Cw -->

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

 <?php require_once 'addTracks.php'; ?>

 <?php
    if (isset($_SESSION['message'])) { ?>
     <div class="alert alert-<?= $_SESSION['msg_type'] ?>"></div>
     <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
     </div>
 <?php } ?>



 <?php
    $q = intval($_GET['q']);

    require 'credentials.php';
    $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $pdo->prepare("SELECT * FROM albums WHERE album_id = '" . $q . "'");
    $statement->execute();
    $album = $statement->fetch(PDO::FETCH_ASSOC);
    ?>

 <table class="table">
     <thead>
         <tr>
             <th>Album title</th>
             <th>Cover</th>
             <th>Musicians</th>
             <!-- <th>Update or delete</th> -->
         </tr>
     </thead>
     <tbody>
         <tr>
             <td>
                 <h2> <?php echo ($album['albumtitle']); ?> </h2>
             </td>
             <td><img src=<?php echo ($album['imagelocation']); ?> alt=<?php echo ($album['imagelocation']); ?> /></td>
             <td>
                 <?php
                    $result = $pdo->prepare("SELECT musicians.firstname, musicians.lastname, musicians.musician_id FROM musicians 
                                INNER JOIN musicianalbum ON musicians.musician_id = musicianalbum.musician_id 
                                WHERE musicianalbum.album_id = '" . $q . "'
                                ORDER BY musicians.lastname");
                    $result->execute();
                    $result = $result->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $value) {
                        echo $value['firstname'] . " " . $value['lastname']; ?><br>
                 <?php } ?>
             </td>
             <!-- <td><a class="btn btn-primary" href="updateAlbum.php?id=<?php echo $album['album_id']; ?>">Edit album</a>&nbsp;
                 <a class="btn btn-secondary" href="addAlbum.php?id=<?php echo $album['album_id']; ?>">Add album</a>&nbsp;
                 <a class="btn btn-info" href="addMusician.php?id=<?php echo $album['album_id']; ?>">Add Musician</a>&nbsp;
                 <a class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')" href="deleteAlbum.php?id=<?php echo $album['album_id']; ?>">Delete </a>
             </td> -->
         </tr>
 </table>



 <table class="table">

     <thead>
         <tr>
             <th>Tracks in database</th>
             <th>Musicians</th>
             <th colspan="2">Update or delete</th>
         </tr>
     </thead>

     <tbody>
         <?php
            $tracks = $pdo->prepare("SELECT * FROM albumtracks WHERE album_id = '" . $q . "'");
            $tracks->execute();
            $tracklist = $tracks->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tracklist as $song) {

                $statement = $pdo->prepare("SELECT * FROM tracks WHERE track_id =  '" . $song['track_id'] . "'");
                $statement->execute();
                $statement = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($statement as $value) { ?>

                 <tr>
                     <td>
                         <?php echo $value['title']; ?><br>
                     </td>

                     <td>
                         <?php
                            $musicians = $pdo->prepare("SELECT musicians.firstname, musicians.lastname, musicians.musician_id FROM musicians
                                                INNER JOIN musicianalbum ON musicians.musician_id = musicianalbum.musician_id 
                                                INNER JOIN musicianplaystrack ON musicians.musician_id = musicianplaystrack.musician_id
                                                INNER JOIN tracks ON musicianplaystrack.track_id = tracks.track_id
                                                WHERE musicianalbum.album_id = '" . $q . "'
                                                AND tracks.track_id = '" . $song['track_id'] . "'
                                                ORDER BY musicians.lastname");
                            $musicians->execute();
                            $musicians = $musicians->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($musicians as $musician) { ?>
                             <p><?php echo $musician['firstname'] . " " . $musician['lastname']; ?></p>
                         <?php } ?>

                     </td>

                     <td>
                         <form action="updateTracks.php" method="POST">
                             <label for="hiddenField"></label>
                             <input type="hidden" name="track_id" id="track_id" value="<?php echo $song['track_id']; ?>" />

                             <label for="hiddenField"></label>
                             <input type="hidden" name="album_id" id="album_id" value="<?php echo $album['album_id']; ?>" />

                             <div class="form-group">
                                 <input class="btn btn-success" type="submit" value="edit" name="edit">&nbsp;
                                 <a class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')" href="deleteTracks.php?id=<?php echo $song['track_id']; ?>">Delete </a>
                             </div>
                         </form>
                     </td>
                 </tr>

             <?php } ?>
         <?php } ?>
     </tbody>
 </table>




 <form action="addTracks.php" method="POST">
     <table class="table">
         <thead>
             <tr>
                 <th>Add new track</th>
                 <th>Select musicians</th>
                 <th>Submit new track</th>
             </tr>
         </thead>
         <tbody>
             <label for="hiddenField"></label>
             <input type="hidden" name="album_id" id="album_id" value="<?php echo $q; ?>" />
             <tr>
                 <td>
                     <div class="form-group">
                         <input type="text" id="tracktitle" name="tracktitle" placeholder="Fill in title of the track..." class="form-control">
                     </div>
                 </td>
                 <td>
                     <?php foreach ($result as $musician) { ?>
                         <input type="checkbox" id="<?php echo $musician['firstname'] . " " . $musician['lastname']; ?>" name='musician[]' value="<?php echo $musician['musician_id']; ?>">
                         <label for="<?php echo $musician['firstname'] . " " . $musician['lastname']; ?>"><?php echo $musician['firstname'] . " " . $musician['lastname']; ?></label><br>
                     <?php } ?><br>
                 </td>
                 <td>
                     <div class="form-group">
                         <input class="btn btn-success" type="submit" value="submit" name="submit">
                     </div>
                 </td>
             </tr>
         </tbody>
     </table>
 </form>

 </html>