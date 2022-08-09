<!-- Source: https://www.simplilearn.com/tutorials/php-tutorial/php-crud-operations#how_to_readview_records -->
<link rel="stylesheet" href="playedWithMiles.css">
<?php

require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $pdo->prepare("SELECT * FROM albums ORDER BY albumtitle");
$result->execute();
$result = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Albums in database</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>

<body>

    <div class="container">

        <h2>Albums in database</h2>

        <table class="table">

            <thead>
                <tr>
                    <th>Album_id</th>
                    <th>Album title</th>
                    <th>Perfomer Name</th>
                    <th>Release date</th>
                    <th>Recordlabel</th>
                    <th>Imagelocation</th>
                </tr>
            </thead>

            <tbody>

                <?php
                foreach ($result as $row) {
                ?>
                    <tr>
                        <td><?php echo $row['album_id']; ?></td>
                        <td><?php echo $row['albumtitle']; ?></td>
                        <td><?php echo $row['performername']; ?></td>
                        <td><?php echo $row['releasedate']; ?></td>
                        <td><?php echo $row['recordlabel']; ?></td>
                        <td><?php echo $row['imagelocation']; ?><br><img src=<?php echo ($row['imagelocation']); ?> alt=<?php echo ($row['imagelocation']);  ?> /></td>

                        <td><a class="btn btn-info" href="updateAlbum.php?id=<?php echo $row['album_id']; ?>">Edit</a>&nbsp;
                            <a class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')" href="deleteAlbum.php?id=<?php echo $row['album_id']; ?>">Delete </a>
                        </td>
                    </tr>
                <?php       }
                ?>
            </tbody>
        </table>

    </div>

</body>

</html>