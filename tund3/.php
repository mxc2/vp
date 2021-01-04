<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_marcus_si_3";
if(isset($_POST["submitnonsens"])) {
	if(!empty($_POST["nonsens"])){
		//andmebaasi lisamine
		//loome andmebaasi ühenduse
		$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		//valmistame ette SQL käsu
		$stmt = $conn->prepare("INSERT INTO nonsense (nonsenseidea) VALUES(?)");
		echo $conn->error;
		//s - string, i -integral, d-decimal
		$stmt->bind_param("s", $_POST["nonsens"]);
		$stmt->execute();
		//käsk ja ühendus kinni
		$stmt->close();
		$conn->close();
	}
}

//loeme andmebaasist
$nonsenshtml= "";
$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
$stmt = $conn->prepare("SELECT nonsenseidea FROM nonsense");
echo$conn->error;
//seome tulemuse mingi muutujaga
$stmt->bind_result($nonsensfromdb);
$stmt->execute();
//võtan, kuni on
while($stmt->fetch()) {
	//<p> suvaline mõte </p>
	$nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
}
$stmt->close();
$conn->close();


$username = "Marcus-Indrek Simmer";
$fulltimenow = date ("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg" ;

//vaatame, mida vormist severile saadetakse
var_dump($_POST);


require("header.php");
?>
<p></p>
<a href="http://greeny.cs.tlu.ee/~marcsim/vp/tund3/page2.php">Uus mõte</a>
<a href="http://greeny.cs.tlu.ee/~marcsim/vp/tund3/home.php">Kodulehele</a>

<hr> <?php echo $nonsenshtml; ?>
</body>
</html>