<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Grid Traverser</title>

	</head>
	<body>
		<?php
			$col = 1;
			$row = 1;
			echo("$col,$row<br>");

			while ($col != 20 || $row != 20) {
				$case = rand(0,1);
				if($case == 0 && $col != 20) {
					$col++;
				} elseif ($case == 1 && $row != 20) {
					$row++;
				}
				echo("$col,$row<br>");
			}

		?>	









	</body>
</html>

