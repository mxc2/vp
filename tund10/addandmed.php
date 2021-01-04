<?php
	session_start();
//kui pole sisselogitud
if(!isset($_SESSION["userid"])){
	//jõuga
	header("Location: page.php");
}
//väljalogimine
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page.php");
	exit();
}

	require("../../../config.php");
	require("fnc_common.php");
	require("fnc_addandmed.php");
	
	$database = "if20_marcus_si_3";
	
	$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	$firstname= null;
    $lastname = null;
	$birthdate = null;
	$birthday = null; 
	$birthmonth = null;
	$birthyear = null; 
	$movieyear = null;
	
	$personnotice = null;
	$movienotice = null; 
	$positionnotice = null; 
	$genrenotice = null;
	$companynotice = null;
	$quotenotice = null;
	
	$firstnameerror = null;
	$lastnameerror = null; 
	$birthdateerror = null; 
	$birthdayerror = null; 
	$birthmontherror = null; 
	$birthyearerror = null; 
	$movienameerror = null; 
	$movieyearerror = null; 
	$moviedurationerror = null;
	$descriptionerror = null; 
	$positionerror = null; 
	$positiondescriptionerror = null; 
	$genreerror = null; 
	$genredescriptionerror = null; 
	$companyerror = null; 
	$companyaddresserror = null;
	$quoteerror = null;
	
	
	if(isset($_POST["personsubmit"])) {
		if(!empty($_POST["firstnameinput"])) {
			$firstname = test_input($_POST["firstnameinput"]);
		} else {
			$firstnameerror = "Palun sisesta eesnimi!";
			
		}
		if(!empty($_POST["lastnameinput"])) {
			$lastname = test_input($_POST["lastnameinput"]);
		} else {
			$lastnameerror = "Palun sisesta perekonnanimi!";
			
		}
		if(!empty($_POST["birthdayinput"])){
			$birthday= intval($_POST["birthdayinput"]);
		} else {
			  $birthdayerror = "Palun vali sünnipäev!";
		  }
		if(!empty($_POST["birthmonthinput"])){
			$birthmonth= intval($_POST["birthmonthinput"]);
		} else {
			  $birthmontherror = "Palun vali sünnikuu!";
		  }
		if(!empty($_POST["birthyearinput"])){
			$birthyear= intval($_POST["birthyearinput"]);
		} else {
			  $birthyearerror = "Palun vali sünniaasta!";
		  }
		  //kontrollime kas sisestati reaalne kuupÃ¤ev 
		if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
			  if(checkdate($birthmonth, $birthday, $birthyear)){
				  $tempdate = new DateTime ($birthyear . "-" .$birthmonth ."-" .$birthday);
				  $birthdate= $tempdate->format("Y-m-d");}
				  else{
					  $birthdateerror = "Kuupäev on vigane!";
				  }
			  }

		if(!empty($firstnameerror) and !empty($lastnameerror) and !empty($birthdayerror) and !empty($birthmontherror) and !empty($birthyearerror) and !empty($birthdateerror)) {
			$personnotice = addperson($firstname, $lastname, $birthdate);
		}
	}
	
	if(isset($_POST["filmsubmit"])) {
		if(!empty($_POST["movienameinput"])) {
			$moviename = test_input($_POST["movienameinput"]);
		} else {
			$movienameerror = "Filmi nimi sisestamata!";
		}
		if(!empty($_POST["movieyearinput"])) {
			$movieyear = intval($_POST["movieyearinput"]);
			
		} else {
			$movieyearerror = "Filmi tootmisaasta valimata!";

			
		}
		if(!empty($_POST["moviedurationinput"])) {
			if($_POST["moviedurationinput"] <= 0 or $_POST["moviedurationinput"] > 500) {
				$moviedurationerror = "Ebareaalne filmi pikkus!";
			} else {
				$movieduration = intval($_POST["moviedurationinput"]);
			}
		} else {
			$moviedurationerror = "Filmi pikkus valimata!";
			
		}
		if(!empty($_POST["descriptioninput"])) {
			$description = test_input($_POST["descriptioninput"]);
		} else {
			$descriptionerror = "Filmi kirjeldus lisamata!";
			
		}
		if(!empty($movienameerror) and !empty($movieyearerror) and !empty($moviedurationerror) and !empty($descriptionerror)) {
			$movienotice = addmovie($moviename, $movieyear, $movieduration, $description);
		}
	}
	
	if(isset($_POST["positionsubmit"])) {
		if(!empty($_POST["positioninput"])) {
			$position = test_input($_POST["positioninput"]);
		} else {
			$positionerror = "Positsioon sisestamata!";
			
		}
		if(!empty($_POST["positiondescriptioninput"])) {
			$positiondescription = test_input($_POST["positiondescriptioninput"]);
		} else {
			$positiondescriptionerror = "Positsiooni kirjeldus sisestamata!";
			
		}
		if(!empty($positionerror) and !empty($positiondescriptionerror)) {
			$positionnotice = addposition($position, $positiondescription);
		}
	}
	
	if(isset($_POST["genresubmit"])) {
		if(!empty($_POST["genreinput"])) {
			$genre = test_input($_POST["genreinput"]);
		} else {
			$genreerror = "žanr sisestamata!";
			
		}
		if(!empty($_POST["genredescriptioninput"])) {
			$genredescription = test_input($_POST["genredescriptioninput"]);
		} else {
			$genredescriptionerror = "žanri kirjeldus sisestamata!";
			
		}
		if(!empty($genreerror) and empty($genredescriptionerror)) {
			$genrenotice = addgenre($genre, $genredescription);
		}
	}
	
	if(isset($_POST["companysubmit"])) {
		if(!empty($_POST["companyinput"])) {
			$company = test_input($_POST["companyinput"]);
		} else {
			$companyerror = "Stuudio nimi sisestamata!";
		}
		if(!empty($_POST["companyaddressinput"])) {
			$companyaddress = test_input($_POST["companyaddressinput"]);
		} else {
			$companyaddresserror = "Stuudio aadress sisestamata!";
			
		}
		if(!empty($companyerror) and !empty($companyaddresserror)) {
			$companynotice = addcompany($companyname, $companyaddress);
		}
	}
	if(isset($_POST["quotesubmit"])) {
		if(!empty($_POST["quotetextinput"])) {
			$quotetext = test_input($_POST["quotetextinput"]);
		} else {
			$quoteerror = "Quote sisestamata!";
		}
	}
	require("header.php");
?>
<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Uue kasutajakonto loomine</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
   
   <ul>
    <li><a href="page.php">Avalehele</a></li>
  </ul>
  
  
  <h2>isikuandmete lisamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label for="firstnameinput">Eesnimi:</label>
	  <br>
	  <input name="firstnameinput" id="firstnameinput" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
	  <br>
	  <br>
      <label for="lastnameinput">Perekonnanimi:</label><br>
	  <input name="lastnameinput" id="lastnameinput" type="text" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
	  <br>
	  <br>
	  <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 105; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	  <br>
	<input type="submit" name="personsubmit" value="Salvesta isik">
  </form>
  <p><?php echo $personnotice; ?></p>
  
  
  
  <h2>Filmi lisamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="movienameinput">Filmi nimi: </label>
	  <input type="text" name="movienameinput" placeholder="Filminimi">
	  <span><?php echo $movienameerror; ?></span>
	  <br>
	<br>
  <label for="movieyearinput">Filmi tootmisaasta: </label>
	  <?php
	    echo '<select name="movieyearinput" id="movieyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y"); $i >= 1890; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $movieyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <span><?php echo $movieyearerror; ?></span>
	  <br>


	<label for="moviedurationinput">Filmi kestus minutites: </label>
	  <input type="number" name="moviedurationinput">
	  <span><?php echo $moviedurationerror; ?></span>
	  <br>
	<label for="descriptioninput">Kirjeldus: </label>
	  <br>
	  <textarea rows="7" cols="60" name="descriptioninput" id="descriptioninput" placeholder="Filmi lühikirjeldus ..."></textarea>
	  <span><?php echo $descriptionerror; ?></span>
	  <br>
	<input type="submit" name="filmsubmit" value="Salvesta film">
  </form>
  <p><?php echo $movienotice; ?></p>
  
  
  <h2>Lisame positsiooni</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="positioninput">Positsioon: </label>
	  <input type="text" name="positioninput" placeholder="position">
	  <span><?php echo $positionerror; ?></span>
	  <br>
	<label for="positiondescriptioninput">Positsiooni kirjeldus: </label>
	  <br>
	  <textarea rows="5" cols="40" name="positiondescriptioninput" id="positiondescriptioninput" placeholder="Positsiooni kirjeldus ..."></textarea>
	  <span><?php echo $positiondescriptionerror; ?></span>
	  <br>
	<input type="submit" name="positionsubmit" value="Salvesta positsioon">
  </form>
  <p><?php echo $positionnotice; ?></p>
  
  
  
  <h2>Lisame žanri</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="genreinput">žanr: </label>
	  <input type="text" name="genreinput" placeholder="žanr">
	  <span><?php echo $genreerror; ?></span>
	  <br>
	<label for="genredescriptioninput">žanri kirjeldus: </label>
	  <br>
	  <textarea rows="5" cols="40" name="genredescriptioninput" id="genredescriptioninput" placeholder="žanri kirjeldus ..."></textarea>
	  <span><?php echo $genredescriptionerror; ?></span>
	  <br>
	<input type="submit" name="genresubmit" value="Salvesta žanr">
  </form>
  <p><?php echo $genrenotice; ?></p>
  
  
  
  <h2>Lisame filmitootja</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="companyinput">Filmitootja: </label>
	  <input type="text" name="companyinput" placeholder="Stuudio">
	  <span><?php echo $companyerror; ?></span>
	  <br>
	<label for="companyaddressinput">Stuudio aadress: </label>
	  <input type="text" name="companyaddressinput" placeholder="Aadress">
	  <span><?php echo $companyaddresserror; ?></span>
	  <br>
	<input type="submit" name="companysubmit" value="Salvesta tootja">
  </form>
  <p><?php echo $companynotice; ?></p>
   
   <h2>Lisame Quote</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="quotetextinput">Quote: </label>
	  <input type="text" name="quotetextinput" placeholder="quote">
	  <span><?php echo $quoteerror; ?></span>
	  <br>
	  <input type="submit" name="quotesubmit" value="Salvesta quote">
  </form>
  <p><?php echo $quotenotice; ?></p>
 
  
  <p><a href="home.php">Tagasi avalehele</a></p>
  <hr>
</body>
</html>