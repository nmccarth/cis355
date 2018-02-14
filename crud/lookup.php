<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Lookup</title>

	</head>
	<body>
<?php
include '../../database/database.php';

echo "<form action='lookup.php' method='get'>";

echo "<select name='id'>";
$pdo = Database::connect();

$sql = "SELECT * FROM customers";
foreach ($pdo->query($sql) as $row) {
	if(!strcmp($row['name'],"asd"))
		echo "<option selected value='{$row['id']}'>{$row['name']}</option>" ;
	else
		echo "<option value='{$row['id']}'>{$row['name']}</option>" ;
}

Database::disconnect();
echo "</select>";	

echo "<input type='submit' value='Submit'>";

echo "</form>";		 


?>
		<!-- Place javascript at end -->

		</body>
</html>

