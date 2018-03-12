<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Using Curl to get JSON</title>
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	</head>
	<body>
		<?php
			function curl_get_contents($url)
			{	
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_HEADER,0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);

				$data = curl_exec($ch);
				curl_close($ch);

				return $data;

			};	
			
			$apiCall = "https://api.svsu.edu/courses?prefix=CIS&term=18/SP";
			$json = curl_get_contents($apiCall);
			$obj = json_decode($json);

			echo('<div class="container pt-5">');
			echo('<table class="table table-striped table-bordered col col-md-auto ">');
			echo('<thead><tr><th scope="col">Prefix</th><th scope="col">courseNumber</th></tr></thead>');
			foreach($obj->courses as $row){
				echo('<tr>');	
					echo('<td>');
						echo($row->prefix);
					echo('</td>');
					echo('<td>');
						echo($row->courseNumber);
					echo('</td>');
				echo('</tr>');	
			}
			echo('</table>');
			echo('</div>');
// 			echo('<pre>' . $json . '<br />');
// 
// 			print_r($obj);
// 			echo($obj->courses[0]->academicLevel);
// 			echo('</pre>');
		
		?>
		<!-- Place javascript at end -->

		</body>
</html>

