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

$target_dir = "../../pics/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$notice = "";
$noImageError = "";
$fileSizeError = "";
$fileExistsError = "";
$fileFormatError = "";
//$fileUploadError = "";
//$fileIsUploaded = "";

//Kontrollib, kas pilt on päris või fake
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image -" . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $noImageError = "Üleslaetud fail ei ole pilt.";
        $uploadOk = 0;
    }
}


//Kontrollib, kas fail on kaustas juba olemas
if(file_exists($target_file)) {
    $fileExistsError = "Samanimeline fail on juba olemas. ";
    $uploadOk = 0;
}

//Kontrollib faili suurust (max 2MB)
if($_FILES["fileToUpload"]["size"] > 2000000) {
    $fileSizeError = "Pildi maht on liiga suur (lubatud kuni 2MB).";
    $uploadOk = 0;
}

//Kontrollib faili formaati
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    $fileFormatError = "Lubatud on ainult JPG, JPEG, PNG ja GIF formaadis failid.";
    $upload = 0;
}

//Kontrollib kas $uploadOk on errori käigus pandud 0-ks
if($uploadOk == 0) {
    $notice = " Faili ei laetud üles.";
//Kui kõik on korras laadi fail üles
} else {
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
        $notice = "Fail ". basename($_FILES["fileToUpload"]["name"]). " on üles laetud.";
    } else {
        $notice = "Vabandust, tekkis error.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Grete Ojavere veebiprogrammeerimine</title>
</head>
<body>

    <h2>Piltide üleslaadimine</h2>
 	<p><a href="main.php">Pealeht</a></p>   
	<p><a href="?logout=1">Logi välja</a></p> 


<form action="picsupload.php" method="post" enctype="multipart/form-data">
    <label>Vali pilt: </lable>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <input type="submit" value="Lae üles" name="submit">
    <span><?php echo $notice." ". $noImageError." ". $fileSizeError." ". $fileExistsError." ". $fileFormatError ;?></span>
</form>

</body>
</html>