<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 * The system knows the login is successful if $_SESSION['role'] is set.
 */
// Start or resume session, and create: $_SESSION[] array
session_destroy(); // destroy any existing session
session_start(); // and start a new one

include '../../public_html/database/database.php';
include '../../public_html/database/header.php';

if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address, db field is email
	$password = $_POST['password']; // db field is password_hash

	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM pj_persons WHERE email = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username));
	$data = $q->fetch(PDO::FETCH_ASSOC);

	if($data) { // if successful login set session variables
		if (password_verify($password,$data['password']) {
			$_SESSION['id'] = $data['id']; 
			header("Location: pj_person.php?oper=0");
		}
	}
	Database::disconnect();
}
else { // otherwise go to login error page
	session_destroy();
	Database::disconnect();
	header("Location: login_error.html");
}
} 
// if $_POST NOT filled then display login form, below.
?>

<body>
    <div class="container">

		<div class="span10 offset1">

			<div class="row">
				<h3>Login</h3>
			</div>

			<form class="form-horizontal" action="login.php" method="post">

				<div class="control-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
					</div>	
				</div> 

				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not your SVSU password, please" required> 
					</div>	
				</div> 

					<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="pj_register.php">Register</a>

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
