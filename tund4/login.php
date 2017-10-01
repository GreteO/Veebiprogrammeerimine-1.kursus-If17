<?php
	require("../../../config.php");
	//echo $serverHost;
	
    $loginEmail ="";
    $gender = "";
    //$myFirstName = "";
    //$myFamilyName = "";
    $signupFirstName = "";
    $signupFamilyName = "";
    $signupEmail = "";
    //$signupPassword = "";
	
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	//$signupPassword = null; 
	
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupBirthMonthError = "";
	$signupBirthYearError = "";
    
    if (isset($_POST["loginEmail"])){
        if (empty ($_POST["loginEmail"])){
        } else {
                $myLoginEmail = $_POST["loginEmail"];
        }
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
    if (isset($_POST["signupFamilyName"])){
        if (empty($_POST["signupFamilyName"])){
                $signupFamilyNameError = "NB! Väli on kohustuslik!";
        } else {
                $signupFamilyName = $_POST["signupFamilyName"];
        }
    }
    
	if (isset ($_POST["signupBirthDay"])){
	    if (empty($_POST["signupBirthDay"])){
	            $signupBirthDayError = "NB! Väli on kohustuslik";
	    } else {
		        $signupBirthDay = $_POST["signupBirthDay"];
		}
		//echo $signupBirthDay;
	}
	//kas sünnikuu on valitud
	/*if(isset($POST["signupBirthMonth"])){
		$signupBirthMonth = $POST["signupBirthMonth"]; 
		echo $signupBirthMonth;
	}*/
	if (isset ($_POST["signupBirthMonth"])){
	    if(empty($_POST["signupBirthMonth"])){
	        $signupBirthMonthError = "NB! Väli on kohustuslik";
	    } else {
		    $signupBirthMonth = intval ($_POST["signupBirthMonth"]);
		}
		//echo $signupBirthMonth;
	}
	
	if (isset ($_POST["signupBirthYear"])){
	    if(empty($_POST["signupBirthYear"])){
	        $signupBirthYearError = "NB! Väli on kohustuslik";
	    } else {
		    $signupBirthYear = $_POST["signupBirthYear"];
		}
		//echo $signupBirthYear;
	}
	
	if (isset ($_POST["signupBirthDay"]) and isset ($_POST["signupBirthMonth"]) and isset ($_POST["signupBirthYear"])){
		//kontrollin kuupäeva valiidsust
		if(checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))){
		    $birthDate = date_create(intval($_POST["signupBirthMonth"]) ."/" .intval($_POST["signupBirthDay"]) ."/" .intval($_POST["signupBirthYear"]));
		    $signupBirthDate = date_format($birthDate, "Y-m-d");
		    //echo $signupBirthDate;
		} else {
		    $signupBirthDayError .= "Kuupäev ei vasta nõuetele";
		}
	}
	
	
    if (isset($_POST["signupEmail"])){
        if (empty($_POST["signupEmail"])){
                $signupEmailError = "NB! Väli on kohustuslik!";
        } else {
                $signupEmail = $_POST["signupEmail"];
        }
    }
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				//$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	
	if (isset($_POST["gender"]) && !empty($_POST["gender"])){
	        $gender = intval($_POST["gender"]);
	    } else {
	        $signupGenderError = "(Palun vali sobiv!) Määramata!";
	}
	
	
	//KIRJUTAN UUE KASUTAJA ANDMEBAASI
	if(empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError)) {
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
		//$stmt->execute();
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
	
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>' ."\n";
	foreach ($monthNamesET as $key=>$month){
		    if ($key + 1 === $signupBirthMonth){
			    $signupMonthSelectHTML .= '<option value="' .($key + 1) .'" selected>' .$month ."</option> \n";
		    } else {
		        $signupMonthSelectHTML .= '<option value="' .($key + 1) .'">' .$month ."</option> \n";
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
        <input name = "signupFirstName" type = "text" value = "<?php echo $signupFirstName; ?>">
		<span><?php echo $signupFirstNameError; ?></span>
		<br>
        <label>Perekonnanimi: </label>
        <input name = "signupFamilyName" type = "text" value = "<?php echo $signupFamilyName; ?>"> 
        <span><?php echo $signupFamilyNameError; ?></span>
        <br>
		<label>Teie sünnikuupäev</label>
		<?php
			echo $signupDaySelectHTML .$signupMonthSelectHTML .$signupYearSelectHTML;
		?>
		<span><?php echo $signupBirthDayError; ?></span>
		<span><?php echo $signupBirthMonthError; ?></span>
		<span><?php echo $signupBirthYearError; ?></span>
		<br>
        <label>Sugu: </label>
        <input type = "radio" name ="gender" value = "1"> Mees  <?php if(isset($gender) and $gender =="Mees") echo"checked";?>
        <input type = "radio" name ="gender" value = "2"> Naine <?php if (isset($gender) and $gender =="Naine") echo "checked";?> 
        <span><?php echo $signupGenderError; ?></span>
        <br>
        <label>Kasutajanimi (e-post): </label>
        <input name = "signupEmail" type = "email" value = "<?php echo $signupEmail; ?>">
        <span><?php echo $signupEmailError; ?></span>
        <br>
        <label>Parool: </label>
        <input name = "signupPassword" type = "password">
        <span><?php echo $signupPasswordError; ?></span>
        <br>
    
    <button type="submit" form = "signUpForm" value = "Loo kasutaja">Loo kasutaja</button>
    </form>
   
   <br>
   
    <h2>Sisselogimine:</h2>
    <form method = "POST" id="logform">
        <label>Kasutajanimi (e-post): </label>
        <input name = "loginEmail" id = "loginEmail" type ="email" value ="<?php echo $loginEmail; ?>">
        <br>
        <label>Parool: </label>
        <input name = "loginPassword" id = "loginPassword" type ="password">
        <br>
    <button type="submit" form="logform" value= "Logi sisse">Logi sisse</button>
    </form>
</body>
</html>