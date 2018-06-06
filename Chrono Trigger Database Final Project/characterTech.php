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
					echo "<h3> " . $cName . "'s Techs</h3>\n";
				}
				?>
			</caption>
			<tr>
				<th> Name </th>
				<th> MP Cost </th>
				<th> Targets </th>
				<th> Description </th>
			</tr>
			<?php	
				if(!($stmt = $mysqli->prepare(
					"SELECT tech.name, magic_cost, targets, description FROM `tech`
					INNER JOIN performs ON performs.tid = tech.id
					INNER JOIN `character` ON character.id = performs.cid
					WHERE character.id = " . $_POST['Character'] . " UNION 
					SELECT combo.name, tech.magic_cost, tech.targets, combo.description FROM combo
					INNER JOIN tech ON tech.id = combo.tid_1 OR tech.id = combo.tid_2 OR tech.id = combo.tid_3
					INNER JOIN performs ON performs.tid = tech.id
					INNER JOIN `character` ON character.id = performs.cid
					WHERE character.id = ?;"
					))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!($stmt->bind_param("i",$_POST['Character']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($tName, $mp, $targets, $desc)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if($stmt->fetch()){
					echo "<tr>\n<td> " . $tName . " </td>\n<td> " . $mp . " </td>\n<td> ". $targets . " </td>\n<td> " . $desc . " </td>\n</tr>";
					while($stmt->fetch()){
					 echo "<tr>\n<td> " . $tName . " </td>\n<td> " . $mp . " </td>\n<td> ". $targets . " </td>\n<td> " . $desc . " </td>\n</tr>";
					}
				} else {
					echo "<tr>\n<td colspan='4'> No Techs </td>\n</tr>";
				}
				$stmt->close();
			?>
		</table>
	</div>
	<div>
		<form method="post" action="addTech.php"> 
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
							echo "<h3> Create a new tech for " . $cName . " </h3>\n";
						}
					?>
				</legend>
				<label>Tech Name: <input type="text" name="techName" /></label>
				<label>MP Cost: <input type="number" name="mpCost" /></label>
				<label>Targets: <select name="targets">
					<option value="One"> One </option>
					<option value="Circle"> Circle </option>
					<option value="Line"> Line </option>
					<option value="All"> All </option>
					<option value="Ally"> Ally </option>
				</select></label>
				<label>Description: <input type="text" name="description" /></label>
				<?php
					echo '<input type="hidden" name="Character" value="' . $_POST['Character'] . '">';
					$stmt->close();
				?>
			</fieldset>
			<p><input type="submit" /></p>
		</form>
	</div>
</body>
</html>