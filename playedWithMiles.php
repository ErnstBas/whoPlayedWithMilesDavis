<!doctype html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Played with Miles Davis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="playedWithMiles.css">
</head>

<body>

  <div class="grid">

    <header>
      <h1>Musicians who played with Miles Davis</h1>

      <script>
        function showMusician(str) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("txtHint").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET", "getMusician.php?q=" + str, true);
          xmlhttp.send();
        }
      </script>

      <?php
      require 'credentials.php';
      $pdo = new PDO("pgsql:host=$database_host;port=$port;dbname=$database_name;", $database_user, $database_password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $resultset = $pdo->prepare("SELECT * FROM musicians ORDER BY lastname");
      $resultset->execute();
      ?>

      <select name="musician" onchange="showMusician(this.value)">

        <?php
        foreach ($resultset as $row) {
          $musician_name = $row[1] . " " . $row[2];
          echo "<option value='$row[0]'>$musician_name</option>";
        }
        ?>
      </select>

      <div id="txtHint">

      </div>

    </header>

    <footer>

    </footer>

  </div>
</body>

</html>