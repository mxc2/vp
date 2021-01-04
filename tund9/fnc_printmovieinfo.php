<?php
  $database = "if20_marcus_si_3";
  
  function printpersonsinfilm($sortby, $sortorder) {
	  $notice = "<p>Kahjuks ei leitud andmebaasidest inimesi filmides.</p> \n";
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  $SQLsentence = "SELECT first_name, last_name, position_name, role, title, company_name, production_year FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id JOIN position ON position.position_id = person_in_movie.position_id JOIN movie_by_production_company ON movie_by_production_company.movie_movie_id = movie.movie_id JOIN production_company ON movie_by_production_company.production_company_id = production_company.production_company_id";

		if($sortby == 0 and $sortorder == 0) {
		  $stmt = $conn->prepare($SQLsentence);
	    }
		if($sortby == 1 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name"); 
		}
		if($sortby == 1 and $sortorder == 2) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC"); 
		}
		if($sortby == 2 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY position_name");
		}
		if($sortby == 2 and $sortorder == 2) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY position_name DESC");
		}
		if($sortby == 3 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY title"); 
	    }
		if($sortby == 3 and $sortorder == 2) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC"); 
		}
		if($sortby == 4 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY production_year"); 
		}
		if($sortby == 4 and $sortorder == 2) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY production_year DESC"); 
		}
		if($sortby == 5 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY company_name"); 
		}
		if($sortby == 5 and $sortorder == 2) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY company_name DESC"); 
		}
	  
	  $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $positionfromdb, $rolefromdb, $titlefromdb, $yearfromdb, $companyfromdb);
	  $stmt->execute();
	  $lines = "";
	  
	  while($stmt->fetch()) {
		  $lines .= "<tr>\n<td>" .$firstnamefromdb . " " .$lastnamefromdb ."</td>\n";
		  
		  if(!empty($rolefromdb)) {
			  $lines .= "<td>" .$positionfromdb ." (" .$rolefromdb .")" ."</td>\n";
		  }
		  if(empty($rolefromdb)) {
			  $lines .= "<td>" .$positionfromdb ."</td>\n";
		  }
		  
		  $lines .= "<td>" .$titlefromdb ."</td>\n";
		  $lines .= "<td>" .$yearfromdb ."</td>\n";
		  
		  if(!empty($companyfromdb)) {
			$lines .= "<td>" .$companyfromdb ."</td>\n</tr>\n";
		  }
		  if(empty($companyfromdb)) {
			$lines .= "<td> </td>\n</tr>\n";
		  }
		  
	  }
	  if(!empty($lines)) {
		  $notice = "<table>\n<tr>\n" .'<th>Nimi &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=1&sortorder=2">&darr;</a></th>';
		  $notice .= "\n" .'<th>Roll &nbsp;<a href="?sortby=2&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=2&sortorder=2">&darr;</a></th>';
		  $notice .= "\n" .'<th>Filmi Pealkiri &nbsp;<a href="?sortby=3&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=3&sortorder=2">&darr;</a></th>';
		  $notice .= "\n" .'<th>Filmi tootja &nbsp;<a href="?sortby=5&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=5&sortorder=2">&darr;</a></th>' ."\n";
		  $notice .= "\n" .'<th>Aasta &nbsp;<a href="?sortby=4&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=4&sortorder=2">&darr;</a></th>';
		  $notice .= "</tr>\n" .$lines ."</table>\n";
	  }
	  
	  $stmt->close();
	  $conn->close();
	  return $notice;
  }

  function printpersons($sortby, $sortorder) {
	$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$notice = "<p>Isikuid ei leitud kahjuks andmebaasist.</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT first_name, last_name, birth_date FROM person";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby == 1 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY first_name");
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY first_name DESC"); 
	}
	if($sortby == 2 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY last_name"); 
	}
	if($sortby == 2 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC");
	}
	if($sortby == 3 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY birth_date"); 
	}
	if($sortby == 3 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY birth_date DESC");
	}

	
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $birthfromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$birthdate = substr($birthfromdb, 8, 2);
		$birthmonth = substr($birthfromdb, 5, 2);
		$birthyear = substr($birthfromdb, 0, 4);
		$lines .= "<tr>\n<td>" .$firstnamefromdb ."</td>\n";
		$lines .= "<td>" .$lastnamefromdb ."</td>\n";
		$lines .= "<td>" .$birthdate .". " .$monthnameset[$birthmonth - 1] ." " .$birthyear ."</td>\n</tr>\n";	
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n" .'<th>Eesnimi &nbsp;<a href="?personsortby=1&personsortorder=1">&uarr;</a>&nbsp;<a href="?personsortby=1&personsortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Perekonnanimi &nbsp;<a href="?personsortby=2&personsortorder=1">&uarr;</a>&nbsp;<a href="?personsortby=2&personsortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Sünnikuupäev &nbsp;<a href="?personsortby=3&personsortorder=1">&uarr;</a>&nbsp;<a href="?personsortby=3&personsortorder=2">&darr;</a></th>' ."\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function printfilms($sortby, $sortorder) {
	$notice = "<p>Filme ei leitud kahjuks andmebaasist.</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT title, production_year, duration, description FROM movie";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	
	if($sortby == 1 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY title"); 
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC"); 
	}
	if($sortby == 2 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY production_year"); 
	}
	if($sortby == 2 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY production_year DESC"); 
	}
	if($sortby == 3 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY duration"); 
	}
	if($sortby == 3 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY duration DESC");  
	}

	$stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $descfromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$lines .= "<tr>\n<td>" .$titlefromdb ."</td>\n";
		$lines .= "<td>" .$yearfromdb ."</td>\n";
		$lines .= "<td>" .$durationfromdb ."min</td>\n";
		if(!empty($descfromdb)) {
			$lines .= "<td>" .$descfromdb ."</td>\n</tr>\n";
		}
		if(empty($descfromdb)) {
			$lines .= "<td> </td>\n</tr>\n";
		}	
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n" .'<th>Pealkiri &nbsp;<a href="?filmsortby=1&filmsortorder=1">&uarr;</a>&nbsp;<a href="?filmsortby=1&filmsortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Aasta &nbsp;<a href="?filmsortby=2&filmsortorder=1">&uarr;</a>&nbsp;<a href="?filmsortby=2&filmsortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Kestus &nbsp;<a href="?filmsortby=3&filmsortorder=1">&uarr;</a>&nbsp;<a href="?filmsortby=3&filmsortorder=2">&darr;</a></th>';
		$notice .= "\n<th>Kirjeldus</th>\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

  function printquotes($sortby, $sortorder) {
	$notice = "<p>Tsistaate ei leitud kahjuks andmebaasist.</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT first_name, last_name, role, title, quote_text FROM quote JOIN person_in_movie ON quote.person_in_movie_id = person_in_movie.person_in_movie_id JOIN person ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby == 1 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY role");
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY role DESC"); 
	}
	if($sortby == 2 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY last_name"); 
	}
	if($sortby == 2 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC");  
	}
	if($sortby == 3 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY title"); 
	}
	if($sortby == 3 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC"); 
	}

	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb, $quotefromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$lines .= "<tr>\n<td>" .'"' .$quotefromdb .'"' ."</td>\n";
		$lines .= "<td>" .$rolefromdb ."</td>\n";
		$lines .= "<td>" .$firstnamefromdb . " " .$lastnamefromdb ."</td>\n";
		$lines .= "<td>" .$titlefromdb ."</td>\n</tr>\n";		
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n<th>Tsitaat</th>";
		$notice .= "\n" .'<th>Roll &nbsp;<a href="?quotesortby=1&quotesortorder=1">&uarr;</a>&nbsp;<a href="?quotesortby=1&quotesortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Näitleja &nbsp;<a href="?quotesortby=2&quotesortorder=1">&uarr;</a>&nbsp;<a href="?quotesortby=2&quotesortorder=2">&darr;</a></th>';
		$notice .= "\n" .'<th>Film &nbsp;<a href="?quotesortby=3&quotesortorder=1">&uarr;</a>&nbsp;<a href="?quotesortby=3&quotesortorder=2">&darr;</a></th>' ."\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function printgenres($sortby, $sortorder) {
	$notice = "<p>Kahjuks žanreid ei leitud andmebaasist</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT genre_name, description FROM genre";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby == 1 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY genre_name"); 
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY genre_name DESC"); 
	}
	
	$stmt->bind_result($namefromdb, $descfromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$lines .= "<tr>\n<td>" .$namefromdb ."</td>\n";
		if(!empty($descfromdb)) {
			$lines .= "<td>" .$descfromdb ."</td>\n</tr>\n";
		}
		if(empty($descfromdb))  {
			$lines .= "<td> </td>\n</tr>\n";
		}	
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n" .'<th>Žanri nimi &nbsp;<a href="?genresortby=1&genresortorder=1">&uarr;</a>&nbsp;<a href="?genresortby=1&genresortorder=2">&darr;</a></th>';
		$notice .= "\n<th>Kirjeldus</th>\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function printpositions($sortby, $sortorder) {
	$notice = "<p>Positsiooni ei leitud kahjuks andmebaasidest.</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT position_name, description FROM position";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby == 1 and $sortorder == 1) {
		  $stmt = $conn->prepare($SQLsentence ." ORDER BY position_name"); 
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY position_name DESC"); 
	}
	
	$stmt->bind_result($namefromdb, $descfromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$lines .= "<tr>\n<td>" .$namefromdb ."</td>\n";
		if(!empty($descfromdb)) {
			$lines .= "<td>" .$descfromdb ."</td>\n</tr>\n";
		}
		if(empty($descfromdb)) {
			$lines .= "<td> </td>\n</tr>\n";
		}	
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n" .'<th>Positsioon &nbsp;<a href="?positionsortby=1&positionsortorder=1">&uarr;</a>&nbsp;<a href="?positionsortby=1&positionsortorder=2">&darr;</a></th>';
		$notice .= "\n<th>Kirjeldus</th>\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function printstudios($sortby, $sortorder) {
	$notice = "<p>Filmitootjaid ei leitud kahjuks andmebaasidest.</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$SQLsentence = "SELECT company_name, company_address FROM production_company";

	if($sortby == 0 and $sortorder == 0) {
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby == 1 and $sortorder == 1) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY company_name"); 
	}
	if($sortby == 1 and $sortorder == 2) {
		$stmt = $conn->prepare($SQLsentence ." ORDER BY company_name DESC"); 
	}

	
	$stmt->bind_result($namefromdb, $addressfromdb);
	$stmt->execute();
	$lines = "";
	
	while($stmt->fetch()) {
		$lines .= "<tr>\n<td>" .$namefromdb ."</td>\n";
		if(!empty($addressfromdb)) {
			$lines .= "<td>" .$addressfromdb ."</td>\n</tr>\n";
		}
		if(empty($addressfromdb)) {
			$lines .= "<td> </td>\n</tr>\n";
		}	
	}
	if(!empty($lines)) {
		$notice = "<table>\n<tr>\n" .'<th>Filmitootja nimi &nbsp;<a href="?studiosortby=1&studiosortorder=1">&uarr;</a>&nbsp;<a href="?studiosortby=1&studiosortorder=2">&darr;</a></th>';
		$notice .= "\n<th>Aadress</th>\n";
		$notice .= "</tr>\n" .$lines ."</table>\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

