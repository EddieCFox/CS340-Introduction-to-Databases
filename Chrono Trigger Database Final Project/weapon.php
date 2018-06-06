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
					"SELECT name FROM `character` WHERE character.id = ?;"
					))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Equipment']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($cName)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<h3> " . $cName . "'s Weapons</h3>\n";
				}
				?>
			</caption>
			</tr>
			<tr>
				<th> Name </th>
				<th> Type </th>
				<th> Attack Power </th>
				<th> Effects </th>
			</tr>
			<?php	
				if(!($stmt = $mysqli->prepare(
					"SELECT equipment.name, equip_type.name, attack, effect FROM `equipment`
					INNER JOIN equip_type ON equip_type.id = equipment.etid
					INNER JOIN utilizes ON utilizes.eqid = equipment.id
					INNER JOIN `character` ON character.id = utilizes.cid
					WHERE character.id = ? AND equipment.attack != 0;"
					))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Equipment']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($eName, $type, $attack, $effect)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if($stmt->fetch()){
					echo "<tr>\n<td> " . $eName . " </td>\n<td> " . $type . " </td>\n<td> ". $attack . " </td>\n<td> " . $effect . " </td>\n</tr>";
					while($stmt->fetch()){
					 echo "<tr>\n<td> " . $eName . " </td>\n<td> " . $type . " </td>\n<td> ". $attack . " </td>\n<td> " . $effect . " </td>\n</tr>";
					}
				} else {
					echo "<tr>\n<td colspan='4'> No Weapons </td>\n</tr>";
				}
				$stmt->close();
			?>
		</table>
	</div>
</body>
</html>