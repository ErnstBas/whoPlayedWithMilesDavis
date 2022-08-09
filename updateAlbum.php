    <!doctype html>
    <html lang="en">

    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="playedWithMiles.css">
    <?php

    require 'credentials.php';
    $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (isset($_POST['update'])) {

        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $albumtitle = $_POST['albumtitle'];
        $performername = $_POST['performername'];
        $releasedate = date('Y-m-d', strtotime($_POST['releasedate']));
        $imagelocation = $target_file;
        $recordlabel = $_POST['recordlabel'];
        $album_id = $_POST['album_id'];

        $result = $pdo->prepare(
            "UPDATE albums SET albumtitle=:albumtitle, performername=:performername, recordlabel=:recordlabel,
                imagelocation=:imagelocation
                WHERE album_id=:album_id"
        );

        $result->bindValue(':albumtitle', $albumtitle);
        $result->bindValue(':performername', $performername);
        $result->bindValue(':recordlabel', $recordlabel);
        $result->bindValue(':imagelocation', $imagelocation);
        $result->bindValue(':album_id', $album_id);

        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
    }

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $result = $pdo->prepare("SELECT * FROM albums WHERE album_id=$id");
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $album_id = $row['album_id'];
            $albumtitle = $row['albumtitle'];
            $performername = $row['performername'];
            $releasedate = $row['releasedate'];
            $recordlabel = $row['recordlabel'];
            $imagelocation = $row['imagelocation'];
        } ?>

        <form action="" method="post" enctype="multipart/form-data">

            <h2>Update Album</h2>

            <input type="hidden" name="album_id" value="<?php echo $album_id; ?>">

            <div class="form-group">
                <label>albumtitle:</label>
                <input type="text" id="albumtitle" name="albumtitle" value="<?php echo $albumtitle; ?>" class=" form-control">
            </div>

            <div class="form-group">
                <label>performername:</label>
                <input type="text" id="performername" name="performername" value="<?php echo $performername; ?>" class=" form-control">
            </div>

            <div class="form-group">
                <label>releasedate:</label>
                <input type="date" id="date" name="releasedate" value="<?php echo $releasedate; ?>">
            </div>

            <div class="form-group">
                <label>recordlabel:</label>
                <textarea id="recordlabel" name="recordlabel" class="form-control"><?php echo htmlspecialchars($recordlabel); ?></textarea>
            </div>

            <div class="form-group">
                <label>Current image: <?php echo $imagelocation; ?> or select image of album to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <br>

            <div class="form-group">
                <input class="btn btn-success" type="submit" value="update" name="update">
            </div>

            </div>


        </form>

        </body>

    </html>

    <?php

    } else {

        header('Location: readAlbum.php');
    }


    ?>

    </html>