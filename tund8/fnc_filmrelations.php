<?php
    $database = "if20_marcus_si_3";

    function readmovietoselect($selected){
        $notice = "<p>Kahjuks filme ei leitud!</p> \n";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_id, title FROM movie");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $titlefromdb);
        $stmt->execute();
        $films = "";
        while($stmt->fetch()){
            $films .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $films .=" selected";
            }
            $films .= ">" .$titlefromdb ."</option> \n";
        }
        if(!empty($films)){
            $notice = '<select name="filminput" id="filminput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
            $notice .= $films;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function readgenretoselect($selected){
        $notice = "<p>Zanre ei leitud!</p> \n";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $genrefromdb);
        $stmt->execute();
        $genres = "";
        while($stmt->fetch()){
            $genres .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $genres .=" selected";
            }
            $genres .= ">" .$genrefromdb ."</option> \n";
        }
        if(!empty($genres)){
            $notice = '<select name="filmgenreinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
            $notice .= $genres;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function readstudiotoselect($selected){
        $notice = "<p>Stuudiot ei leitud</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT production_company_id, company_name FROM production_company");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $companyfromdb);
        $stmt->execute();
        $studios = "";
        while($stmt->fetch()){
            $studios .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $studios .=" selected";
            }
            $studios .= ">" .$companyfromdb ."</option> \n";
        }
        if(!empty($studios)){
            $notice = '<select name="filmstudiosinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali stuudio</option>' ."\n";
            $notice .= $studios;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }


    function storenewgenrerelation($selectedfilm, $selectedgenre){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_genre_id FROM movie_genre WHERE movie_id = ? AND genre_id = ?");
        echo $conn->error;
        $stmt->bind_param("ii", $selectedfilm, $selectedgenre);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES(?,?)");
            echo $conn->error;
            $stmt->bind_param("ii", $selectedfilm, $selectedgenre);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function storenewstudiorelation($selectedfilm, $selectedstudio){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_by_production_company_id FROM movie_by_production_company WHERE movie_movie_id = ? AND production_company_id = ?");
        echo $conn->error;
        $stmt->bind_param("ii", $selectedfilm, $selectedstudio);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO movie_by_production_company (movie_movie_id, production_company_id) VALUES(?,?)");
            echo $conn->error;
            $stmt->bind_param("ii", $selectedfilm, $selectedstudio);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function oldreadpersoninmovie(){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt=$conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
        echo $conn->error;
        $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= "<p>" .$firstnamefromdb ." " .$lastnamefromdb;
            if(!empty($rolefromdb)){
                $notice .= " tegelane " .$rolefromdb;
            }
            $notice .= ' filmis "' .$titlefromdb .'"' ."\n";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function readpersoninmovie($sortby, $sortorder){
        $notice = "<p>Kahjuks ei leidnud filmitegelasi.</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $sqlphrase = "SELECT first_name, last_name, position_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN position ON position.position_id = person_in_movie.position_id JOIN  movie ON movie.movie_id = person_in_movie.movie_id";
        if($sortby == 0){
            $stmt = $conn->prepare($sqlphrase);
        }
        if($sortby == 4){
            if($sortorder == 1){
                $stmt = $conn->prepare($sqlphrase ." ORDER BY title");
            } else {
                $stmt = $conn->prepare($sqlphrase ." ORDER BY title DESC");
            }
        }
        
        echo $conn->error;
        $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $positionfromdb, $rolefromdb, $titlefromdb);
        $stmt->execute();
        $lines = "";
        while($stmt->fetch()){
            $lines .= "<tr> \n";
            $lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td>";
            $lines .= "\t <td>" .$positionfromdb ."</td>";
            $lines .= "\t <td>" .$rolefromdb ."</td>";
            $lines .= "\t <td>" .$titlefromdb ."</td> \n";
            $lines .= "</tr> \n";
        }
        if(!empty($lines)){
            $notice = "<table> \n";
            $notice .= "<tr> \n";
            $notice .= "<th>Isik</th><th>Roll</th>";
            $notice .= '<th>Film &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
            $notice .= "</tr> \n";
            $notice .= $lines;
            $notice .= "</table> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function readpersontoselect($selected){
        $notice = "<p>Isikut ei leitud</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT person_id, first_name, last_name FROM person");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
        $stmt->execute();
        $persons = "";
        while($stmt->fetch()){
            $persons .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $persons .=" selected";
            }
            $persons .= ">" .$firstnamefromdb ." " .$lastnamefromdb ."</option> \n";
        }
        if(!empty($persons)){
            $notice = '<select name="personinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali isik</option>' ."\n";
            $notice .= $persons;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function readpositiontoselect($selected){
        $notice = "<p>Ametikohta ei leitud</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT position_id, position_name FROM position");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $positionfromdb);
        $stmt->execute();
        $position = "";
        while($stmt->fetch()){
            $position .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $position .=" selected";
            }
            $position .= ">" .$positionfromdb ."</option> \n";
        }
        if(!empty($position)){
            $notice = '<select name="positioninput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali ametikoht</option>' ."\n";
            $notice .= $position;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function storenewpersonrelation($selectedfilm, $selectedperson, $selectedposition, $selectedrole){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT person_in_movie_id FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ? AND role = ?");
        echo $conn->error;
        $stmt->bind_param("iiis", $selectedperson, $selectedfilm, $selectedposition, $selectedrole);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id, role) VALUES(?,?,?,?)");
            echo $conn->error;
            $stmt->bind_param("iiis", $selectedperson, $selectedfilm, $selectedposition, $selectedrole);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function storenewquoterelation($selectedpersoninmovie, $selectedquote){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT quote_id FROM quote WHERE quote_text = ? AND person_in_movie_id = ?");
        echo $conn->error;
        $stmt->bind_param("si", $selectedquote, $selectedpersoninmovie);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO quote (quote_text, person_in_movie_id) VALUES(?,?)");
            echo $conn->error;
            $stmt->bind_param("si", $selectedquote, $selectedpersoninmovie);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    
    function readpersoninmovietoselect($selected){
        $notice = "<p>Kahjuks ei leidnud filmitegelasi.</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT person_in_movie_id, first_name, last_name, role, title FROM person_in_movie JOIN person ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");        
        echo $conn->error;
        $stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
        $stmt->execute();
        $personinmovie = "";
        while($stmt->fetch()){
            $personinmovie .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $personinmovie .=" selected";
            }
            $personinmovie .= ">" .$firstnamefromdb ." " .$lastnamefromdb ." - " .$rolefromdb ." - " .$titlefromdb ."</option> \n";
        }
        if(!empty($personinmovie)){
            $notice = '<select name="personinmovieinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali inimene, roll, film</option>' ."\n";
            $notice .= $personinmovie;
            $notice .= "</select> \n";
        $stmt->close();
        $conn->close();
        return $notice;
        }
    }