<?php
	// Vajalik lehe last update counteri jaoks
	$file = "home.php";
	$lastmodifiedtimestamp = filemtime($file);
	$lastmodifieddatetime = date("d.M.Y H:i", $lastmodifiedtimestamp);
	//Tunnis
	$username = "Marcus-Indrek Simmer";
	$hournow = date("H");
	$partofday = "lihtsalt aeg";
	if($hournow < 6){
		$partofday = "uneaeg";
	}
	
	if($hournow >= 6 and $hournow < 8){
		$partofday = "hommikuste protseduuride aeg";
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8"> 
	<link rel="stylesheet" href="style.css">
	<title>Coronaverse</title>

</head>
<body>
	
	<!--Kuna mul on varem olnud kogemusi veebiprogrammeerimisega, kuigi suhtelistelt vähe, ainult paar tundi siis ma tahtsin uusi asju proovida (n. video background, list jne) ja koostasin selle lehe koos w3schools abiga-->
	<!-- Loodan, et teile meeldib see leht. Kuna mulle meeldis seda teha :) -->
	
	<!-- Video Background -->
	<video autoplay muted loop id="Corona">
		<source src="..\vid\corona.mp4" type="video/mp4">
	</video>
	
	<div class="content">
		<h1 id="center">Coronaverse</h1>
		<h4 id="center">Facts you should know about Covid-19</h4>
		<ul>
			<li>Coronavirus can spread from person to person just by talking, because corona dosen't only live at the bottom of the lungs but also at the top.</li>
			<li>The incubation period for COVID-19 (i.e. the time between exposure to the virus and onset of symptoms) is currently estimated to be between one and 14 days.</li>
			<li>Preliminary data from the countries with available data show that around 20-30% of diagnosed COVID-19 cases are hospitalised and 4% have severe illness. </li>
		</ul>
		<p>This website has been created for TLÜ school work, but all of the facts are from trusted sources which you can visit <a href="https://www.ecdc.europa.eu/en/covid-19/facts/questions-answers-basic-facts"> here. </a></p>
		<p>Creator: Informaatika tudeng <?php echo $username; ?> 2020</p>
		<br>
		<p id="center">Lehte viimati uuendati: <?php echo $lastmodifieddatetime ?> </p>
		
		<img src="..img\vp_banner.png" alt="Banner Veebiprogrammeerimine">
	</div>

</body>
</html>