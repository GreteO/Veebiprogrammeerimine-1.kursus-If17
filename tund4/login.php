<?php
//var_dump ($_POST);   
    $myLoginEmail;
    $gender;
    $myFirstName;
    $myFamilyName;
	
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
    
    if (isset($_POST["loginEmail"]) and $_POST["loginEmail"] !=0) {
    $myLoginEmail = $_POST["loginEmail"];
    }
    if (isset($_POST["signupFirstName"]) and $_POST["signupFirstName"] !=0) {
    $myFirstName = $_POST["signupFirstName"];
    }
    if (isset($_POST["signupFamilyName"]) and $_POST["signupFamilyName"] !=0) {
    $myFamilyName = $_POST["signupFamilyName"];
    }
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	//kas sünnikuu on valitud
	if(isset($POST["signupBirthMonth"])){
		$signupBirthMonth = intval($POST["signupBirthMonth"]); 
		echo $signupBirthMonth;
	}
	
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
    if (isset($_POST["signupEmail"]) and $_POST["signupEmail"] !=0) {
    $mysignupEmail = $_POST["signupEmail"];
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
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' ."\n";
	foreach ($monthNamesEt as $key=>$month){
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