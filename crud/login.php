<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 */

// Start or resume session, and create: $_SESSION[] array
session_start(); 

require '/home/gpcorser/public_html/database/database.php';
$username_error = "";
$password_error = "";

if ( !empty($_POST)) { // if $_POST filled then process the form
// 	if (!strcmp($_POST['username'],"a") && !strcmp($_POST['password'],"a")) {
// 		$_SESSION['cust_id'] = 1;	
// 		header('Location: index.php');
// 	} else {
// 		session_destroy();
// 		if(strcmp($_POST['username'],'a')) {$username_error = 'invalid username';}
// 		if(strcmp($_POST['password'],'a')) {$password_error = 'invalid password';}
// 	}
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// echo $password . " " . $passwordhash; exit();
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers2 WHERE email = ? AND password_hash = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['cust_id'] = $data['id'];
		$sessionid = $data['id'];
		Database::disconnect();
		header("Location: index.php");
		// javascript below is necessary for system to work on github
		echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
		exit();
	}
	else { // otherwise continue with error messages
		Database::disconnect();
		session_destroy();
		$username_error = 'invalid username/password';
		$password_error = 'invalid password/password';
	}
} 
// if $_POST NOT filled then display login form, below.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
		
			<!--<div class="row">
				<img src="svsu_fr_logo.png" />
			</div> -->
			
			<!--
			<div class="row">
				<br />
				<p style="color: red;">System temporarily unavailable.</p>
			</div>
			-->

			<div class="row">
				<h3>Volunteer Login</h3>
			</div>

			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="form-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
						<?php echo($username_error); ?>
					</div>	
				</div> 
				
				<div class="form-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not your SVSU password, please" required> 
						<?php echo($password_error); ?>
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="fr_per_create2.php">Join (New Volunteer)</a>
				</div>
				
			
				<footer>
					<small>&copy; Copyright 2017, George Corser
					</small>
				</footer>
				
			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>
	

	
