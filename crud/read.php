<?php
require '../../database/database.php';
$id = null;
if ( !empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

if ( null==$id ) {
	header("Location: index.php");
} else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();
}
?>

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
    <div class="span10 offset1">
	<div class="row">
	     <h3>Read a Customer</h3>
	</div>
	<div class="form-group">
	    <div class="control-group">
		<label class="">Name</label>
		<div class="form-control">
		    <label class="form-check">
			<?php echo $data[ 'name'];?>
		    </label>
		</div>
	    </div>
	    <div class="control-group">
		<label class="">Email Address</label>
		<div class="form-control">
		    <label class="form-check">
			<?php echo $data[ 'email'];?>
		    </label>
		</div>
	    </div>
	    <div class="control-group">
		<label class="">Mobile Number</label>
		<div class="form-control">
		    <label class="form-check">
			<?php echo $data[ 'mobile'];?>
		    </label>
		</div>
	    </div>
	</div>      
	<a class="btn btn-primary" href="index.php">Back</a>


</body>
</html>
