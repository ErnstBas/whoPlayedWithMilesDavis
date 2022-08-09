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
    <title>Played with Miles Davis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="playedWithMiles.css">
</head>



<form action="uploadAlbum.php" method="post" enctype="multipart/form-data">
    <h2>Add Album</h2>


    <div class="form-group">
        <label>albumtitle:</label>
        <input type="text" id="albumtitle" name="albumtitle" placeholder="albumtitle..." class="form-control">
    </div>

    <div class="form-group">
        <label>performername:</label>
        <input type="text" id="performername" name="performername" placeholder="performername..." class="form-control">
    </div>

    <div class="form-group">
        <label>releasedate:</label>
        <input type="date" id="date" name="releasedate" class="form-control">
    </div>

    <div class="form-group">
        <label>recordlabel:</label>
        <input type="text" id="recordlabel" name="recordlabel" placeholder="recordlabel..." class="form-control">
    </div>

    <div class="form-group">
        <label>Select image of album to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
    </div>
    <br>

    <div class="form-group">
        <input class="btn btn-success" type="submit" value="Submit">
    </div>

    </div>
</form>



</html>