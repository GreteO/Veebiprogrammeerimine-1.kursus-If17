<?php
	//muutujad
	$myName = "Grete";
	$myFamilyName = "Ojavere";
	
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
	<p>Meie õpime <a href="http://www.tlu.ee">Tallinna Ülikoolis<a/>.</p>
	<p>Minu esimene PHP leht on <a href="../Esimene.php">siin</a>.</p>
	<p>Minu sõbra Meelise leht on <a href ="../../../~lutsmeel/Veebiprogrammeerimine">siin</a>.</p>
	<p>Pilte näeb <a href ="foto.php">siin</a>.</p>
	
</body>
</html>