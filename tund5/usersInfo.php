<?php

		require("functions.php");
		//kui pole sisse logitud, liigume login lehele
		if(!isset($_SESSION["userId"])){
			header("Location: uus_login1.php");
			exit();
		}
		
		//väljalogimine
		if(isset($_GET["logout"])){
			session_destroy(); //lõpetab sesiooni
			header("Location: uus_login1.php");
		}
		
	//muutujad
	$myName = "Grete";
	$myFamilyName = "Ojavere";
	
	
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
	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="main.php">Pealeht</a></p>
	
	<table border="1" style="border-collapse: collapse;">
		<tr>
			<th>Eesnimi</th>
			<th>Perekonnanimi</th>
			<th>Kasutajanimi</th>
		</tr>
		<tr>
			<td>Grete</td>
			<td>Ojavere</td>
			<td>ojagre@tlu.ee</td>
		</tr>
		<tr>
			<td>Mari</td>
			<td>Maasikas</td>
			<td>mari@tlu.ee</td>
		</tr>
		
	</table>
	
	
</body>
</html>