<!-- Source: https://www.simplilearn.com/tutorials/php-tutorial/php-crud-operations#how_to_readview_records -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>readAlbumTacksMusicians</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="AlbumTracksMusicians.css">
</head>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- <link rel="stylesheet" href="playedWithMiles.css"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<?php
require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<html>

<header>

    <h2>Select album</h2>

    <script>
        function showAlbum(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("albumInfo").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "getTracks.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

    <?php
    require 'credentials.php';
    $resultset = $pdo->prepare("SELECT * FROM albums ORDER BY albumtitle");
    $resultset->execute();
    ?>

    <select class="btn btn-outline-warning" name="album" onchange="showAlbum(this.value)">
        <?php
        foreach ($resultset as $row) {
            $albumtitle = $row[1];
            echo "<option value='$row[0]'>$albumtitle</option>";
        }
        ?>
    </select>

</header>

<body>

    <div id="albumInfo">
    </div>

</body>

</html>