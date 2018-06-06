<?php
	//Turn on error reporting
	ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","amegany-db","XNmPVOrt5qNXENAe","amegany-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title> Chrono Trigger Database </title>
</head>
<body>
	<div>
		<fieldset>
			<?php
				if(!($stmt = $mysqli->prepare("SELECT name FROM `character` WHERE character.id = ?;"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Character']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($cName)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<legend><h3>" . $cName . "'s Equipment</h3></legend>\n";
				}
			?>
			<form method="post" action="" id="eForm"> 
				<?php
					echo '<input type="hidden" name="Equipment" value="' . $_POST['Character'] . '">';
					$stmt->close();
				?>
				<input type="submit" value="Weapons" onclick="weapon()"/>
				<input type="submit" value="Protection" onclick="protect()"/>
				<input type="submit" value="Accessories" onclick="access()"/>
			</form>
		</fieldset>
	</div>
	<div>
		<form method="post" action="addEquip.php"> 
			<fieldset>
				<legend>
					<?php
						if(!($stmt = $mysqli->prepare(
							"SELECT name FROM `character` WHERE character.id = ?;"
							))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!($stmt->bind_param("i",$_POST['Character']))){
							echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($cName)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo "<h3> Create new equipment for " . $cName . " </h3>\n";
						}
					?>
				</legend>
				<label>Equipment Name: <input type="text" name="equipName" /></label>
				<label>Type: <select name="type">
					<?php
						if(!($stmt = $mysqli->prepare("SELECT id, name FROM equip_type"))){
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
				<label>Attack Power: <input type="number" name="attack" /></label>
				<label>Defense Strength: <input type="number" name="defense" /></label>
				<label>Effects: <input type="text" name="effect" /></label>
				<?php
					echo '<input type="hidden" name="Character" value="' . $_POST['Character'] . '">';
				?>
			</fieldset>
			<p><input type="submit" /></p>
		</form>
	</div>
	<script>
	form = document.getElementById("eForm");
	function weapon() {
			form.action="weapon.php";
			form.submit();
	}
	function protect() {
			form.action="protection.php";
			form.submit();
	}
	function access() {
			form.action="accessory.php";
			form.submit();
	}
	</script>
</body>
</html>