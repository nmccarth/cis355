<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>2D Array Traverse</title>

	</head>
	<body>
<?php
$cars = array
(
	array("Volvo",22,18),
	array("BMW",15,13),
	array("Saab",5,2),
	array("Land Rover",17,15)
);

function twoDimCompare($array) {
	// Check that they passed an array
	if (!is_array($array)) {
		echo("You didn't pass an array.<br />");
		return false;
	} 

	foreach ($array as &$value) {
		// Check that the elements of the array are arrays
		// aka, that they passed a 2D array.
		if (!is_array($value)) {
			echo("You didn't pass a 2D array.<br />");
			return false;
		} 
		// Check that each row of the 2D array has 3 elements
		if(sizeof($value) != 3) {
			echo("You didn't pass a 2D array which each element having 3 values.<br />");
			return false;
		} 
		// Check that second and third values of each array are numbers
		if (!is_numeric($value[1]) && !is_numeric($value[2])) {
			echo("You didn't pass a 2D array which the second and third values of each array are numbers.<br />");
			return false;
		}
	}

	// If the 2nd value of each row is larger than the 3rd 
	// and if so, print the first value.
	foreach ($array as &$value) {
		if ($value[1] > $value[2]) {
			echo($value[0]."<br  />");
		}
	}
}
twoDimCompare($cars);

?>
		<!-- Place javascript at end -->

		</body>
</html>

