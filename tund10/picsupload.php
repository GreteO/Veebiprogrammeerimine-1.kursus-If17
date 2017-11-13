<?php
require("../../../config.php");
require("functions.php");
require("classes/Photoupload.class.php");
$database = "if17_ojavgret";

/*$joke = new Photoupload("Väga salajane värk");
echo $joke->testPublic;
echo $joke->testPrivate;*/
		
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
//Fotolaadimise algus
$target_dir = "../../pics/";
$target_file = "";
$uploadOk = 1;
$imageFileType = "";
//pathinfo($target_file,PATHINFO_EXTENSION)
$notice = "";
$maxWidth = 600;
$maxHeight = 400;
$marginVer = 10;
$marginHor = 10; 

$thumb_width = 100;
$target_dir = "../../pics/";
$thumb_dir = "../../thumbs/";
$thumb_file = "";


//Kas vajutati üleslaadimise nuppu (Kontrollib, kas pilt on päris või mitte)
if(isset($_POST["submit"])) {
	
	
        if(!empty($_FILES["fileToUpload"]["name"])){
        
            //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            //filename- ainult nimi ilma jpg jne
            //microtime-mikrosekundites, korruta 10tuhandega, saad komadest lahti
            $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
            $timestamp = microtime(1) *10000;
            //$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" . $timestamp ."." .$imageFileType;
            //$target_file = $target_dir . "hmv_" . $timestamp ."." .$imageFileType;
			$target_file = "hmv_" .$timestamp ."." .$imageFileType;
            //Thumbnailid
            /*$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
            $timestamp = microtime(1) *10000;
            //$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" . $timestamp ."." .$imageFileType;
            $thumb_file = $thumb_dir . "hmv_" . $timestamp ."." ."jpg";*/
        
        
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $notice = "Fail on pilt -" . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $notice = "Üleslaetud fail ei ole pilt.";
                $uploadOk = 0;
            }
        
        
            //Kontrollib, kas fail on kaustas juba olemas
            if(file_exists($target_file)) {
                $notice = "Samanimeline fail on juba olemas. ";
                $uploadOk = 0;
            }

            //Kontrollib faili suurust (max 2MB)
            /*if($_FILES["fileToUpload"]["size"] > 2000000) {
                $notice = "Pildi maht on liiga suur (lubatud kuni 2MB).";
                $uploadOk = 0;
            }*/

            //Kontrollib faili formaati
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $notice = "Lubatud on ainult jpg, jpeg, png ja gif formaadis failid.";
                $upload = 0;
            }
			//Kas saab laadida
            //Kontrollib kas $uploadOk on errori käigus pandud 0-ks
            if($uploadOk == 0) {
                $notice = " Faili ei laetud üles.";
        
            } else {
                //Kui kõik on korras laadi fail üles, teeb koopia tempfaili
                /*if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                    $notice = "Fail ". basename($_FILES["fileToUpload"]["name"]). " on üles laetud.";
                } else {
                    $notice = "Vabandust, tekkis error.";
                }*/
            
				//Kasutame klassi
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->readExif();
				$myPhoto->resizeImage($maxWidth, $maxHeight);
				$myPhoto->addWatermark($marginHor, $marginVer);
				//$myPhoto->addTextWatermark($myPhoto->exifToImage);
				$myPhoto->addTextWatermark("Heade mõtete veeb");
				$notice = $myPhoto->savePhoto($target_dir, $target_file);
				if($notice =="true"){
					$notice = "Pilt laeti üles";
				} else {
					$notice = "Pilti ei laetud üles";
				}
				//$myPhoto->saveOriginal(kataloog, failinimi);
				$myPhoto->clearImages();
				unset($myPhoto); //unustatakse kõik mis klassis töötasid
				
			
                //Muudame suurust
                //lähtudes failitüübist, loome pildiobjekti
                /*if($imageFileType == "jpg" or $imageFileType == "jpeg"){
                    $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);	
                }
                if($imageFileType == "png"){
                    $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);	
                }
                if($imageFileType == "gif"){
                    $myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
                }*/
                //sx küsib pildi laiust sy pildi pikkust
                /*$imageWidth = imagesx($myTempImage);
                $imageHeight = imagesy($myTempImage);
            
                $sizeRatio = 1;
                if($imageWidth > $imageHeight){
                    $sizeRatio = $imageWidth / $maxWidth;
                } else {
                    $sizeRatio = $imageHeight / $maxHeight;
                }
                //Funktsioon piltidest erinevate suuruste saamiseks
                $myImage = resize_image($myTempImage, $imageWidth, $imageHeight, round($imageWidth/$sizeRatio), round($imageHeight/$sizeRatio));
				*/
            
            
                //Lisame vesimärgi
                /*$stamp = imagecreatefrompng("../../graphics/hmv_logo.png");
                $stampWidth = imagesx($stamp);
                $stampHeight = imagesy($stamp);
                $stampPosX = round($imageWidth/$sizeRatio) - $stampWidth - $marginHor;
                $stampPosY = round($imageHeight/$sizeRatio) - $stampHeight - $marginVer;
                //imagecopy kleebib ühe pildi teise peale
                imagecopy($myImage, $stamp, $stampPosX, $stampPosY, 0, 0, $stampWidth, $stampHeight);*/
            
                //Lisame ka teksti
                //$txtToImage = "Minu pilt!";
            
                //Loen EXIF infot
                /*@$exif = exif_read_data($_FILES["fileToUpload"]["tmp_name"],"ANY_TAG", 0, true);
                //var_dump($exif);
                if(!empty($exif["DateTimeOriginal"])){
                    $txtToImage = "Pilt tehti: " .$exif["DateTimeOriginal"];
                } else {
                    $txtToImage = "Pildistamise aeg ei ole teada";
                }*/
            
                //Teksti värv
                //imagecolorallocate - ilma läbipaistvuseta
                //alpha 0 - 127   
                /*$textColor = imagecolorallocatealpha($myImage, 150, 150, 150, 50);
                imagettftext($myImage, 20, 0, 10, 25, $textColor, "../../graphics/TIMES.TTF", $txtToImage);*/
            
                //Salvestame pildifaili
                /*if($imageFileType == "jpg" or $imageFileType == "jpeg"){
                    if(imagejpeg($myImage, $target_file, 90)){
                        $notice = "Fail: " .basename($_FILES["fileToUpload"]["name"]) ." Laeti üles!";
                    } else {
                        $notice = "Vabandust! Faili üleslaadimisel tekkis viga!";
                    }
                }
            
                if($imageFileType == "png"){
                    if(imagepng($myImage, $target_file, 90)){
                        $notice = "Fail: " .basename($_FILES["fileToUpload"]["name"]) ." Laeti üles!";
                    } else {
                        $notice = "Vabandust! Faili üleslaadimisel tekkis viga!";
                    }
                }
            
                if($imageFileType == "gif"){
                    if(imagegif($myImage, $target_file, 90)){
                        $notice = "Fail: " .basename($_FILES["fileToUpload"]["name"]) ." Laeti üles!";
                    } else {
                        $notice = "Vabandust! Faili üleslaadimisel tekkis viga!";
                    }
                }*/
            
                //Kutsume funktsiooni thumbnaili salvestama
               /* $thumbs = createThumbnail($imageFileType);
            
                //Salvestame thumbnaili
                    if(imagejpeg($thumbs, $thumb_file, 90)){
                        $notice = "Fail: " .basename($_FILES["fileToUpload"]["name"]) ." Laeti üles!";
                    } else {
                        $notice = "Vabandust! Thumbnail faili üleslaadimisel tekkis viga!";
                    }*/
                /*$visib = "";
                savePicInfo ($target_file, $thumb_file, $visib); 
                if(isset($_FILES["fileToUpload"])){
                    $target_file = test_input ($_FILES["fileToUpload"]["name"]);
                } else {
                    $notice = "Andmebaasi ei salvestunud";
                }
                
                if(isset($_FILES["thumbUpload"])){
                    $thumb_file = test_input($_FILES["thumbUpload"]["name"]);
                } else {
                    $notice = "Andmebaasi ei salvestunud";
                }
                
                if(isset($_FILES["see_pic"])){
                    $visib = test_input($_FILES["see_pic"]);
                } else {
                    $notice = "Andmebaasi ei salvestunud";
                }*/
                
                 /*if(isset($_POST["fileToUpload"]) and isset($_POST["see_pic"]) and !empty($_POST["fileToUpload"]) and !empty($_POST["see_pic"])){
	                $notice = savePicInfo(test_input($_POST["fileToUpload"]), $_POST["see_pic"]);
	            }*/
	             //savePicInfo ($target_file, $thumb_file, $visib);           
                
                //vabastame mälu
                /*imagedestroy($myTempImage);
                imagedestroy($myImage);
				imagedestroy($stamp);
                imagedestroy($thumbs);*/
            }
        } else {
            $notice = "Palun valige kõigepealt pildifail";
        }//kas faili nimi on olemas lõppeb
        

}//"Kas üles laadida" lõppeb

//"imagecreatetruecolor" loob uue pikslikogumi
/*function resize_image($image, $origW, $origH, $w, $h){
	$dst = imagecreatetruecolor($w, $h);
	imagecopyresampled($dst, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
	return $dst;
}*/

//Funktsioon thumbnaili tegemiseks
/*function createThumbnail($imageFileType){
    $thumb_width = 100;
    if($imageFileType == "jpg" or $imageFileType == "jpeg"){
        $im = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);	
	}
	if($imageFileType == "png"){
		$im = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);	
	}
	if($imageFileType == "gif"){
		$im = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
	}
	
	$ox = imagesx($im);
	$oy = imagesy($im);
	
	$nx = $thumb_width;
	$ny = floor($oy * ($thumb_width / $ox));
	
	$nm = imagecreatetruecolor($nx, $ny);
	
	imagecopyresized($nm, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy);
	
	return $nm;
} */


//Funktsioon pildi info salvestamiseks andmebaasi
//session_start();
//funkts kätte tahad saada muutujat globals ette ja muutuja lk algusesse
/*
function savePicInfo ($target_file, $thumb_file, $visib) {
    $notice = "";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vpphotos (userid, filename, thumbnail, visibility) VALUES (?, ?, ?, ?)");
    echo $mysqli->error;
    $stmt->bind_param("issi", $_SESSION["userId"], $target_file, $thumb_file, $visib);
    if($stmt->execute()){
        $notice = "Pildi info on andmebaasi salvestatud";
    } else {
        $notice = "Salvestamisel tekkis viga: " .$stmt->error;
    }
    $stmt->close();
    $mysqli->close();
    return $notice;

}*/
require("header.php");
?>

<script type="text/javascript" src="javascript/checkFileSize.js" defer></script>
</head>
<body>

    <h2>Piltide üleslaadimine</h2>
 	<p><a href="main.php">Pealeht</a></p>   
	<p><a href="?logout=1">Logi välja</a></p> 


<form action="picsupload.php" method="post" enctype="multipart/form-data">
    <label>Vali pilt: </lable>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <input type="submit" value="Lae üles" name="submit" id="photoSubmit"><span id="fileSizeError"></span>
    <span><?php echo $notice;?></span>
    <br>
    <input type="radio" name="see_pic" value="1" > 
    <label>Avalik</label>
    <br>
    <input type="radio" name="see_pic" value="2" > 
    <label>Sisselogitud kasutajatele</label>
    <br>
    <input type="radio" name="see_pic" value="3" checked="checked"/> 
    <label>Ainult omanikule</label>
</form>

<?php
	require("footer.php");
?>