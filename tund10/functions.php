<?php 
	require("../../../config.php");
	$database = "if17_ojavgret";
    $target_dir = "../../pics/";
    $thumbs_dir = "../../thumbs/";
	
	//alustame sessiooni
	session_start();


	function signIn ($email, $password, $signupFirstName, $signupFamilyName){
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password FROM vplogimine WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kui vähemalt üks tulemus
		if($stmt->fetch()){
			if($password == $passwordFromDb){
				$notice = "Sisselogitud!";
				
				//määran sessiooni muutujaid
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;

				
				//lähen pealehele
				header("Location: main.php");
				exit();
				
			}else{
				$notice = "Vale salasõna";
			}
		} else {
			$notice = "Sellise e-postiga kasutajat pole";
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vplogimine (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	//Kasutajate tabel:
	
	function allUsersTable(){
		$allUsers = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT firstname, lastname, email, birthday, gender FROM vplogimine");
		$stmt->bind_result($signupFirstName, $signupFamilyName, $signupEmail, $signupBirthDate, $gender);
		$stmt -> execute();
		    echo'<table border="1" style="border-collapse: collapse;">';
			echo'<tr><th>Eesnimi</th><th>Perekonnanimi</th><th>E-post</th><th>Sünnipäev</th><th>Sugu</th></tr>';
		
		while ($stmt ->fetch()){
		   
			echo'<tr>';
		        echo'<td>' . $signupFirstName . '</td>';
		        echo'<td>' . $signupFamilyName . '</td>'; 
		        echo'<td>' . $signupEmail.'</td>';
		        echo'<td>' . $signupBirthDate . '</td>';
		        echo'<td>';                             //$gender . '</td>';
		            if ($gender ==1){
		                echo "Mees";
		            }else{
		                echo "Naine";
		            }
		        echo '</td>';
		    echo'</tr>'; 
		        
		}
		$stmt->close();
		$mysqli->close();
		return $allUsers;
			
	}
	
	//Hea mõtte salvestamise funktsioon
	function saveIdea($idea, $color){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpuserideas (userid, idea, ideacolor) VALUES(?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss", $_SESSION["userId"], $idea, $color);
		if($stmt->execute()){
			$notice = "Mõte on salvestatud!";
		} else {
			$notice = "Salvestamisel tekkis tõrge: " .$stmt->error;
		}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
	}
	
	function readAllIdeas(){
		$ideas = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas"); //absoluutselt kõigi mõtted
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE userid = ?");   //ainult ''minu'' mõtted
		$stmt = $mysqli->prepare("SELECT id, idea, ideacolor FROM vpuserideas WHERE userid = ? AND deleted IS NULL ORDER BY id DESC"); //prepare vaatab järgi kas andmebaasis on midagi võtta nende nimedega, järjekord pole oluline(id, idea jne)
		$stmt->bind_param("i", $_SESSION["userId"]); //see annab ?-le väärtuse, saadad andmebaasi
		$stmt->bind_result($id, $idea, $color); //see tuleb andmebaasist, järjekord oluline!!!
		$stmt->execute(); //käsk täidetakse
		while($stmt->fetch()){
			$ideas .= '<p style="background-color: ' .$color .'">' .$idea .' | <a href="edituseridea.php?id=' .$id .'">Toimeta</a>' ."</p> \n"; //n ei tööta kui ta on ülakomade vahel peavad olema jutumärgid
		//lisame lingi: | <a href="edituseridea.php?id=6">Toimeta</a>
		}
		
		$stmt->close();
		$mysqli->close();
		return $ideas;
	}
	
	function readLastIdea(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea FROM vpuserideas WHERE id = (SELECT MAX(id) FROM vpuserideas)");
		$stmt->bind_result($idea);
		$stmt->execute(); //käsutäitmine
		$stmt->fetch(); //saame andmed kätte
		$stmt->close();
		$mysqli->close();
		return $idea;
	}
	
//sisestuse kontrollimise funktsioon
function test_input($data){
		$data = trim($data); //liigsed tühikud, TAB, reavahetused jms
		$data = stripslashes ($data); //eemaldasb kaldkriipsud"\"
		$data = htmlspecialchars ($data);
		return $data;
	}
	
	function addPhotoData($filename, $thumbnail, $visibility){
		//echo $GLOBALS["serverHost"];
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpphotos (userid, filename, thumbnail, visibility) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("issi", $_SESSION["userId"], $filename, $thumbnail, $visibility);
		//$stmt->execute();
		if ($stmt->execute()){
		    $notice = "Foto andmete lisamine andmebaasi õnnestus";
			//$GLOBALS["notice"] .= "Foto andmete lisamine andmebaasi õnnestus! ";
		} else {
		    $notice = "Foto andmete lisamine andmebaasi ebaõnnestus";
			//$GLOBALS["notice"] .= "Foto andmete lisamine andmebaasi ebaõnnestus! ";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
/*	//UUS FUNKTSIOON

function show_name ($signupFirstName, $signupFamilyName){
        if (isset($_SESSION["firstname,lastname"]))
        echo "Tere", $_SESSION["firstname,lastname"];

} */
	
	/*
	$x = 7;
	$y = 4;
	echo "Esimene summa on: " .($x + $y) ."\n";
	addValues();
	
	function addValues(){
		echo "Teine summa on: " .($GLOBALS["x"] + $GLOBALS["y"]) ."\n";
		$a = 3;
		$b = 2;
	echo "Kolmas summa on: " .($a + $b) ."\n";
	$x = 1;
	$y = 2;
	echo "Hoopis teine summa on: " .($x + $y) ."\n";
	}
	echo "Neljas summa on: " .($a + $b) ."\n";
	*/
?>