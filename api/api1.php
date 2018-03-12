<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>API01</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
			rel="stylesheet">

	</head>
	<body>

		<div class="container pt-5">
			<h1 class="text-center">People</h1>
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
			
			// Table header
			echo('<table class="table table-striped table-bordered col col-md-auto ">');
			echo('<thead><tr><th scope="col">ID</th><th scope="col">Name</th>' .
				'</tr></thead>');
			
			
			// Get courses with prefix CIS in 18/SP
			$apiCall = "https://csis.svsu.edu/~nmccarth/cis355/api/api2.php";
			$json = curl_get_contents($apiCall);
			$obj = json_decode($json);
			// Output courses with prefix CIS in 18/SP
			foreach($obj->person as $row){
				echo('<tr>');	
					echo('<td>');
						echo($row->id);
					echo('</td>');
					echo('<td>');
						echo($row->fname . ' ' . $row->lname);
					echo('</td>');
				echo('</tr>');	
			}
			
			//close table
			echo('</table>');
			
		?>
			<h3> Want to see the raw JSON?</h3>
			<div><a class="btn btn-primary" href="https://csis.svsu.edu/~nmccarth/cis355/api/api2.php">Yes</a></div>
		</div>
		<!-- Place javascript at end -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</body>
</html>

