<?php
    $myLoginEmail;
    $gender;
    $myFirstName;
    $myFamilyName;
    
    if (isset($_POST["loginEmail"]) and $_POST["loginEmail"] !=0) {
    $myLoginEmail = $_POST["loginEmail"];
    }
    if (isset($_POST["signupFirstName"]) and $_POST["signupFirstName"] !=0) {
    $myFirstName = $_POST["signupFirstName"];
    }
    if (isset($_POST["signupFamilyName"]) and $_POST["signupFamilyName"] !=0) {
    $myFamilyName = $_POST["signupFamilyName"];
    }
    if (isset($_POST["signupEmail"]) and $_POST["signupEmail"] !=0) {
    $mysignupEmail = $_POST["signupEmail"];
    }
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