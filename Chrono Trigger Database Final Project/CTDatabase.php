<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","amegany-db","XNmPVOrt5qNXENAe","amegany-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
echo "<h2> Welcome to the Chrono Trigger database </h2>";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Chrono Trigger Database</title>
	<link rel="stylesheet" href="databaseStyle.css" type="text/css">
</head>
<body>
	<fieldset><legend><h3> Character Info </h3></legend>
	<div>
		<form method="post" action="viewCharacter.php"> 
			<label> Characters: <input type="submit" value="View All"/></label>
		</form>
	</div>
	<div>
		<form method="post" action="" id="cForm"> 
			<label> Select Character: <select name="Character"></label>
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM `character`"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($id, $cName)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value="'. $id . '"> ' . $cName . ' </option>\n';
				}
				$stmt->close();
			?>
			</select>
			<input type="submit" value="Techs" onclick="tech()"/>
			<input type="submit" value="Equipment" onclick="equip()"/>
		</form>
	</div>
	<div>
		<form method="post" action="addCharacter.php"> 
			<h4> Create your own: </h4>
				<label>Character Name: <input type="text" name="cName" /></label>
				<label>Era: <select name="era">
					<?php
						if(!($stmt = $mysqli->prepare("SELECT id, name FROM era"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $eName)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $eName . '</option>\n';
						}
						$stmt->close();
					?>
				</select></label>
				<label>Weapon: <select name="weapon">
					<?php
						if(!($stmt = $mysqli->prepare("SELECT id, name FROM equip_type WHERE id < 8"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($id, $etName)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $id . ' "> ' . $etName . '</option>\n';
						}
						$stmt->close();
					?>
				</select></label>
				<label>Element: <select name="element">
					<option value="None"> None </option>
					<option value="Light"> Light </option>
					<option value="Fire"> Fire </option>
					<option value="Ice"> Ice </option>
					<option value="Water"> Water </option>
					<option value="Shadow"> Shadow </option>
				</select></label>
				<input type="submit" value="Add"/>
		</form>
	</div>
	</fieldset>
	<fieldset><legend><h3> Quest Info </h3></legend>
	<div>
		<form method="post" action="viewQuest.php" id="qForm"> 
			<label> Select Quest: <select name="Quest"></label>
			<?php
				if(!($stmt = $mysqli->prepare("SELECT id, name FROM `quest`"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($id, $qName)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value="'. $id . '"> ' . $qName . ' </option>\n';
				}
				$stmt->close();
			?>
			</select>
			<input type="submit" value="View"/>
		</form>
	</div>
	<div>
		<form method="post" action="enemy_location.php"> 
			<label> Enemies and Locations: <input type="submit" value="View/Edit"/></label>
		</form>
	</div>
	</fieldset>
	<script>
	form = document.getElementById("cForm");
	function tech() {
			form.action="characterTech.php";
			form.submit();
	}
	function equip() {
			form.action="characterEquip.php";
			form.submit();
	}
	</script>
</body>
</html>