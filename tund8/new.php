<?php
//loeme andmebaasi login ifo muutujad
require("../../../config.php");

//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_marcus_si_3";
if(isset($_POST["submitnonsens"])) {
	if(!empty($_POST["nonsens"])){
		//lisamine andmebaasi
		//tehakse andmebaasiga ühendus
		$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		
		//SQL käsk valmistamine
		$stmt = $conn->prepare("INSERT INTO nonsense (nonsenseidea) VALUES(?)");
		echo $conn->error;
		
		//s - string, i -integral, d-decimal
		$stmt->bind_param("s", $_POST["nonsens"]);
		$stmt->execute();
		
		//Teeb käsu ja sulgeb ühenduse
		$stmt->close();
		$conn->close();
	}
}

require("header.php");
?>

<p> </p>
<a href="previous.php">Vaata varasemaid mõtted</a>
<a href="home.php">Kodulehele</a>
<hr>
<form method="POST">
  <label> Sisesta oma tänane mõte:</label>
  <input type ="text" name="nonsens" placeholder="Mõttekoht">
  <input type="submit" value="Saada ära!" name="submitnonsens">
  
</form>
</body>
</html>