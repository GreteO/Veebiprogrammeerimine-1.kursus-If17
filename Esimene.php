<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Grete Ojavere veebiprogrammeerimine</title>
</head>
<body>
	<h1>Grete Ojavere</h1>
	<p>Tere!<p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<?php
		echo "<p>Kõige esimene PHP abil väljastatud sõnum.</p>";
		echo "<p>Täna on ";
		echo date("d.m.Y");
		echo ".<p/>";
		echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .".<p/>";

 	?>

</body>
</html>