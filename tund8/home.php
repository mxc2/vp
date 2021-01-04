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
  
  require("header.php");
?>

<body>
<form>
<img style="max-width: 550px; max-height: 400px" src="../img/rallybanner.jpg" alt="Banner with a rally car">

<!-- Linebreakid -->
<br>
<br>

<!-- Lingid teistele lehtedele -->
<ul>
	<li><a href="new.php">Lisa uus mõte </a></li>
	<li><a href="previous.php"> Vaata varasemaid mõtted</a></li>
	<li><a href="listfilms.php"> Filmide list</a></li>
	<li><a href="addfilms.php"> Lisa film listi</a></li>
	<li><a href="addfilmrelations.php"> Filmi seoste määramine</a></li>
	<li><a href="listfilmpersons.php"> Filmitegelased</a></li>
	<li><a href="addnewuser.php"> Koostage konto</a></li>
	<li><a href="filmrelations.php"> Film relations</a></li>
	<li><a href="addandmed.php"> Lisage andmeid</a></li>
	<li><a href="movieinfo.php"> Vaadake filme</a></li>
	<li><a href="photoupload.php"> Lisage pilt</a></li>
	<li><a href="userprofile.php"> Konto haldamine</a></li>
</ul>
 
<!-- Võtab username value ja lisab selle enne teksti -->
<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>

<!-- Lihtsalt tekst kus ka hüperlink -->
<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
<p>Lehte on palju downgraditud peale tundi 2, et aidata kaasa kodutöödega. Tänu sellele ei näe leht ka nii eriline välja.</p>

<p>Made by Marcus-Indrek Simmer 2020</p>

</form>
</body>
</html>




