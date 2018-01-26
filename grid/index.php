<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grid Traverser</title>
		<style>
			body { 
				/* Make sure the web page uses a monospaced font and put the lines close together
				 * so that is looks more like a square grid. Line size of 0.5 works for the first
				 * grid but does not look good for the rest of the site so just go with size of 1 */
				font-family: Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;
				line-height: 1;	
			}
		</style>
	</head>
	<body>
<?php
echo("Lower left to upper right<br /><br />");
$col = 1;
$row = 20;
$grid = array("","","","","","","","","","","","","","","","","","","","");

// Mark starting point and loop through until you get to the end point
$output = "*";
while ($col != 20 || $row != 0) {
	// Pick a random direction. 1 means change column and 0 means change row
	$case = rand(0,1);

	// If you are already at one edge don't try to change that dimension
	if ($col == 20) {
		$case = 0;
	} 
	if ($row == 0) {
		$case = 1;
	}

	// Add an asterisk to represent where you have gone
	if ($case == 1) {
		$col++;
		$output .= "*";
		// If statement here because grid otherwise wouldn't be updated 
		// in the case where you get to the first row before
		// you get to the last column.
		if ($row == 0) {
			$grid[$row + 1] .= "*";
		}
	} 
	if ($case == 0) {
		// Save the current line to the array and start the next one
		$grid[$row] = $output;
		$row--;
		$output = "";
		// On the new line add leading dashes and put the asterisk for
		// the column you are starting on.
		for($i = 0; $i < $col; $i++) {
			if ($i == $col - 1) {
				$output .= "*";
			} else {
				$output .= "-";	
			}
		}	
	}
}

// Using the counter to skip the 0th row
$counter = 0;
foreach ($grid as $line){
	$counter++;

	if($counter == 1) {
		continue;
	}

	//Add trailing dashes so that each line is 20 long
	$length = strlen($line);
	while ($length < 20) {
		$line .= "-";
		$length++;
	}
	echo("$line <br />");
}


/*---------------------------------------------*/
echo("<br /><hr />Lower left to upper right and lower right to upper left<br /><br />");
$col1 = 0;
$row1 = 19;
$col2 = 19;
$row2 = 19;
$grid12 = array(
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
	array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
);

// Mark the starting point and loop until you get to end point
$grid12[$col1][$row1]++;
while ($col1 != 19 || $row1 != 0) {
	// Pick a random direction. 1 means change column and 0 means change row
	$case = rand(0,1);

	// If you are already at one edge don't try to change that dimension
	// always change the dimension that isn't at it's goal point
	if ($col1 == 19) {
		$case = 0;
	} 
	if ($row1 == 0) {
		$case = 1;
	}

	// Add 1 to whichever grid position you move to
	if ($case == 1) {
		$col1++;
		$grid12[$col1][$row1]++;
	} 
	if ($case == 0) {
		$row1--;
		$grid12[$col1][$row1]++;
	}	
}

// Mark the starting point and loop until you get to end point
$grid12[$col2][$row2] += 2;
while ($col2 != 0 || $row2 != 0) {
	// Pick a random direction. 1 means change column and 0 means change row
	$case = rand(0,1);

	// If you are already at one edge don't try to change that dimension
	// always change the dimension that isn't at it's goal point
	if ($col2 == 0) {
		$case = 0;
	} 
	if ($row2 == 0) {
		$case = 1;
	}

	// Add 2 to whichever grid position you move to
	if ($case == 1) {
		$col2--;
		$grid12[$col2][$row2] += 2;
	} 
	if ($case == 0) {
		$row2--;
		$grid12[$col2][$row2] += 2;
	}	
}




// Loop through the 2 demensional array and echo the number at that grid
// position. For reasons I am not quite sure about there are positions
// that fall outside the 20x20 grid so discard the numbers after
// the 400th(20x20) one has been printed.
$counter = 0;
foreach($grid12 as $type1) {
	foreach($type1 as $type2) {
		$counter++;
		if ($counter > 400) {
			continue;
		}
		echo($type2);
	}
	echo("<br />");
}


/*---------------------------------------------*/
echo("<br /><hr />Creating an array based on name<br /><br />");
$name = "neal";
$nameArray = array();

// For each character in the $name create an index that goes from the begining
// to that character and have the value of that index be the name cut from
// that index's character and add the cut characters to the end.
for($i = 0; $i < strlen($name); $i++) {
	$nameArray[substr($name,0,$i+1)]  = substr($name,$i);
	$nameArray[substr($name,0,$i+1)] .= substr($name,0,$i);
}

// Use html <pre> tag so that outputed text maintains the line breaks
// that print_r has.
echo("<pre>");
print_r($nameArray);
echo("</pre>");

?>	

	</body>
</html>

