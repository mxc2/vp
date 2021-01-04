<?php
  session_start();

  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	//jõugu sisselogimise lehele
	header("Location: page.php");
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	   header("Location: page.php");
	   exit();
  }
  
  require("../../../config.php");
  require("fnc_printmovieinfo.php");

  $sortby = 0;
  $personsortby = 0;
  $filmsortby = 0;
  $genresortby = 0;
  $studiosortby = 0;
  $positionsortby = 0;
  $quotesortby = 0;

  $sortorder = 0;
  $personsortorder = 0;
  $filmsortorder = 0;
  $genresortorder = 0;
  $studiosortorder = 0;
  $positionsortorder = 0;
  $quotesortorder = 0;
    

  require("header.php");
  
  ?>

  <p>See leht näitab andmebaasi sisu.</p>
  <ul>
	<li><a href="home.php">Esilehele</a></li>
	<li><a href="?logout=1">Logi välja</a></li>
  </ul>
  <br />
  
  <hr />
  <div id="personinmovie">
    <h2>Inimesed filmis</h2>
    <?php 
      if(isset($_GET["sortby"]) and isset($_GET["sortorder"])) {
        if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 5) {
          $sortby = $_GET["sortby"];
        }
        if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2) {
          $sortorder = $_GET["sortorder"];
        }
      }
      echo printpersonsinfilm($sortby, $sortorder); 
    ?>
  </div>
  
  <hr>
  
  <div id="persons">
    <h2>Sünniaastad	</h2>
    <?php 
      if(isset($_GET["personsortby"]) and isset($_GET["personsortorder"])) {
        if($_GET["personsortby"] >= 1 and $_GET["personsortby"] <= 3) {
          $personsortby = $_GET["personsortby"];
        }
        if($_GET["personsortorder"] == 1 or $_GET["personsortorder"] == 2) {
          $personsortorder = $_GET["personsortorder"];
        }
      }
      echo printpersons($personsortby, $personsortorder); 
    ?>
  </div>
  
  <hr>
  
  <div id="genres">
    <h2>Žanrite kirjeldused</h2>
    <?php 
      if(isset($_GET["genresortby"]) and isset($_GET["genresortorder"])) {
        if($_GET["genresortby"] == 1) {
          $genresortby = $_GET["genresortby"];
        }
        if($_GET["genresortorder"] == 1 or $_GET["genresortorder"] == 2) {
          $genresortorder = $_GET["genresortorder"];
        }
      }
      echo printgenres($genresortby, $genresortorder); 
    ?>
  </div>
  
  <hr>
  
  <div id="films">
    <h2>Filmid</h2>
    <?php 
      if(isset($_GET["filmsortby"]) and isset($_GET["filmsortorder"])) {
        if($_GET["filmsortby"] >= 1 and $_GET["filmsortby"] <= 3) {
          $filmsortby = $_GET["filmsortby"];
        }
        if($_GET["filmsortorder"] == 1 or $_GET["filmsortorder"] == 2) {
          $filmsortorder = $_GET["filmsortorder"];
        }
      }
      echo printfilms($filmsortby, $filmsortorder); 
    ?>
  </div>
  
  <hr>
  
  <div id="positions">
    <h2>Positsioonid filmis</h2>
    <?php 
      if(isset($_GET["positionsortby"]) and isset($_GET["positionsortorder"])) {
        if($_GET["positionsortby"] == 1) {
          $positionsortby = $_GET["positionsortby"];
        }
        if($_GET["positionsortorder"] == 1 or $_GET["positionsortorder"] == 2) {
          $positionsortorder = $_GET["positionsortorder"];
        }
      }
      echo printpositions($positionsortby, $positionsortorder); 
    ?>
  </div> 

  <hr>
  
  <div id="quotes">
    <h2>Tsitaadid</h2>
    <?php 
      if(isset($_GET["quotesortby"]) and isset($_GET["quotesortorder"])) {
        if($_GET["quotesortby"] >= 1 and $_GET["quotesortby"] <= 3) {
          $quotesortby = $_GET["quotesortby"];
        }
        if($_GET["quotesortorder"] == 1 or $_GET["quotesortorder"] == 2) {
          $quotesortorder = $_GET["quotesortorder"];
        }
      }
      echo printquotes($quotesortby, $quotesortorder);
    ?>
  </div>  
   
  <hr>
  
  <div id="studios">
    <h2>Filmistuudiod</h2>
    <?php 
      if(isset($_GET["studiosortby"]) and isset($_GET["studiosortorder"])) {
        if($_GET["studiosortby"] == 1) {
          $studiosortby = $_GET["studiosortby"];
        }
        if($_GET["studiosortorder"] == 1 or $_GET["studiosortorder"] == 2) {
          $studiosortorder = $_GET["studiosortorder"];
        }
      }
      echo printstudios($studiosortby, $studiosortorder); 
    ?>
  </div>
</body>
</html>