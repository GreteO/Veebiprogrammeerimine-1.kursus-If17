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
	$userTable = "";
	
	$database = "if17_ojavgret";
	//muutujad
	$signupFirstNameFromDb = ""; 
	$signupFamilyNameFromDb = ""; 
	$emailFromDb = ""; 
	$signupBirthDateFromDb = ""; 
	$signupGenderFromDb = "";
	//$row = ""; 
	
	
	$userTable = allUsersTable();
	

		//return $notice;
	//}
	
	/*while($stmt->fetch()){
			$ideas .= '<p style="background-color: ' .$color .'">' .$idea ."</p> \n";
		}
	*/
		
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
	
	<table border="1" style="border-collapse: collapse;">
		<tr>
			<th>Eesnimi</th>
			<th>Perekonnanimi</th>
			<th>E-post</th>
			<th>Sünnipäev</th>
			<th>Sugu</th>
		</tr>
		<tr>
			<td><?php echo $signupFirstNameFromDb; ?></td>
			<td><?php echo $signupFamilyNameFromDb; ?></td>
			<td><?php echo $emailFromDb; ?></td>
			<td><?php echo $signupBirthDateFromDb; ?></td>
			<td><?php echo $signupGenderFromDb; ?></td>
		</tr>
		<tr>
			<td><?php echo $signupFirstNameFromDb; ?></td>
			<td><?php echo $signupFamilyNameFromDb; ?></td>
			<td><?php echo $emailFromDb; ?></td>
			<td><?php echo $signupBirthDateFromDb; ?></td>
			<td><?php echo $signupGenderFromDb; ?></td>
		</tr>
		
	</table>
	
	
</body>
</html>