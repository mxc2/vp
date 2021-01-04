<?php
	
	//Muutujad
	$firstname = "";
	$lastname = "";
	$gender = "";
	$email = "";
	
	
	$firstinput = "";
	$lastinput = "";
	$genderinput = "";
	$emailinput = "";
	$passwordinput = "";
	$passwordsecondinput = "";
	
	
	$firsterror = "";
	$lasterror = "";
	$gendererror = "";
	$emailerror = "";
	$passworderror = "";
	$passwordseconderror = "";
	
	//Errori väljendaja
$firsterror = "";
	if(empty($_POST["firstnameinput"]) and !empty($_POST["submit"])) {
		$firsterror = "Palun sisestage eesnimi";
	}
	
	if(empty($_POST["lastinput"]) and !empty($_POST["submit"])) {
		$lasterror = "Palun sisestage perekonna nimi";
	}
	
	if(empty($_POST["genderinput"]) and !empty($_POST["submit"])) {
		$gendererror = "Palun valige teie sugu";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastinput"]; $email = $_POST["emailinput"];
	}
	
	if(empty($_POST["emailinput"]) and !empty($_POST["submit"])) {
		$emailerror = "Palun sisestage e-mail";
	}
	
	if(empty($_POST["passwordinput"]) and !empty($_POST["submit"])) {
		$passworderror = "Palun sisestage parool";
		$passwordseconderror = "Palun sisestage parool";
	} elseif(!empty($_POST["submit"]) and ((strlen($_POST["passwordinput"]) < 8) or (strlen($_POST["passwordsecondinput"]) < 8))) {
		$passworderror = "Salasõna pole piisavalt pikk, salasõna peab olema vähemalt 8 tähemärki";
		$passwordseconderror = "Salasõna pole piisavalt pikk, salasõna peab olema vähemalt 8 tähemärki";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastinput"]; $gender = $_POST["genderinput"]; $email = $_POST["emailinput"];
	} elseif(empty($_POST["passwordsecondinput"]) and !empty($_POST["submit"]) and empty($passworderror)) {
		$passwordseconderror = "Palun sisestage parool mõlemasse lahtrisse";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastinput"]; $gender = $_POST["genderinput"]; $email = $_POST["emailinput"];
	} elseif(!empty($_POST["submit"]) and ($_POST["passwordinput"] != $_POST["passwordsecondinput"])) {
		$passworderror = "Salasõnad ei ühti!";
		$passwordseconderror = "Salasõnad ei ühti!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastinput"]; $gender = $_POST["genderinput"]; $email = $_POST["emailinput"];
	} else {
		;
	}

	require("header.php");
?>

<body>

<h1>Konto koostamine</h1>

<p><a href="home.php">Kodulehele</a></p>

<hr>

<h4>Palun sisestage andmed konto jaoks</h4>

<!--Konto Registeerimis formid -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	  <label for="firstnameinput">Eesnimi:</label>
	  <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>">
	  <span><?php echo $firsterror; ?></span>
	  
	  <br>
	  
	  <label for="lastinput">Perekonnanimi:</label>
	  <input type="text" name="lastinput" id="lastinput" value="<?php echo $lastname; ?>">
	  <span><?php echo $lasterror; ?></span>
	  
	  <br>
	  <br>
	  
	  </label><input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo "checked";} ?>><label for="gendermale">Mees<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo "checked";} ?>><label for="genderfemale">Naine</label>
	  <span><?php echo $gendererror; ?></span>
	  
	  <br>
	  <br>
	  
	  <label for="emailinput">E-posti aadress:</label>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
	  <span><?php echo $emailerror; ?></span>
	  
	  <br>
	  
	  <label for="passwordinput">Salasõna: (vähemalt 8 tähemärki)</label>
	  <input type="password" name="passwordinput" id="passwordinput">
	  <span><?php echo $passworderror; ?></span>
	  
	  <br>

	  <label for="passwordsecondinput">Salasõna teist korda:</label>
	  <input type="password" name="passwordsecondinput" id="passwordsecondinput">
	  <span><?php echo $passwordseconderror; ?></span>
	  
	  <br>
	  <br>
	  <hr>
	  
	  <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>