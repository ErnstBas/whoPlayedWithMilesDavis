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



<form action="uploadMusician.php" method="post" enctype="multipart/form-data">
    <h2>Add Musician</h2>


    <div class="form-group">
        <label>Firstname:</label>
        <input type="text" id="firstname" name="firstname" placeholder="Firstname..." class="form-control">
    </div>

    <div class="form-group">
        <label>Lastname:</label>
        <input type="text" id="lastname" name="lastname" placeholder="Lastname..." class="form-control">
    </div>

    <div class="form-group">
        <label>Birthdate:</label>
        <input type="date" id="date" name="birthdate" class="form-control">
    </div>

    <div class="form-group">
        <label>Deathdate:</label>
        <input type="date" id="date" name="deathdate" class="form-control">
    </div>

    <div class="form-group">
        <label>bio:</label>
        <textarea id="bio" name="bio" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Select image of musician to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
    </div>
    <br>

    <div class="form-group">
        <input class="btn btn-success" type="submit" value="Submit">
    </div>

    </div>
</form>



</html>