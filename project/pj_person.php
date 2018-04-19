<?php 
/* --------------------------------------------------------------------------------------
 * filename    : pj_person.php
 * author      : nmccarth, <echo "bm1jY2FydGggW2F0XSBzdnN1IFtkb3RdIGVkdQo=" | base64 -d>
 * --------------------------------------------------------------------------------------
 */

include '../../database/header.php';
include '../../database/database.php';
include 'session.php';
echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">Neal McCarthy</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="#">People <span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="pj_projects.php">Projects</a>
			</li>
		</ul>
	</div>
	<a class="nav-link btn btn-warning" href="logout.php">Logout</a>
</nav>
';
interface ICommentsCrud{
	function listTable();
	function readRow();
	function updateRow();
	function deleteRow();
}

class QmComments implements ICommentsCrud {
	function listTable(){
		echo '<body><div class="container">';
		echo '<div class="row"><h3 style="margin: 1em auto;">People</h3></div>';
		// begin table
		echo '<table class="table table-striped table-bordered" style="width: auto !important;margin: 0 auto;"><thead>';
		echo '<tr><th>ID</th><th>Email</th><th>Name</th><th>Actions</th></tr></thead><tbody>';
		$pdo = Database::connect();
		$sql = 'SELECT * FROM pj_persons';
			foreach ($pdo->query($sql) as $row) {
				echo '<tr>';
				echo '<td>' .trim($row['id']) . '</td>';
				echo '<td>' .trim($row['email']) . '</td>';
				echo '<td>' .trim($row['firstName']) . ' ' . trim($row['lastName']) . '</td>';

				// actions
				echo '<td>';
				echo '<a class="btn btn-primary" href="pj_person.php?oper=2&per='.  
					$row['id'] . '">Read</a>';

				echo ' ';
				echo '<a class="btn btn-success" href="pj_person.php?oper=3&per='. 
					$row['id'] . '">Update</a>';

				echo ' ';
				echo '<a class="btn btn-info" href="pj_assignments?oper=0&per='.
					$row['id'] . '">Assignments</a>';

				echo ' ';
				echo '<a class="btn btn-danger" href="pj_person.php?oper=4&per='. 
					$row['id'] . '">Delete</a>';
				echo '</td>';
				echo '</tr>';
			}
		Database::disconnect();
		echo '</tbody></table></div></div></body>';
	}
	function readRow() {
		$id = $_GET['per'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pj_persons where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();

		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3></h3> </div><div class="form-horizontal" >';

		echo '<div class="form-group"><label for="id">ID:</label><input class="form-control"'.
			'readonly value="' . $data['id'] . '"></div>';

		echo '<div class="form-group"><label for="name">Name:</label><input class="form-control"' .
			'readonly value="' . $data['firstName'] . ' ' .$data['lastName'] . '"></div>';

		echo '<div class="form-group"><label for="email">Email:</label><input class="form-control"'.
			'readonly value="' . $data['email'] . '"></div>';


		echo '<a class="btn btn-primary" href="pj_person.php?oper=0">Go Back</a>';
	}

	function updateRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if $_POST filled then process the form
			$id = $_POST['per'];
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$email = $_POST['email'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE pj_persons SET firstName = ?, lastName = ?, email = ? WHERE id= ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($firtName,$lastName,$email, $id));
			Database::disconnect();
			header("Location: pj_person.php?oper=0");
		} else {
			if ($_GET['per'] != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo'<strong>You can not update an account other than your own!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_person.php?oper=0">Go back</a></div>';
				exit;
			}
			$id = $_GET['per'];
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM pj_persons where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		// title of page
		echo '<div class="row"><h3>Update Account</h3></div>';
		echo '<form class="form-horizontal" action="pj_person.php?oper=3" method="post">';

		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';

		echo '<div class="form-group"><label for="firstName">First Name: </label>'.
			'<input class="form-control" name="firstName" id="firstName"'.
			'value="' .$data['firstName'] . '"></div>';

		echo '<div class="form-group"><label for="lastName">Last Name: </label>'.
			'<input class="form-control" name="lastName" id="lastName"'.
			'value="' . $data['lastName'] . '"></div>';

		echo '<div class="form-group"><label for="email">Email: </label>'.
			'<input class="form-control" name="email" id="email"'.
			'value="' . $data['email'] . '"></div>';

		echo '<button type="submit" class="btn btn-success">Update</button><span>   </span>';
		echo '<a class="btn btn-danger" href="pj_person.php?oper=0">Go back</a>';
		echo '</form></div>';
	}

	function deleteRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record
			$id = $_POST['per'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM pj_persons  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: pj_person.php?oper=0");

		} 
		if ($_GET['per'] != $_SESSION['id']) {
			echo '<div class="alert alert-danger">';
			echo'<strong>You can not update an account other than your own!</strong></div>';
			echo '<a class="btn btn-primary" href="pj_person.php?oper=0">Go back</a></div>';
			exit;
		}

		// title of page
		echo '<div class="row"><h3>Delete User</h3></div>';

		echo '<form class="form-horizontal" action="pj_person.php?oper=4" method="post">';
		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<p class="alert alert-error">Are you sure you want to delete ?</p>';
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-danger">Yes</button><span>   </span>';
		echo '<a class="btn btn-success" href="pj_person.php?oper=0">No</a>';
		echo '</div></form><br></div>';
	}
}
switch ($_GET['oper']) {
case 0:  QmComments::listTable(); break;
case 2:  QmComments::readRow()  ; break;
case 3:  QmComments::updateRow(); break;
case 4:  QmComments::deleteRow(); break;
default: echo 'error'; break;
}
?> 
