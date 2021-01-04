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
    require("header.php");
    require("fnc_filmrelations.php");
    require("fnc_common.php");
	
	$database = "if20_marcus_si_3";
    //kas vajutati salvestus nuppu
    $genrenotice = "";
    $studionotice = "";
    $selectedfilm = "";
    $selectedgenre = "";
    $selectedstudio = "";
    $personnotice = "";
    $selectedperson = "";
    $selectedrole = "";
    $selectedposition = "";
    $role = "";
    $quotenotice = "";
    $selectedquote = "";
    $selectedmovieperson = "";

    if(isset($_POST["filmrelationsubmit"])){
      //$selectedfilm = $_POST["filminput"];
      if(!empty($_POST["filminput"])){
          $selectedfilm = intval($_POST["filminput"]);
      } else {
          $genrenotice = " Vali film!";
      }
      if(!empty($_POST["filmgenreinput"])){
          $selectedgenre = intval($_POST["filmgenreinput"]);
      } else {
          $genrenotice .= " Vali žanr!";
      }
      if(!empty($selectedfilm) and !empty($selectedgenre)){
          $genrenotice = storenewgenrerelation($selectedfilm, $selectedgenre);
      }
    }

    if(isset($_POST["filmstudiorelationsubmit"])){
        if(!empty($_POST["filminput"])){
            $selectedfilm = intval($_POST["filminput"]);
        } else {
            $studionotice = " Vali Film!";
        }
        if(!empty($_POST["filmstudiosinput"])){
            $selectedstudio = intval($_POST["filmstudiosinput"]);
        } else {
            $studionotice .= " Vali Stuudio!";
        }
        if(!empty($selectedfilm) and !empty($selectedstudio)){
            $studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
        }
    }

    if(isset($_POST["personinmovierelationsubmit"])){
        if(!empty($_POST["filminput"])){
            $selectedfilm = intval($_POST["filminput"]);
        } else {
            $personnotice .= " Vali Film!";
        }
        if(!empty($_POST["personinput"])){
            $selectedperson = intval($_POST["personinput"]);
        } else {
            $personnotice .= " Vali Isik!";
        }
        if(!empty($_POST["positioninput"])){
            $selectedposition = intval($_POST["positioninput"]);
        } else {
            $personnotice .= " Vali Ametikoht!";
        }
        if(!empty($_POST["roleinput"])){
            $selectedrole = test_input($_POST["roleinput"]);
        } elseif($_POST["positioninput"] === "2") {
            $selectedrole = "Režissöör";
        } else {
            $personnotice .= " Lisa Roll!";
        }
        if(!empty($selectedfilm) and !empty($selectedperson) and !empty($selectedposition) and !empty($selectedrole)){
            $personnotice = storenewpersonrelation($selectedfilm, $selectedperson, $selectedposition, $selectedrole);
        }
    }

    if(isset($_POST["quoterelationsubmit"])){
        if(!empty($_POST["personinmovieinput"])){
            $selectedmovieperson = intval($_POST["personinmovieinput"]);
        } else {
            $quotenotice .= " Vali Isik, roll, film!";
        }
        if(!empty($_POST["quoteinput"])){
            $selectedquote = test_input($_POST["quoteinput"]);
        } else {
            $quotenotice .= "Lisa tsitaat!";
        }
        if(!empty($selectedmovieperson) and !empty($selectedquote)){
            $quotenotice = storenewquoterelation($selectedmovieperson, $selectedquote);
        }
    }
    
    $filmselecthtml = readmovietoselect($selectedfilm);
    $filmgenreselecthtml = readgenretoselect($selectedgenre);
    $filmstudiotoselecthtml = readstudiotoselect($selectedstudio);
    $personinmovieselecthtml = readpersontoselect($selectedperson);
    $positionselecthtml = readpositiontoselect($selectedposition);
    $moviepersonselecthtml = readpersoninmovietoselect($selectedmovieperson);
?>
    </head>
    <body>
        <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
        <hr>
        <div class="topnav">
            <a href="home.php">Kodu</a>
            <a href="writethoughts.php">Kirjuta mõtteid</a>
            <a href="thoughts.php">Loe mõtteid</a>
            <a href='listfilms.php'>Filmide nimekiri</a>
            <a href="listfilmpersons.php">Näitlejad</a>
            <a href='addfilms.php'>Lisa filme</a>
            <a class='active' href="filmrelations.php">Filmi seosed</a>
            <a href="movieinfo.php">Filmi info</a>
            <a href="addandmed.php">Lisa infot</a>
            <a href="userprofile.php">Profiil</a>
            <a href="https://github.com/karljanar/vp">GitHub</a>
            <p><a href="?logout=1">Logi välja</a></p>
        </div>
        <hr>

        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Seos filmi ja zanri vahel: </label>
            <?php
                echo $filmselecthtml;
                echo $filmgenreselecthtml;
            ?>
        <input type="submit" name="filmrelationsubmit" value="Salvesta"><span><?php echo $genrenotice; ?></span>
        <hr>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Seos filmi ja stuudio vahel: </label>
            <?php
                echo $filmselecthtml;
                echo $filmstudiotoselecthtml;
            ?>
        <input type="submit" name="filmstudiorelationsubmit" value="Salvesta"><span><?php echo $studionotice; ?></span>
        <hr>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Seos filmi ja isiku vahel: </label>
            <?php
                echo $filmselecthtml;
                echo $personinmovieselecthtml;
                echo $positionselecthtml;
            ?>
        <input type="text" name="roleinput" placeholder="Roll">
        <input type="submit" name="personinmovierelationsubmit" value="Salvesta"><span><?php echo $personnotice; ?></span>
        <hr>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Tsitaat: </label>
            <?php
                echo $moviepersonselecthtml;
            ?>
            <input type="text" name="quoteinput" placeholder="Tsitaat">
        <input type="submit" name="quoterelationsubmit" value="Salvesta"><span><?php echo $quotenotice; ?></span>
    </body>
</html>
