<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>JSON Encoding</title>

	</head>
	<body>
		<?php
			echo('<pre>');
			$cars = array(
				"chevy"  => array(
					"volt" => 12 
					"malibu" => 3 
					"s10" => 15
				),
				"toyota" => array(
					"camry" => 5
					"prius" => 6
				),
				"ford"   => array(
					"escort" => 4
					"escape" => 8
				)
			);
			print_r($cars);

			$myJSON = json_encode($cars);	
			echo('<br>' . $myJSON);
			echo('</pre>');
		?>
		<!-- Place javascript at end -->
		<script type="text/javascript">


		</script>
		</body>
</html>

