<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Quadratic Result</title>
	</head>
	<body>
		<?php
			$aVar = $_POST["aVar"];
			$bVar = $_POST["bVar"];
			$cVar = $_POST["cVar"];
			$resOne = (-$bVar - sqrt(($bVar * $bVar) - (4 * $aVar * $cVar))) / (2 * $aVar);
			$resTwo = (-$bVar + sqrt(($bVar * $bVar) - (4 * $aVar * $cVar))) / (2 * $aVar);
			if(is_nan($resOne) && !is_nan($resTwo))
				echo "Result is $resTwo";
			else if(is_nan($resTwo) && !is_nan($resOne))
				echo "Result is $resOne";
			else if(!is_nan($resOne) && !is_nan($resTwo))
				echo "Result is $resOne and $resTwo";
			else
				echo "Can't find result";

		?>
			<button onclick="window.history.back();">Try Another</button>
	</body>
</html>

