<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grid Traverser</title>

	</head>
	<body>
		<?php
			$col = 0;
			$row = 19;
			$grid = array("","","","","","","","","","","","","","","","","","","","");
			$output = "";

			while ($col != 19 || $row != 0) {
				$case = rand(0,1);
				if($case == 0 && $col != 20) {
					$col++;
					$output .= "*";
				} elseif ($case == 1 && $row != 1) {
					$grid[$row] = $output;
					$row--;
					$output = "";
					for($i = 0; $i < $col; $i++) {
						$output .= "&nbsp;";	
					}
				}
			}
			foreach ($grid as $line){
				echo("$line <br />");
			}
			echo("test");

		?>	

	</body>
</html>

