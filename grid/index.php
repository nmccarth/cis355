<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grid Traverser</title>
		<style>
			body { 
				font-family: Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;
				line-height: 2;	
			}
		</style>
	</head>
	<body>
<?php
echo("Lower left to upper right<br /><br />");
$col = 1;
$row = 20;
$grid = array("","","","","","","","","","","","","","","","","","","","");
$output = "*";
//echo("<script>console.log('");
//echo("$col , $row ");
//echo("')</script>");


while ($col != 20 || $row != 0) {
	$case = rand(0,1);
	if ($col == 20) {
		$case = 0;
	} 
	if ($row == 0) {
		$case = 1;
	}
	if ($case == 1) {
			$col++;
			$output .= "*";
	} 
	if ($case == 0) {
		$grid[$row] = $output;
		$row--;
		$output = "";
		for($i = 0; $i < $col; $i++) {
			if ($i == $col - 1) {
				$output .= "*";
			} else {
				$output .= "-";	
			}
		}	
	}
	//echo("<script>console.log('");
	//echo("$col , $row , $case");
	//echo("')</script>");
}
$counter = 0;
foreach ($grid as $line){
	$counter++;
	
	if($counter == 1) {
		continue;
	}
	$length = strlen($line);
	while ($length < 20) {
		$line .= "-";
		$length++;
	}
	echo("$line <br />");
}

/*---------------------------------------------*
echo("<br /><hr />Lower left to upper right and lower right to upper left<br /><br />");
$col1 = 0;
$row1 = 19;
$col1 = 19;
$row2 = 19;
//$grid = array("","","","","","","","","","","","","","","","","","","","");
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

$grid12[$col1][$row1] += 1;
while($col1 != 19 || $row1 != 0) {
	$case = rand(0,1);
	if ($case == 1 && $col1 != 19) {
		$col1++;
		$grid12[$col1][$row1] += 1;
	} else {
		$row1++;
		$grid12[$col1][$row1] += 1;
	}
}
echo("test");
foreach ($grid12 as $type1) {
	foreach ($type1 as $type2) {
		echo($type2);
	}
	echo("<br />");
}*/

?>	

	</body>
</html>

