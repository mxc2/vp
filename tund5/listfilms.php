<?php
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  require("fnc_film.php");

  require("header.php");
?>

  <ul>
    <li><a href="home.php">Kodulehele</a></li>
  </ul>
  
  <br>
  <p>Andmebaasis filmid:</p>
  
  <hr>
  <?php echo readfilms(); ?>
</body>
</html>






