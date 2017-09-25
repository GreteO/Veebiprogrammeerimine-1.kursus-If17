<?php
	require("../../../config.php");
	//echo $serverHost;
	
    $myLoginEmail;
    $gender;
    $myFirstName;
    $myFamilyName;
	
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	$signupPassword = null;
	
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
    
    if (isset($_POST["loginEmail"]) and $_POST["loginEmail"] !=0) {
    $myLoginEmail = $_POST["loginEmail"];
    }
    if (isset ($_POST["signupFirstName"])){
		if (empty($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFirstName = $_POST["signupFirstName"];
		}
	}
    //$myFirstName = $_POST["signupFirstName"];
    //}
    if (isset($_POST["signupFamilyName"]) and $_POST["signupFamilyName"] !=0) {
    $myFamilyName = $_POST["signupFamilyName"];
    }
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	//kas sünnikuu on valitud
	/*if(isset($POST["signupBirthMonth"])){
		$signupBirthMonth = $POST["signupBirthMonth"]; 
		echo $signupBirthMonth;
	}*/
	if (isset ($_POST["signupBirthMonth"])){
		$signupBirthMonth = $_POST["signupBirthMonth"];
		//echo $signupBirthMonth;
	}
	
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
	if (isset ($_POST["signupBirthDay"]) and isset ($_POST["signupBirthMonth"])and isset ($_POST["signupBirthYear"])){
		//kontrollin kuupäeva valiidsust
		if(checkdate(intval($_POST["signupBirthMonth"]),intval($_POST["signupBirthDay"]),intval($_POST["signupBirthYear"]))) {
			$birthDate = date_create(intval($_POST["signupBirthMonth"]) ."/" .intval($_POST["signupBirthDay"]) ."/" .intval($_POST["signupBirthYear"]));
			$signupBirthDate = date_format($birthDate, "Y-m-d");
			//echo $signupBirthDate;
		} else {
			$signupBirthDayError .= "Kuupäev ei vasta nõuetele";
		}
	}
	
    if (isset($_POST["signupEmail"]) and $_POST["signupEmail"] !=0) {
    $mysignupEmail = $_POST["signupEmail"];
    }
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			//$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				//$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	
	//KIRJUTAN UUE KASUTAJA ANDMEBAASI
	if(empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError)) {
		echo "Hakkan salvestama! \n";
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		//echo $signupPassword;
	
		//ühendus serveriga
		$database = "if17_ojavgret";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		//käsk andmebaasile
		$stmt = $mysqli->prepare("INSERT INTO vplogimine (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli ->error;
		//s - string(tekst)
		//i - integer (täisarv)
		//d - decimal (ujukomaarv)
		$stmt ->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute()
		if ($stmt->execute()){
			echo "Õnnestus";
		} else {
			echo "Tekkis viga: " .$stmt->error;
		}
	}
	
	
	
	//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	//Tekitame sünnikuu valiku
	/*$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' ."\n";
	foreach ($monthNamesET as $key=>$month) {
		if ($key + 1 === $signupBirthMonth){
			$signupMonthSelectHTML .= '<option value="' .($key +1) .'" selected>' .$month ."</option> \n";
		} else {
			$signupMonthSelectHTML .= '<option value="' .($key +1) .'">' .$month ."</option> \n";
		}
	}
	$signupMonthSelectHTML .= "</select> \n";*/
	
	//Tekitame sünnikuu valiku
	$signupMonthSelectHTML = "";
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' ."\n";
	foreach ($monthNamesET as $key=>$month){
		if ($key + 1 === $signupBirthMonth){
			$signupMonthSelectHTML .= '<option value="' .($key + 1) .'" selected>' .$month .'</option>' ."\n";
		} else {
		$signupMonthSelectHTML .= '<option value="' .($key + 1) .'">' .$month .'</option>' ."\n";
		}
	}
	$signupMonthSelectHTML .= "</select> \n";
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
	}
	$signupYearSelectHTML.= "</select> \n";
	
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>Log in</title>
</head>
<body>
   <h2>Uus kasutaja</h2>
   <form method = "POST" id ="signUpForm">
        <label>Eesnimi: </label>
        <input name = "signupFirstName" type = "text">
		<span><?php echo $signupFirstNameError; ?></span>
        <label>Perekonnanimi: </label>
        <input name = "signupFamilyName" type = "text"> <br>
		<label>Teie sünnikuupäev</label>
		<?php
			echo $signupDaySelectHTML .$signupMonthSelectHTML .$signupYearSelectHTML;
		?>
		<br>
        <label>Sugu: </label>
        <input type = "radio" name ="gender" value = "1"> Mees  <?php if(isset($gender) and $gender =="Mees") echo"checked";?>
        <input type = "radio" name ="gender" value = "2"> Naine <?php if (isset($gender) and $gender =="Naine") echo "checked";?> <br>
        <label>Kasutajanimi (e-post): </label>
        <input name = "signupEmail" type = "email"> <br>
        <label>Parool: </label>
        <input name = "signupPassword" type = "password"> <br>
    </form>
    <button type="submit" form = "signUpForm" value = "Loo kasutaja">Loo kasutaja</button>
    
   <br>
   
    <h2>Sisselogimine:</h2>
    <form method = "POST" id="logform">
        <label>Kasutajanimi (e-post): </label>
        <input name = "loginEmail" id = "loginEmail" type ="email">
        <br>
        <label>Parool: </label>
        <input name = "loginPassword" id = "loginPassword" type ="password">
        <br>
    </form>
    <button type="submit" form="logform" value= "Logi sisse">Logi sisse</button>
</body>
</html>