<?php 
/* --------------------------------------------------------------------------------------
 * filename    : pj_projects.php
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
				<a class="nav-link" href="pj_person.php">People</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="#">Projects<span class="sr-only">(current)</span></a>
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
		echo '<div class="row"><h3 style="margin: 1em auto;">Projects</h3></div>';
		
		// create a new projects
		echo '<div class="row"><p><a href="pj_projects.php?oper=1" class="btn btn-primary">Add a project</a></p>';

		// begin table
		echo '<table class="table table-striped table-bordered" style="width: auto !important;margin: 0 auto;"><thead>';
		echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Date</th><th>Lead</th><th>Contact</th><th>Actions</th></tr></thead><tbody>';
		$pdo = Database::connect();
		$sql = 'SELECT j.id,j.name,j.description,j.date,j.lead_fk,p.id as per_id,p.firstName,p.lastName,p.email FROM pj_projects j,pj_persons p WHERE p.id = j.lead_fk';
			foreach ($pdo->query($sql) as $row) {
				echo '<tr>';
				echo '<td>' .trim($row['id']) . '</td>';
				echo '<td>' .trim($row['name']) . '</td>';
				echo '<td>' .trim($row['description']) . '</td>';
				echo '<td>' .trim($row['date']) . '</td>';
				echo '<td>' .trim($row['firstName']) . ' ' . trim($row['lastName']) . '</td>';
				echo '<td>' .trim($row['email']) . '</td>';

				// actions
				echo '<td>';
				echo '<a class="btn btn-primary" href="pj_projects.php?oper=2&proj='.  
					$row['id'] . '">Read</a>';

				echo ' ';
				echo '<a class="btn btn-success" href="pj_projects.php?oper=3&proj='. 
					$row['id'] . '&lead=' . $row['lead_fk'] . '">Update</a>';

				echo ' ';
				echo '<a class="btn btn-info" href="pj_assignments?oper=1&proj='.
					$row['id'] . '">Assign</a>';

				echo ' ';
				echo '<a class="btn btn-danger" href="pj_projects.php?oper=4&proj='. 
					$row['id'] . '&lead=' . $row['lead_fk'] . '">Delete</a>';
				echo '</td>';
				echo '</tr>';
			}
		Database::disconnect();
		echo '</tbody></table></div></div></body>';
	}
	function createRow() {
		if ( !empty($_POST)) { // if not first time through
			$name = $_POST['name'];
			$description = $_POST['desc'];
			$date = $_POST['date'];
			$lead = $_POST['lead'];


			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO pj_projects (name, description, date, lead_fk) values(?, ?, ?, ?)"; 
			$q = $pdo->prepare($sql);
			$q->execute(array($name, $description, $date, $lead));
			Database::disconnect();

			header('Location: pj_projects.php?oper=0');
		}
		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3>New Comment</h3> </div><form class="form-horizontal" action="pj_projects.php?oper=1" method="post">';

		echo '<input type="hidden" name="lead" value="' . $_SESSION['id'] . '">';
		echo '<div class="form-group"><label for="name">Project Name: </label><input class="form-control" name="name" maxlength="255"></div>';

		echo '<div class="form-group"><label for="desc">Description: </label><input class="form-control" name="desc" maxlength="500"></div>';
		
		echo '<div class="form-group"><label for="date">Date: </label><input type="date" class="form-control" name="date"></div>';
		echo '<button type="submit" class="btn btn-success">Yes</button><span>   </span>';
		echo '<a class="btn btn-danger" href="qm_comments.php?oper=0&per='. $_GET['per'] . '&ques=' . $_GET['ques'] . '">No</a>';
		echo '</form></div>';
	}

	function readRow() {
		$id = $_GET['proj'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pj_projects,pj_persons WHERE pj_projects.id = ? AND pj_projects.lead_fk = pj_persons.id";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();

		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3></h3> </div><div class="form-horizontal" >';

		echo '<div class="form-group"><label for="id">ID:</label><input class="form-control"'.
			'readonly value="' . $data['id'] . '"></div>';

		echo '<div class="form-group"><label for="name">Name:</label><input class="form-control"' .
			'readonly value="' . $data['name'] . '"></div>';

		echo '<div class="form-group"><label for="name">Description:</label><input class="form-control"' .
			'readonly value="' . $data['description'] . '"></div>';

		echo '<div class="form-group"><label for="">Date:</label><input type="date" class="form-control"'.
			'readonly value="' . $data['date'] . '"></div>';

		echo '<div class="form-group"><label for="">Date:</label><input class="form-control"'.
			'readonly value="' . $data['firstName'] . ' ' . $data['lastName'] . '"></div>';

		echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go Back</a>';
	}

	function updateRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if $_POST filled then process the form
			$id = $_POST['id'];
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$date = $_POST['date'];
			$lead = $_POST['lead_fk'];

			if ($lead != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo'<strong>Sneaky! You can not update a project that you are not the lead of!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go back</a></div>';
				exit;
			}
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE pj_projects SET name = ?, description = ?, date = ? WHERE id= ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$desc,$date, $id));
			Database::disconnect();
			header("Location: pj_projects.php?oper=0");
		} else {
			if ($_GET['lead'] != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo'<strong>You can not update a project that you are not the lead of!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go back</a></div>';
				exit;
			}
			$id = $_GET['proj'];
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM pj_projects where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		// title of page
		echo '<div class="row"><h3>Update Account</h3></div>';
		echo '<form class="form-horizontal" action="pj_projects.php?oper=3" method="post">';

		echo '<input type="hidden" name="id" value="' . $_GET['proj'] . '">';
		echo '<input type="hidden" name="lead_fk" value="' . $_GET['lead'] . '">';

		echo '<div class="form-group"><label for="name">Project Name: </label>'.
			'<input class="form-control" name="name" id="name"'.
			'value="' .$data['name'] . '" maxlength="255"></div>';

		echo '<div class="form-group"><label for="desc">Description: </label>'.
			'<input class="form-control" name="desc" id="desc"'.
			'value="' . $data['description'] . '" maxlength="500"></div>';

		echo '<div class="form-group"><label for="email">Email: </label>'.
			'<input type="date" class="form-control" name="date" id="date"'.
			'value="' . $data['date'] . '"></div>';

		echo '<button type="submit" class="btn btn-success">Update</button><span>   </span>';
		echo '<a class="btn btn-danger" href="pj_projects.php?oper=0">Go back</a>';
		echo '</form></div>';
	}

	function deleteRow() {
		echo '<body><div class="container">';
		if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record
			$id = $_POST['proj'];
			$lead = $_POST['lead'];
			
			if ($lead != $_SESSION['id']) {
				echo '<div class="alert alert-danger">';
				echo'<strong>Sneaky! You can not delete a project that you do not lead!</strong></div>';
				echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go back</a></div>';
				exit;
			}

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM pj_projects  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: pj_projects.php?oper=0");

		} 
		if ($_GET['lead'] != $_SESSION['id']) {
			echo '<div class="alert alert-danger">';
			echo'<strong>You can not delete a project that you do not lead!</strong></div>';
			echo '<a class="btn btn-primary" href="pj_projects.php?oper=0">Go back</a></div>';
			exit;
		}

		// title of page
		echo '<div class="row"><h3>Delete User</h3></div>';

		echo '<form class="form-horizontal" action="pj_projects.php?oper=4" method="post">';
		echo '<input type="hidden" name="proj" value="' . $_GET['proj'] . '">';
		echo '<input type="hidden" name="lead" value="' . $_GET['lead'] . '">';
		echo '<p class="alert alert-error">Are you sure you want to delete ?</p>';
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-danger">Yes</button><span>   </span>';
		echo '<a class="btn btn-success" href="pj_projects.php?oper=0">No</a>';
		echo '</div></form><br></div>';
	}
}
switch ($_GET['oper']) {
case 0:  QmComments::listTable(); break;
case 1:	 QmComments::createRow(); break;
case 2:  QmComments::readRow()  ; break;
case 3:  QmComments::updateRow(); break;
case 4:  QmComments::deleteRow(); break;
default: echo 'error'; break;
}
?> 
