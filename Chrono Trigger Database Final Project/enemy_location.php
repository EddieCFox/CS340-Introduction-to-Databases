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
	<link rel="stylesheet" href="databaseStyle.css" type="text/css">
</head>
<body>

<div>
	<table>
		<tr>
			<td>Enemies</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Location_Id</td>
			<td>Health</td>
			<td>Defense</td>
			<td>Magic_Defense</td>
			<td>Tech_Value</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT name, lid, health, defense, magic_defense, tech_value FROM enemy"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $lid, $health, $defense, $magic_defense, $tech_value)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $lid . "\n</td>\n<td>\n" . $health .  "\n</td>\n<td>\n" . $defense . "\n</td>\n<td>\n" . $magic_defense . "\n</td>\n<td>\n" . $tech_value . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>

<div>
	<br> <p> Form to enter an enemy to add: </p> <br>
	<form method="post" action="addEnemy.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name: <input type="text" name="name" /></p>
		</fieldset>

		<fieldset>
			<legend>Location ID</legend>
			<p>Location ID (must be an integer): <input type="text" name="lid" /></p>
		</fieldset>

		<fieldset>
			<legend>Health</legend>
			<p>Health (must be an integer): <input type="text" name="health" /></p>
		</fieldset>

		<fieldset>
			<legend>Defense</legend>
			<p>Defense (must be an integer):  <input type="text" name="defense" /></p>
		</fieldset>

		<fieldset>
			<legend>Magic Defense</legend>
			<p>Magic Defense (must be an integer): <input type="text" name="magic_defense" /></p>
		</fieldset>

		<fieldset>
			<legend>Tech Value</legend>
			<p>Tech Value (must be an integer): <input type="text" name="tech_value" /></p>
		</fieldset>

		<p><input type="submit" value="Add Enemy"/></p>
	</form>
</div>

<div>
	<br> <p> Form to edit enemy information.: </p> <br>
	<form method="post" action="updateEnemy.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name (must match an enemy registered in the database): <input type="text" name="name" /></p>
		</fieldset>

		<fieldset>
			<legend>Location ID</legend>
			<p>Location ID (must be an id that exists in the location table): <input type="text" name="lid" /></p>
		</fieldset>

		<fieldset>
			<legend>Health</legend>
			<p>Health (must be an integer): <input type="text" name="health" /></p>
		</fieldset>

		<fieldset>
			<legend>Defense</legend>
			<p>Defense (must be an integer):  <input type="text" name="defense" /></p>
		</fieldset>

		<fieldset>
			<legend>Magic Defense</legend>
			<p>Magic Defense (must be an integer): <input type="text" name="magic_defense" /></p>
		</fieldset>

		<fieldset>
			<legend>Tech Value</legend>
			<p>Tech Value (must be an integer): <input type="text" name="tech_value" /></p>
		</fieldset>

		<p><input type="submit" value="Update Enemy Information"/></p>
	</form>
</div>

<div>
	<br> <p> Form to delete a specific enemy from the table: </p> <br>
	<form method="post" action="deleteEnemy.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name (must match an enemy registered in the database): <input type="text" name="name" /></p>
		</fieldset>

		<p><input type="submit" value="Delete Enemy"/></p>
	</form>
</div>

<br>
<div>
	<table>
		<tr>
			<td>Locations</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Era_ID</td>
		</tr>

<?php
if(!($stmt = $mysqli->prepare("SELECT name, eid FROM location"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $eid)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $eid . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>

<div>
	<br> <p> Form to enter a location to add: </p> <br>
	<form method="post" action="addLocation.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name: <input type="text" name="name" /></p>
		</fieldset>

		<fieldset>
			<legend>Era ID</legend>
			<p>Era ID (must be an era that already exists in the database): <input type="text" name="eid" /></p>
		</fieldset>

		<p><input type="submit" value="Add Location"/></p>
	</form>
</div>

<div>
	<br> <p> Form to edit location information.: </p> <br>
	<form method="post" action="updateLocation.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name (must match a location registered in the database): <input type="text" name="name" /></p>
		</fieldset>

		<fieldset>
			<legend>Era ID</legend>
			<p>Era ID (must be an era id that exists in the era table): <input type="text" name="eid" /></p>
		</fieldset>

		<p><input type="submit" value="Update Location Information"/></p>
	</form>
</div>

<div>
	<br> <p> Form to delete a specific enemy from the table: </p> <br>
	<form method="post" action="deleteLocation.php"> 

		<fieldset>
			<legend>Name</legend>
			<p>Name (must match a location registered in the database): <input type="text" name="name" /></p>
		</fieldset>

		<p><input type="submit" value="Delete Location"/></p>
	</form>
</div>

</body>
</html>