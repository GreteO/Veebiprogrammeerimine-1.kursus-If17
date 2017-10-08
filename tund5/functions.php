<?php 
	$database = "if17_ojavgret";
	
	//alustame sessiooni
	session_start();
	
	function signIn ($email, $password, $signupFirstName, $signupFamilyName){
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password, firstname, lastname FROM vplogimine WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $signupFirstNameFromDb, $signupFamilyNameFromDb);
		$stmt->execute();
		
		//kui vähemalt üks tulemus
		if($stmt->fetch()){
			if($password == $passwordFromDb){
				$notice = "Sisselogitud!";
				
				//määran sessiooni muutujaid
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["firstname"] = $signupFirstNameFromDb;
				$_SESSION["lastname"] = $signupFamilyNameFromDb;
				
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
	}

//sisestuse kontrollimise funktsioon
function test_input($data){
		$data = trim($data); //liigsed tühikud, TAB, reavahetused jms
		$data = stripslashes ($data); //eemaldasb kaldkriipsud"\"
		$data = htmlspecialchars ($data);
		return $data;
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