<?php
	require("../../../config.php");
	$database = "if17_ojavgret";
	
	//loeme toimetamiseks mõtte
	function getSingleIdea($editId) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE id=?");
		$stmt->bind_param("i",$editId); //sinna tuleb täisarv ja see on editId
		$stmt->bind_result($idea, $color); //tähistamine siin on oma asi, aga järjekord!!
		$stmt->execute();
		$ideaObject = new Stdclass(); //uus objekt, standardklass
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color= $color;
		}
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject; //returnida saab aint ühe asja
	}
	
	function updateIdea($id, $idea, $ideacolor){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET idea=?, ideacolor=? WHERE id=?");
		$stmt->bind_param("ssi", $idea, $ideacolor, $id);
		if($stmt->execute()){
			echo "Õnnestus";
		}else{
			echo "Tekkis viga: " .$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE vpuserideas SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
?>