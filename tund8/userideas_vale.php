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
		
		//kas vajutati mõtte salvestamise nuppu
		if(isset($_POST["ideaBtn"])){
			echo "Jama";
			if(isset($_POST["userIdea"]) and isset($_POST["ideaColor"]) and !empty($_POST["userIdea"]) and !empty($_POST["ideaColor"])){
				echo $_POST["ideaColor"];
			}
			
		}
	
	echo "Jama";
	//muutuja
	//$notice = "";
	
	/*$database = "if17_ojavgret";
	//muutujad
	$signupFirstNameFromDb = ""; 
	$signupFamilyNameFromDb = ""; 
	$emailFromDb = ""; 
	$signupBirthDateFromDb = ""; 
	$signupGenderFromDb = "";
	$row = ""; 
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		if ($stmt = $mysqli->query("SELECT firstname, lastname, email, birthday, gender(WHERE 1= mees AND 2= naine) FROM vplogimine")){
		    $stmt -> execute();
		    $stmt->bind_result($signupFirstNameFromDb, $signupFamilyNameFromDb, $emailFromDb, $signupBirthDateFromDb, $signupGenderFromDb);
		
		    while ($row = mysqli_fetch_array($stmt)){
		        $signupFirstNameFromDb = $row["firstname"]; 
		        $signupFamilyNameFromDb = $row["lastname"]; 
		        $emailFromDb = $row["email"]; 
		        $signupBirthDateFromDb = $row["birthday"]; 
		        $signupGenderFromDb = $row["gender"]; 
		        
		    }
		
		    $stmt->close();
		}
		$mysqli->close();
		//return $notice;
	//}
		
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
	<h2>Head mõtted</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Hea mõte: </label>
		<input name="userIdea" type="text">
		<br>
		<label> Mõttega seostuv värv: </label>
		<input name="ideaColor" type="color">
		<br>
		<input name="ideaBtn" type="submit" value="Salvesta mõte!">
	</form>
	
	
	
</body>
</html>