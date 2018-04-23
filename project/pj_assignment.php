<?php 
/* --------------------------------------------------------------------------------------
 * filename    : pj_assignment.php
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
				<a class="nav-link" href="pj_person.php?oper=0">People</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="pj_projects.php?oper=0">Projects</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="pj_assignment.php?oper=0">Assignments<span class="sr-only">(current)</span></a>
			</li>
		</ul>
	</div>
	<a class="nav-link btn btn-warning" href="logout.php">Logout</a>
</nav>
';
interface IAssignmentCrud{
	function listTable();
	function createRow();
	function readRow();
	function updateRow();
	function deleteRow();
}

class PjAssignment implements IAssignmentCrud {
	function listTable(){
		echo '<body><div class="container">';
		echo '<div class="row"><h3 style="margin: 1em auto;">Assignments</h3></div>';

		// create a new projects
		// echo '<p><a href="pj_assignment.php?oper=1" class="btn btn-primary">Add a project</a></p>';

		// begin table
		echo '<table class="table table-striped table-bordered" style="width: auto !important;margin: 0 auto;"><thead>';
		echo '<tr><th>Project ID</th><th>Project Name</th><th>Assignee ID</th><th>Assigned To</th><th>Comments</th><th>Actions</th></tr></thead><tbody>';
		$pdo = Database::connect();
		$sql = 'SELECT * FROM pj_assignments a, pj_persons p, pj_projects j WHERE j.id = a.project_fk AND p.id = a.person_fk';
		if (isset($_GET['per'])) {
			$sql .= ' AND a.person_fk = ' . $_GET['per'];
		}
		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>' .trim($row['project_fk']) . '</td>';
			echo '<td>' .trim($row['name']) . '</td>';
			echo '<td>' .trim($row['person_fk']) . '</td>';
			echo '<td>' .trim($row['firstName']) . ' ' . trim($row['lastName']) . '</td>';
			echo '<td>' .trim($row['comments']) . '</td>';

			// actions
			echo '<td>';
			echo '<a class="btn btn-primary" href="pj_assignment.php?oper=2&per=' . $row['person_fk'] . 
				'&proj=' . $row['project_fk'] . '">Read</a>';

			echo ' ';
			echo '<a class="btn btn-success" href="pj_assignment.php?oper=3&per='. $row['person_fk'] . 
				'&proj=' . $row['project_fk'] . '">Update</a>';

			echo ' ';
			echo '<a class="btn btn-danger" href="pj_assignment.php?oper=4&per='. $row['person_fk'] . 
				'&proj=' . $row['project_fk'] . '">Delete</a>';
			echo '</td>';
			echo '</tr>';
		}
		Database::disconnect();
		echo '</tbody></table></div></div></body>';
	}
	function createRow() {
		if ( !empty($_POST)) { // if not first time through
			$project = $_POST['proj'];
			$person  = $_POST['per'];
			$comment = $_POST['comment'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO pj_assignments (person_fk, project_fk, comments) values(?, ?, ?)"; 
			$q = $pdo->prepare($sql);
			$q->execute(array($person, $project, $comment));
			Database::disconnect();

			header('Location: pj_assignment.php?oper=0');
		}
		echo '<body> <div class="container"> <div class="span10 offset1">';
		if (!isset($_GET['proj'])) {
			echo '<div class="alert alert-danger">';
			echo '<strong>You can not have a dangling assignment, select a project to assign to!</strong></div>';
			echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go back</a></div>';
			exit;

		}
		echo '<div class="row"> <h3>Add a new assignment?</h3> </div><form class="form-horizontal" action="pj_assignment.php?oper=1" method="post">';

		echo '<input type="hidden" name="proj" value="' . $_GET['proj'] . '">';
		echo '<input type="hidden" name="per" value="' . $_SESSION['id'] . '">';

		echo '<div class="form-group"><label for="comment">Comment: </label><input class="form-control" name="comment" maxlength="500"></div>';

		echo '<button type="submit" class="btn btn-success">Yes</button><span>   </span>';
		echo '<a class="btn btn-danger" href="pj_projects.php?oper=0">No</a>';
		echo '</form></div>';
	}

	function readRow() {
		if (!isset($_GET['proj']) || !isset($_GET['per'])) {
			echo '<div class="alert alert-danger">';
			echo '<strong>You did something wrong, go back to the assignments list!</strong></div>';
			echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
			exit;
		}
		$per = $_GET['per'];
		$proj = $_GET['proj'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pj_assignments WHERE person_fk = ? AND project_fk = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($per, $proj));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();

		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3></h3> </div><div class="form-horizontal" >';

		echo '<div class="form-group"><label for="id">Project ID:</label><input class="form-control"'.
			'readonly value="' . $data['project_fk'] . '"></div>';

		echo '<div class="form-group"><label for="name">Asignee ID:</label><input class="form-control"' .
			'readonly value="' . $data['person_fk'] . '"></div>';

		echo '<div class="form-group"><label for="name">Assignment Comment:</label><input class="form-control"' .
			'readonly value="' . $data['comments'] . '"></div>';

		echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go Back</a>';
	}

	function updateRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if $_POST filled then process the form
			$per = $_POST['per'];
			$proj = $_POST['proj'];
			$comm = $_POST['comm'];

			if ($per != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo'<strong>Sneaky! You can not update an assignment that you are not the assignee of!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
				exit;
			}
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE pj_assignments SET comments = ?  WHERE person_fk = ? AND project_fk = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($comm,$per,$proj));
			Database::disconnect();
			header("Location: pj_assignment.php?oper=0");
		} else {
			if (!isset($_GET['per']) || !isset($_GET['proj'])) {
				echo '<div class="alert alert-danger">';
				echo'<strong>You are missing some critical information, go back to the list.</strong></div>';
				echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
				exit;
			}
			if ($_GET['per'] != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo '<strong>You can not update an assignment that you are not the assignee of!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
				exit;
			}
			$per = $_GET['per'];
			$proj = $_GET['proj'];
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM pj_assignments WHERE person_fk = ? AND project_fk = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($per, $proj));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		// title of page
		echo '<div class="row"><h3>Update Account</h3></div>';
		echo '<form class="form-horizontal" action="pj_assignment.php?oper=3" method="post">';

		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<input type="hidden" name="proj" value="' . $_GET['proj'] . '">';

		echo '<div class="form-group"><label for="comm">Comments: </label>'.
			'<input class="form-control" name="comm" id="comm"'.
			'value="' .$data['comments'] . '" maxlength="500"></div>';

		echo '<button type="submit" class="btn btn-success">Update</button><span>   </span>';
		echo '<a class="btn btn-danger" href="pj_assignment.php?oper=0">Go back</a>';
		echo '</form></div>';
	}

	function deleteRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record
			$per  = $_POST['per'];
			$proj = $_POST['proj'];

			if ($per != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo '<strong>Sneaky! You can not delete an assignment that you are not the assignee of!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
				exit;
			}

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM pj_projects  WHERE person_fk = ? AND project_fk = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($per, $proj));
			Database::disconnect();
			header("Location: pj_assignment.php?oper=0");
		} 
		if (!isset($_GET['per']) || !isset($_GET['proj'])) {
				echo '<div class="alert alert-danger">';
				echo'<strong>You are missing some critical information, go back to the list.</strong></div>';
				echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
				exit;
		}
		if ($_GET['per'] != $_SESSION['id']) {
			echo '<div class="alert alert-danger">';
			echo'<strong>You can not delete an assignment that you are not the assignee of!</strong></div>';
			echo '<a class="btn btn-primary" href="pj_assignment.php?oper=0">Go back</a></div>';
			exit;
		}
		// title of page
		echo '<div class="row"><h3>Delete User</h3></div>';

		echo '<form class="form-horizontal" action="pj_assignment.php?oper=4" method="post">';
		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<input type="hidden" name="proj" value="' . $_GET['proj'] . '">';
		echo '<p class="alert alert-error">Are you sure you want to delete ?</p>';
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-danger">Yes</button><span>   </span>';
		echo '<a class="btn btn-success" href="pj_assignment.php?oper=0">No</a>';
		echo '</div></form><br></div>';
	}
}
switch ($_GET['oper']) {
case 0:  PjAssignment::listTable(); break;
case 1:	 PjAssignment::createRow(); break;
case 2:  PjAssignment::readRow()  ; break;
case 3:  PjAssignment::updateRow(); break;
case 4:  PjAssignment::deleteRow(); break;
default: echo 'error'; break;
}
?> 
