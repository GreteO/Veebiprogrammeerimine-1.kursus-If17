<?php

		require("functions.php");
		require("../../../config.php");
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
	$signupFirstNameFromDb = "";
	$signupFamilyNameFromDb = "";
	
$database = "if17_ojavgret";   
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		if ($stmt = $mysqli->prepare("SELECT firstname, lastname FROM vplogimine WHERE id=".$_SESSION["userId"])){
            $stmt->execute();
		    $stmt->bind_result($signupFirstNameFromDb, $signupFamilyNameFromDb);
            while ($stmt -> fetch()){
		        $signupFirstNameFromDb; 
		        $signupFamilyNameFromDb;
		        }
		    
		
		    $stmt->close();
        }
		$mysqli->close();

	
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	

	
	$allFiles = array_slice(scandir($picDir), 2);
	foreach ($allFiles as $file) {
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array ($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}//foreach lõppeb
	
	//var_dump($allFiles);  näitab veebilehel 
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles);
	$picNumber = mt_rand(0, $picFileCount -1);
	$picFile = $picFiles[$picNumber];
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
		echo $signupFirstNameFromDb ." " .$signupFamilyNameFromDb;
	?>
	</h1>
	<p>Tere!<p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="usersInfo.php">Info kasutajate kohta</a></p>
	<p><a href="usersideas.php">Kasutaja head mõtted</a></p>
	<p><a href="picsupload.php">Piltide üleslaadimine</a></p>
	<img src="<?php echo $picDir .$picFile; ?>" alt="Tallinna ülikool">
	
</body>
</html>