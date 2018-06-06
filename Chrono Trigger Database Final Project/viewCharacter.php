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
			<caption><h3> Playable Characters </h3></caption>
			<tr>
				<th> Name </th>
				<th> Era </th>
				<th> Weapon </th>
				<th> Element </th>
			</tr>
				<?php
					if(!($stmt = $mysqli->prepare("SELECT character.name, era.name, equip_type.name, character.element FROM `character`
					INNER JOIN era ON era.id = character.eid INNER JOIN equip_type ON equip_type.id = character.etid"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($cName, $eName, $etName, $element)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td> " . $cName . " </td>\n<td> " . $eName . " </td>\n<td> " . $etName . " </td>\n<td> " . $element . " </td>\n</tr>";
					}
					$stmt->close();
				?>
		</table>
	</div>
</body>
</html>