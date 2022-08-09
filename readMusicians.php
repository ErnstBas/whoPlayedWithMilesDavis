<!-- Source: https://www.simplilearn.com/tutorials/php-tutorial/php-crud-operations#how_to_readview_records -->
<link rel="stylesheet" href="playedWithMiles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<?php

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $pdo->prepare("SELECT * FROM musicians ORDER BY lastname");
$result->execute();
$result = $result->fetchAll(PDO::FETCH_ASSOC);

$albums = $pdo->prepare("SELECT albumtitle FROM albums");
$albums->execute();
$albums = $albums->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Musicians in database</title>



</head>

<body>

    <div class="container">

        <h2>Musicians in database</h2>

        <table class="table">

            <thead>
                <tr>
                    <th>Musician_id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Date of death</th>
                    <th>Bio</th>
                    <th>Imagelocation</th>
                    <th>Played on albums</th>
                </tr>
            </thead>

            <tbody>

                <?php
                foreach ($result as $row) {
                ?>
                    <tr>
                        <td><?php echo $row['musician_id']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['birthdate']; ?></td>
                        <td><?php echo $row['deathdate']; ?></td>
                        <td><?php echo $row['bio']; ?></td>
                        <td><img src=<?php echo ($row['imagelocation']); ?> alt=<?php echo ($row['imagelocation']);  ?> /></td>
                        <td>
                            <?php $musicianalbum = $pdo->prepare("SELECT album_id FROM musicianalbum WHERE musician_id = '" . $row['musician_id'] . "'");
                            $musicianalbum->execute();
                            $album_ids = $musicianalbum->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($album_ids as $value) {
                                if ($value) {
                                    $albums = $pdo->prepare("SELECT albumtitle FROM albums WHERE album_id = '" . $value['album_id'] . "'");
                                    $albums->execute();
                                    $albums = $albums->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($albums as $album) {
                                        echo $album['albumtitle']; ?><br>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><a class="btn btn-info" href="updateMusician.php?id=<?php echo $row['musician_id']; ?>">Edit</a>&nbsp;
                            <a class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')" href="deleteMusician.php?id=<?php echo $row['musician_id']; ?>">Delete </a>
                        </td>


                    </tr>
                <?php       }
                ?>
            </tbody>
        </table>

    </div>

</body>

</html>