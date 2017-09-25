<?php
	//muutujad
	$myName = "Grete";
	$myFamilyName = "Ojavere";
	
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
		echo $myName ." " .$myFamilyName;
	?>
	</h1>
	<p>Tere!<p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<img src="<?php echo $picDir .$picFile; ?>" alt="Tallinna ülikool">
	
</body>
</html>