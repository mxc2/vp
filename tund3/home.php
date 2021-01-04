<?php
$username = "Marcus-Indrek Simmer";
$time = date ("H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg" ;
$dayofmonth = date ("d");
$year = date ("Y");


$weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow;
$monthnow = date("m");

if($hournow < 6){
	$partofday = "time to sleep";
}
if($hournow >= 7 and $hournow < 8) {
	$partofday = "time For Morning fun";
}
if($hournow >= 8 and $hournow < 16) {
	$partofday = "time to study";
}
if($hournow >= 16 and $hournow < 21) {
	$partofday = "time to work";
}
if($hournow >= 21 and $hournow < 0) {
	$partofday = "freetime";
}

//Sisestame semestri alguse ja lõpu kuupäevad
$semesterstart = new DateTime("2020-8-31");
$semesterend = new DateTime("2020-12-13");

//Võrdleb kas semester on alguses, lõpus või käib
$semesterduration = $semesterstart->diff($semesterend);

//Saab praeguse aja
$today = new DateTime("now");
$fromsemesterstart = $semesterstart->diff($today);
$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
$fromsemesterend = $semesterend->diff($today);
$fromsemesterenddays = $fromsemesterend->format("%r%a");
$semesterprocent = 100*$fromsemesterstartdays/103;

//Võtab 
$dir = '../vp_pics/';
$imgs_arr = array();
if (file_exists($dir) && is_dir($dir) ) {
    // Run code if the directory exists
 }

$dir_arr = scandir($dir);
$arr_files = array_diff($dir_arr, array('.','..') );
foreach ($arr_files as $file) {
  //Get the file path
  $file_path = $dir."/".$file;
  // Get extension
  $ext = pathinfo($file_path, PATHINFO_EXTENSION);
  if ($ext=="jpg" || $ext=="png" || $ext=="JPG" || $ext=="PNG") {
    array_push($imgs_arr, $file);
  }
  
}

//Random pildi valija
$count_img_index = count($imgs_arr) - 1;
$random_img = $imgs_arr[rand( 0, $count_img_index )];

require("header.php");
?>

<img style="max-width: 550px; max-height: 400px" src="../img/rallybanner.jpg" alt="Banner with a rally car">

<!-- Linebreakid -->
<br>
<br>

<!-- Lingid teistele lehtedele -->
<ul>
	<li><a href="new.php">Lisa uus mõte </a></li>
	<li><a href="previous.php"> Vaata varasemaid mõtted</a></li>
</ul>
 
<!-- Võtab username value ja lisab selle enne teksti -->
<h1><?php echo $username; ?> programmeerib veebi....vist</h1>

<!-- Lihtsalt tekst kus ka hüperlink -->
<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
<p>Lehte on palju downgraditud peale tundi 2, et aidata kaasa kodutöödega. Tänu sellele ei näe leht ka nii eriline välja.</p>

<!-- Linebreakid -->
<br>
<br>
  
<!-- Võtavad erinevaid valuesid ja panevad ekraanile -->
<p> Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow-1].", ". $dayofmonth.". ". $monthnameset[$monthnow-1]." ". $year .", kell ".$time .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. </p>

<p> Semester on <?php if($fromsemesterenddays < 0){
	echo($semesteropen = "käimas, ");}
	else {echo("läbi. ");}	
	echo number_format($semesterprocent, 1);?>% semestrist on läbitud ja semestri lõpuni on <?php echo $fromsemesterenddays*-1 ?> päeva. </p>

<!-- Linebreakid -->
<br>
<br>
	
<p><?php echo "It is " .$partofday. "."; ?> </p>

<p>Suvaline pilt mille lehe valis ise:</p>

<img src="<?php echo $dir."/".$random_img ?>">

<p>Made by Marcus-Indrek Simmer 2020</p>

</form>
</body>
</html>




