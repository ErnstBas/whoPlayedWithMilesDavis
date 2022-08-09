    <!doctype html>
    <html lang="en">
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
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
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

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
        $imagelocation = $target_file;
        $bio = $_POST['bio'];
        $musician_id = $_POST['musician_id'];
        $deathdate = date('Y-m-d', strtotime($_POST['deathdate']));

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file

            if ($_POST['deathdate'] == "") {
                $result = $pdo->prepare(
                    "UPDATE musicians SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate,
                    deathdate= NULL, bio=:bio WHERE musician_id=:musician_id"
                );
                $result->bindValue(':firstname', $firstname);
                $result->bindValue(':lastname', $lastname);
                $result->bindValue(':birthdate', $birthdate);
                $result->bindValue(':bio', $bio);
                $result->bindValue(':musician_id', $musician_id);
            } else {
                $result = $pdo->prepare(
                    "UPDATE musicians SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate,
                    deathdate=:deathdate, bio=:bio WHERE musician_id=:musician_id"
                );
                $result->bindValue(':firstname', $firstname);
                $result->bindValue(':lastname', $lastname);
                $result->bindValue(':birthdate', $birthdate);
                $result->bindValue(':deathdate', $deathdate);
                $result->bindValue(':bio', $bio);
                $result->bindValue(':musician_id', $musician_id);
            }
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            if ($_POST['deathdate'] == "") {
                $result = $pdo->prepare(
                    "UPDATE musicians SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate,
                deathdate= NULL, bio=:bio, imagelocation=:imagelocation
                WHERE musician_id=:musician_id"
                );
                $result->bindValue(':firstname', $firstname);
                $result->bindValue(':lastname', $lastname);
                $result->bindValue(':birthdate', $birthdate);
                $result->bindValue(':bio', $bio);
                $result->bindValue(':imagelocation', $imagelocation);
                $result->bindValue(':musician_id', $musician_id);
            } else {
                $result = $pdo->prepare(
                    "UPDATE musicians SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate,
                deathdate=:deathdate, bio=:bio, imagelocation=:imagelocation
                WHERE musician_id=:musician_id"
                );
                $result->bindValue(':firstname', $firstname);
                $result->bindValue(':lastname', $lastname);
                $result->bindValue(':birthdate', $birthdate);
                $result->bindValue(':deathdate', $deathdate);
                $result->bindValue(':bio', $bio);
                $result->bindValue(':imagelocation', $imagelocation);
                $result->bindValue(':musician_id', $musician_id);
            }
        }

        $result->execute();

        if (!empty($_POST['album'])) {

            foreach ($_POST['album'] as $value) {
                $select = $pdo->prepare("SELECT album_id FROM albums WHERE albumtitle=:albumtitle");
                $select->bindValue(':albumtitle', $value);
                $select->execute();
                $album_id = $select->fetchcolumn();
                $musicianalbum = $pdo->prepare("INSERT INTO musicianalbum(musician_id, album_id) VALUES (:musician_id, :album_id)");
                $musicianalbum->bindValue(':musician_id', $musician_id);
                $musicianalbum->bindValue(':album_id', $album_id);
                $musicianalbum->execute();
            }
        }

        if ($result == TRUE) {
            echo "Record updated successfully.";
        } else {
            echo "Error";
        }
    }

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $result = $pdo->prepare("SELECT * FROM musicians WHERE musician_id=$id");
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        $albums = $pdo->prepare("SELECT albumtitle FROM albums");
        $albums->execute();
        $albums = $albums->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $musician_id = $row['musician_id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $birthdate = $row['birthdate'];
            $deathdate = $row['deathdate'];
            $bio = $row['bio'];
            $imagelocation = $row['imagelocation'];
        } ?>

        <form action="" method="post" enctype="multipart/form-data">
            <!-- <form action="uploadMusician.php" method="post" enctype="multipart/form-data"> -->


            <h2>Update Musician</h2>

            <input type="hidden" name="musician_id" value="<?php echo $musician_id; ?>">

            <div class="form-group">
                <label>Firstname:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" class=" form-control">
            </div>

            <div class="form-group">
                <label>Lastname:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" class=" form-control">
            </div>

            <div class="form-group">
                <label>Birthdate:</label>
                <input type="date" id="date" name="birthdate" value="<?php echo $birthdate; ?>">
            </div>

            <div class="form-group">
                <label>Deathdate:</label>
                <input type="date" id="date" name="deathdate" value="<?php echo $deathdate; ?>">
            </div>

            <div class="form-group">
                <label>bio:</label>
                <textarea id="bio" name="bio" class="form-control"><?php echo htmlspecialchars($bio); ?></textarea>
            </div>

            <div class="form-group">
                <label>Current image: <?php echo $imagelocation; ?> or select image of musician to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <br>

            <?php foreach ($albums as $album) { ?>
                <input type="checkbox" id="<?php echo $album['albumtitle']; ?>" name='album[]' value="<?php echo $album['albumtitle']; ?>">
                <label for="<?php echo $album['albumtitle']; ?>"><?php echo $album['albumtitle']; ?></label><br>
            <?php } ?><br>

            <div class="form-group">
                <input class="btn btn-success" type="submit" value="submit" name="submit">
            </div>




        </form>

        </body>

    </html>

    <?php

    } else {

        header('Location: readMusician.php');
    }


    ?>

    </html>