<?php
	//muutujad
	$myName = "Grete";
	$myFamilyName = "Ojavere";
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	//var_dump($monthNamesET);
	//echo $monthNamesET[8];
	$monthNow = $monthNamesET[date("n") - 1];
	
	$hourNow = date("H");
	
	$schoolDayStart = date("d.m.Y") ." " ."8.15";
	$schoolBegin = strtotime($schoolDayStart);
	$timeNow = strtotime("now");
	//echo ($timeNow - $schoolBegin);
	$minutesPassed = round(($timeNow - $schoolBegin) / 60);
	//echo ($minutesPassed);
	//echo $hourNow;
	//võrdlen kellaaega ja annan hinnangu, mis päeva osaga on tegemist (> < == võrdne >= suuremvõrdne <=väiksem võrdne !=ei ole võrdne)
	$partOfDay = "";
	if ( $hourNow < 8) {
		$partOfDay = "Varajane hommik";
	}
	//echo $partOfDay;
	if ( $hourNow >= 8 and $hourNow < 16 ) {
		$partOfDay = "koolipäev";
	}
	if ($hourNow >= 16) {
		$partOfDay = "Vaba aeg";
	}
	
	//vanusega tegelemine
	//var_dump($_POST);
	//echo $_POST["birthYear"];
	$myBirthYear;
	$ageNotice = "";
	if (isset($_POST["birthYear"]) and $_POST["birthYear"] !=0) {
		$myBirthYear = $_POST["birthYear"];
		$myAge = date("Y") - $_POST["birthYear"];
		$ageNotice ="<p>Te olete umbkaudu " .$myAge ." aastat vana.</p>";
		
		$ageNotice  .="<p> Olete elanud järgnevatel aastatel:</p> <ol>";
		for ($i = $myBirthYear; $i <= date("Y"); $i ++){
			$ageNotice .= "<li>" .$i ."</li>";
		}
		$ageNotice .= "</ol>";
	}
	
	//tsükkel 
	//tingimused tavasulgudes, massiiv kandilistes sulgudes, kui midagi juhtub loogelised sulud
	/* bloki kommentaar*/
	/*for ($i = 0; $i < 5; $i ++){
		echo "ha";
	}*/
		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Grete Ojavere veebiprogrammeerimine</title>
</head>
<body>
	<h1>
	<?php
		echo $myName ." " .$myFamilyName;
	?>
	</h1>
	<p>Tere!<p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<?php
		echo "<p>Kõige esimene PHP abil väljastatud sõnum.</p>";
		echo "<p>Täna on ";
		echo date("d. ") .$monthNow .date(" Y") . ", käes on " .$partOfDay;
		echo ".<p/>";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .".<p/>";

 	?>
	<h2>Natuke vanusest</h2>
	<form method = "POST">
			<label>Teie sünniaasta: </label>
			<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear; ?>" min="1900" max="2017">
			<input name="submitbirthYear" type ="submit" value="Sisesta">
		
	</form>
	<?php
		if ($ageNotice != ""){
			echo $ageNotice;
		}
	?>
	
</body>
</html>