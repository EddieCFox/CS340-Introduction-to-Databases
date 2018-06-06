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
	<link rel="stylesheet" href="databaseStyle.css" type="text/css">
</head>
<body>
	<div>
		<table>
			<caption>
				<?php
				if(!($stmt = $mysqli->prepare(
					"SELECT name FROM location WHERE location.id = ?;"
					))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Location']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($lName)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<h3> " . $lName . "'s Monsters</h3>\n";
				}
				?>
			</caption>
			<tr>
				<th> Name </th>
				<th> Health </th>
				<th> Defense </th>
				<th> Magic Defense </th>
			</tr>
			<?php	
				if(!($stmt = $mysqli->prepare(
					"SELECT enemy.name, health, defense, magic_defense FROM enemy
					INNER JOIN location ON location.id = enemy.lid
					WHERE location.id = ?;"
					))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Location']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($lName, $health, $defense, $mag_def)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if($stmt->fetch()){
					echo "<tr>\n<td> " . $lName . " </td>\n<td> " . $health . " </td>\n<td> ". $defense . " </td>\n<td> " . $mag_def . " </td>\n</tr>";
					while($stmt->fetch()){
					 echo "<tr>\n<td> " . $lName . " </td>\n<td> " . $health . " </td>\n<td> ". $defense . " </td>\n<td> " . $mag_def . " </td>\n</tr>";
					}
				} else {
					echo "<tr>\n<td colspan='4'> No Enemies </td>\n</tr>";
				}
				$stmt->close();
			?>
		</table>
	</div>
</body>
</html>