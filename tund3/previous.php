<?php
//Loeme andmebaasi login info muutujad
require("../../../config.php");

$database = "if20_marcus_si_3";

//Loeme andmebaasist
$nonsenshtml= "";
$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
$stmt = $conn->prepare("SELECT nonsenseidea FROM nonsense");
echo$conn->error;

//Seome tulemuse mingi muutujaga
$stmt->bind_result($nonsensfromdb);
$stmt->execute();

//Võtab
while($stmt->fetch()) {
	//<p> suvaline mõte </p>
	$nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
}

//Sulgeb ühenduse
$stmt->close();
$conn->close();

require("header.php");
?>
<p></p>
<a href="new.php">Lisa uus mõte</a>
<a href="home.php">Kodulehele</a>

<br>
<br>

<p>Varasemad mõtted: </p>
<hr> <?php echo $nonsenshtml; ?>
</body>
</html>