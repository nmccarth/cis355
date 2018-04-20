<?php
include '../../database/database.php';
include '../../database/header.php';

// Start or resume session, and create: $_SESSION[] array
session_destroy(); // destroy any existing session
session_start(); // and start a new one

if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['email']; // username is email address, db field is email
	$password = $_POST['password']; // db field is password

	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT id,email,password FROM pj_persons WHERE email = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username));
	$data = $q->fetch(PDO::FETCH_ASSOC);

	if($data) { // if successful login set session variables
		if (password_verify($password,$data['password'])) {
			$_SESSION['id'] = $data['id']; 
   			header("Location: pj_person.php?oper=0");
		}
	} else { // otherwise go to login error page
		session_destroy();
		Database::disconnect();
		header("Location: login.php");
	}
	Database::disconnect();
}
?>
<body>
	<div class="container">
		<form class="form-signin" action="#" method="post">
			<h2 class="form-signin-heading">Please sign in</h2>
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" name="email" id="email" class="form-control" placeholder="Email address" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputPassword">Password</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
			</div>
			<button class="btn btn-lg btn-primary" type="submit">Sign in</button>
			<a class="btn btn-lg btn-info" href="pj_register.php">Register</a>
		</form>


		<footer>
			<small>&copy;
			</small>
		</footer>




	</div> <!-- end div: class="container" -->
</body>

</html>
