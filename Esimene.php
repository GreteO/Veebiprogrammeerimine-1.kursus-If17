<?php
	//muutujad
	$myName = "Grete";
	$myFamilyName = "Ojavere";
	
	$hourNow = date("H");
	
	$schoolDayStart = date("d.m.Y") ." " ."8.15";
	$schoolBegin = strtotime($schoolDayStart);
	$timeNow = strtotime("now");
	//echo ($timeNow - $schoolBegin);
	$minutesPassed = round(($timeNow - $schoolBegin) / 60);
	echo ($minutesPassed);
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
		echo date("d.m.Y") . ", käes on " .$partOfDay;
		echo ".<p/>";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .".<p/>";

 	?>

</body>
</html>