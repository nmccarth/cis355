<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
	    <div class="row">
		<h3>Customer</h3>
	    </div>
	    <div class="row">
		<p>
		    <a href="create.php" class="btn btn-success">Create</a>
		</p>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email Address</th>
					<th>Mobile Number</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					function format_phone($phone)
					{
    						$phone = preg_replace("/[^0-9]/", "", $phone);
 
						if(strlen($phone) == 7) {
							return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
						} elseif(strlen($phone) == 10) {
							return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
						} else {
							return $phone;
						}
					}
					include 'database.php';
					$pdo = Database::connect();
					$sql = 'SELECT * FROM customers ORDER BY id DESC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['name'] . '</td>';
						echo '<td>'. $row['email'] . '</td>';
						echo '<td>'. format_phone($row['mobile']) . '</td>';
						echo '<td width=250>';
						echo '<a class="btn btn-info" href="read.php?id='.$row['id'].'">Read</a>';
						echo ' ';
						echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
						echo ' ';
						echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
						echo '</td>';
						echo '</tr>';
					}
					Database::disconnect();
					?>
			</tbody>
	</table>
	</div>
    </div> <!-- /container -->
  </body>
</html>
