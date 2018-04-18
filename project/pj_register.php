<!DOCTYPE html>
<?php
include '../../database/database.php'; // html <head> section
include '../../database/header.php'; // html <head> section

if ( !empty($_POST)) {
	// keep track validation errors
	$fnameError = null;
	$lnameError = null;
	$emailError = null;
	$passwordError = null;

	// keep track post values
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_hash = password_hash($password, PASSWORD_DEFAULT)

		// validate input
		$valid = true;
	if (empty($fname)) {
		$fnameError = 'Please enter First Name';
		$valid = false;
	}
	if (empty($lname)) {
		$lnameError = 'Please enter Last Name';
		$valid = false;
	}

	if (empty($email)) {
		$emailError = 'Please enter Email Address';
		$valid = false;
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$emailError = 'Please enter a valid Email Address';
		$valid = false;
	}
	if (empty($password)) {
		$passwordError = 'Please enter password';
		$valid = false;
	}
	//not validated


	// insert data
	if ($valid) {

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO pj_persons (fname, lname, email,  password_hash) values(?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($fname, $lname, $email, $password_hash));
		Database::disconnect();
		header("Location: login.php");
	}
}
?>

 <body style="background-color: lightblue !important";>
	<div class="container">
		<div class="row">
			<h3>Create a Person</h3>
		</div>
			 <form class="form-horizontal" action="pj_register.php" method="post">
		      <div class="control-group <?php echo !empty($fnameError)?'error':'';?>">
			<label class="control-label">First Name</label>
			<div class="controls">
			    <input required name="fname" type="text"  placeholder="First Name" value="<?php echo !empty($fname)?$fname:'';?>">
			    <?php if (!empty($fnameError)): ?>
				<span class="help-inline"><?php echo $fnameError;?></span>
			    <?php endif; ?>
			</div>
		      </div>
					  <div class="control-group <?php echo !empty($lnameError)?'error':'';?>">
			<label class="control-label">Last Name</label>
			<div class="controls">
			    <input required name="lname" type="text"  placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
			    <?php if (!empty($lnameError)): ?>
				<span class="help-inline"><?php echo $lnameError;?></span>
			    <?php endif; ?>
			</div>
		      </div>
		      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
			<label class="control-label">Email Address</label>
			<div class="controls">
			    <input required name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
			    <?php if (!empty($emailError)): ?>
				<span class="help-inline"><?php echo $emailError;?></span>
			    <?php endif;?>
			</div>
		      </div>
					  <br>
		      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
			<label class="control-label">Password</label>
			<div class="controls">
			    <input required name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
			    <?php if (!empty($passwordError)): ?>
				<span class="help-inline"><?php echo $passwordError;?></span>
			    <?php endif;?>
			</div>
		      </div>
					  <br>
		      <div class="form-actions">
			  <button type="submit" class="btn btn-success">Create</button>
			  <a class="btn btn-danger" href="login.php">Back</a>
			</div>
		    </form>
	</div>
	<h3>qm_per_create done by George Beeman</h3>
	<p>Contact email: gabeeman@svsu.edu</p>
  </body>
</html>

