<?php
require("../../../config.php");
require("functions.php");
require("editideafunctions.php");

//KUSTUTA userideas-> vale ja vana fail
//muutuja
$notice = "";

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
		
		// kui klõpsati uuendamise nuppu
		if(isset($_POST["ideaBtn"])){
			updateIdea($_POST["id"], test_input($_POST["userIdea"]), $_POST["ideaColor"]);
			//header("Location: ?id=" .$_POST["id"]); //Peale salvestamist jääb samale lehele
			header("Location: usersideas.php"); //peale salvestamist läheb tagasi ideede lehele
			exit();
		}
		
		//Kas kustutatakse
		if(isset($_GET["delete"])){
			deleteIdea($_GET["id"]);
			header("Location: usersideas.php"); //peale salvestamist läheb tagasi ideede lehele
			exit();
		}
		
		$idea = getSingleIdea($_GET["id"]); //kui tahad midagi saada võiks olla get nimes
require("header.php");
?>


</head>
<body>
	
	<p>Tere! <p/>
	<p>Olete jõudnud isiklikule veebilehele.<p/>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.<p/>
	<p><a href="?logout=1">Logi välja</a></p> 
	<p><a href="usersideas.php">Tagasi mõtete lehele</a></p>
	<h2>Hea mõtte toimetamine</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
		<label>Hea mõte: </label>
		<textarea name="userIdea"><?php echo $idea->text; ?></textarea>
		<br>
		<label> Mõttega seostuv värv: </label>
		<input name="ideaColor" type="color" value="<?php echo $idea->color; ?>">
		<br>
		<input name="ideaBtn" type="submit" value="Salvesta mõte!"><span><?php echo $notice;?></span>
	</form>
	<p><a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta see mõte</a>!</p>
	<hr>
	
	
<?php
	require("footer.php");
?>