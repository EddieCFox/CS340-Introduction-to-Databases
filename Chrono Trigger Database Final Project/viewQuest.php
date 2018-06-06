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
				if(!($stmt = $mysqli->prepare("SELECT name, objective FROM quest WHERE quest.id = ?;"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Quest']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($qName, $qObj)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<legend><h3>" . $qName . "</h3></legend>\n<div><strong> Objective: </strong>" . $qObj . "</div>\n";
				}
			?>
			<div>
				<form method="post" action="enemy.php" id="enForm"> 
					<label> View Enemies by Location: <select name="Location"></label>
					<?php
						if(!($stmt = $mysqli->prepare(
							"SELECT location.id, location.name FROM location
							INNER JOIN traverses ON traverses.lid = location.id
							INNER JOIN quest ON quest.id = traverses.qid
							WHERE quest.id = " . $_POST['Quest'] . ";"
						))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($lid, $lName)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value="'. $lid . '"> ' . $lName . ' </option>\n';
						}
						$stmt->close();
					?>
					</select>
					<input type="submit" value="Enemies"/>
				</form>
				<form method="post" action="boss.php" id="bForm"> 
					<label> View Quest Boss: </label>
					<?php
						echo '<input type="hidden" name="questBoss" value="' . $_POST['Quest'] . '">';
					?>
					<input type="submit" value="Boss"/>
				</form>
			</div>
		</fieldset>
	</div>
</body>
</html>