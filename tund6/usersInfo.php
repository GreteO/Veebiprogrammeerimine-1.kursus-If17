<?php
require("../../../config.php");
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
	
	//muutuja
	//$notice = "";
	$allUsers = "";
	$signupFirstName = ""; 
	$signupFamilyName = ""; 
	$signupEmail = ""; 
	$signupBirthDate = ""; 
	$gender = "";
	
		
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
	<p>Tere! <p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<h2>Kõik registreeritud kasutajad</h2>
	<?php echo allUsersTable();?>
	
			

	
	
</body>
</html>