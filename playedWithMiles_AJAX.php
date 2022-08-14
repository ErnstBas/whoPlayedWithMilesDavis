<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Who played with Miles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="playedWithMiles.css">
</head>

<?php
require 'credentials.php';
$pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$resultset = $pdo->prepare("SELECT * FROM musicians ORDER BY lastname");
$resultset->execute();
?>



<div class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Menu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto text-right">
        <li class=" nav-item active">
          <a class="nav-link" href="#">About Miles <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#selectmusician">Select a musician</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#aboutme">About me</a>
        </li>
      </ul>
    </div>
  </nav>
</div>

<header>
  <div class="container">
    <div class="introduction">
      <div class="row">
        <div class="col-md-4">
          <h1>Who played with Miles?</h1>
          <p>This is a PHP based webside connected to a Postgresql database, that stores information about musicians who played with Miles Davis.</p>
          <p>Info and images are taken from Wikipedia.</p>
          <h2>About</h2>
          <p><b>Miles Dewey Davis III</b> was an American trumpeter, bandleader, and composer.
            He is among the most influential and acclaimed figures in the history of jazz
            and 20th-century music. Davis adopted a variety of musical directions in a
            five-decade career that kept him at the forefront of many major stylistic
            developments in jazz.<br></p>
        </div>
        <div class="col-md-8">
          <img src="Images/Miles_Davis_by_Palumbo_cropped.jpg" alt="Miles Davis" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</header>

<div class="selectmusician" id="selectmusician">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2>Select a musician</h2>
      </div>
      <div class="col-md-6">
        <select name="musician" onchange="showMusician(this.value)" class="btn btn-secondary">
          <?php
          foreach ($resultset as $row) {
            $musician_name = $row[1] . " " .  $row[2];
            echo "<option value='$row[0]'>$musician_name </option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div id="albumInfo">
    </div>
    <script>
      function showMusician(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("albumInfo").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "getMusician.php?q=" + str, true);
        xmlhttp.send();
      }
    </script>
  </div>
</div>

<div class="aboutme" id="aboutme">
  <section class="container">
    <div class="row">
      <div class="col-md-8">
        <img src="Images/bas_ernst.jpg" alt="Bas Ernst" class="img-fluid">
      </div>
      <div class="col-md-4">
        <h1>Bas Ernst</h1>
        <p>Cultural attaché and IT student</p>
        <p>At the moment of writing, I just finished the second stage of my study towards a Bsc in Computer and IT at the Open University.
          This is my first project building a website using PHP, Apache, Bootstrap and Postgresql.
          The code is available on <a href="https://github.com/ErnstBas/whoPlayedWithMilesDavis">Github</a>.</p>

        <p>See my <a href="https://www.linkedin.com/in/basernst/">LinkedIn </a> profile for more info.
        </p>

      </div>

    </div>
  </section>
</div>

<footer>
  <section class="container">
    <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />This work is licensed under a
    <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.
    </div>
</footer>


</html>