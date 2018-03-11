<?php 
/* --------------------------------------------------------------------------------------
 * filename    : qm_comments.php
 * author      : nmccarth, <echo "bm1jY2FydGggW2F0XSBzdnN1IFtkb3RdIGVkdQo=" | base64 -d>
 * description : This program allows a user to view all comments, a particular comment,
 *			edit comments, delete comments, and add comments.
 * --------------------------------------------------------------------------------------
 */

include '/home/gpcorser/public_html/database/header.php';
include '/home/gpcorser/public_html/database/database.php';
// include 'session.php';

interface ICommentsCrud{
	function listTable();
	function createRow();
	function readRow();
	function updateRow();
	function deleteRow();
}

class QmComments implements ICommentsCrud {

	function listTable(){
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Comments</h3></div>';

		// create button
		echo '<div class="row"><p><a href="qm_comments.php?oper=1&per='. $_GET['per'] .
			'&ques=' . $_GET['ques'] . '" class="btn btn-primary">Add Comment</a></p>';

		// begin table
		echo '<table class="table table-striped table-bordered" style="background-color: lightgrey'. 
			'!important"><thead>';
		echo '<tr><th>com id</th><th>per id</th><th>ques id</th><th>Comment</th><th>Rating</th>'.
			'<th>Actions</th></tr></thead><tbody>';


		// populate List table
		$pdo = Database::connect();
		$sql = 'SELECT * FROM qm_comments WHERE per_id=' . $_GET['per'] . ' AND ques_id=' 
			. $_GET['ques'];


		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>' .trim($row['id'])	   . '</td>';
			echo '<td>' .trim($row['per_id'])  . '</td>';
			echo '<td>' .trim($row['ques_id']) . '</td>';
			echo '<td>' .trim($row['comment']) . '</td>';
			echo '<td>' .trim($row['rating'])  . '</td>';

			// actions
			echo '<td>';
			echo '<a class="btn btn-secondary" href="qm_comments.php?oper=2&per='.  $_GET['per'] .
				'&ques=' . $_GET['ques'] . '&com=' . $row['id'] . '">Read</a>';

			echo ' ';
			echo '<a class="btn btn-success" href="qm_comments.php?oper=3&per='. $_GET['per'] .
				'&ques=' . $_GET['ques'] . '&com=' . $row['id'] . '">Update</a>';

			echo ' ';
			echo '<a class="btn btn-danger" href="qm_comments.php?oper=4&per='. $_GET['per'] .
				'&ques=' . $_GET['ques'] . '&com=' . $row['id'] . '">Delete</a>';

			echo '</tr>';
		}
		Database::disconnect();
		echo '</tbody></table></div></div></body>';
	}

	function createRow() {
		if ( !empty($_POST)) { // if not first time through
			echo '<script>console.log("in posted");</script>';
			$per = $_POST['per'];
			$ques = $_POST['ques'];
			$comment = $_POST['comment'];
			$rating = $_POST['rating'];


			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO qm_comments (per_id, ques_id, comment, rating) values(?, ?, ?, ?)"; 
			$q = $pdo->prepare($sql);
			$q->execute(array($per, $ques, $comment, $rating));
			Database::disconnect();

			header('Location: qm_comments.php?oper=0&ques=' . $ques . '&per=' . $per);
		}
		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3>New Comment</h3> </div><form class="form-horizontal" action="qm_comments.php?oper=1" method="post">';

		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<input type="hidden" name="ques" value="' . $_GET['ques'] . '">';
		echo '<div class="form-group"><label for="comment">Comment: </label><input class="form-control" name="comment" id="comment"></div>';

		echo '<div class="form-group"><label for="rating">Rating: </label><input type="numeric" class="form-control" name="rating" id="rating"></div>';

		echo '<button type="submit" class="btn btn-success">Yes</button><span>   </span>';
		echo '<a class="btn btn-danger" href="qm_comments.php?oper=0&per='. $_GET['per'] . '&ques=' . $_GET['ques'] . '">No</a>';
		echo '</form></div>';
	}

	function readRow() {
		$id = $_GET['com'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM qm_comments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();

		echo '<body> <div class="container"> <div class="span10 offset1">';
		echo '<div class="row"> <h3>Comment Details</h3> </div><div class="form-horizontal" >';

		echo '<div class="form-group"><label for="id">ID: </label><input class="form-control" readonly value="' . $data['id'] . '"></div>';

		echo '<div class="form-group"><label for="per_id">Person ID:</label><input class="form-control" readonly value="' . $data['per_id'] . '"></div>';

		echo '<div class="form-group"><label for="ques_id">Question ID:</label><input class="form-control" readonly value="' . $data['ques_id'] . '"></div>';

		echo '<div class="form-group"><label for="comment">Comment:</label><input class="form-control" readonly value="' . $data['comment'] . '"></div>';

		echo '<div class="form-group"><label for="rating">Rating:</label><input class="form-control" readonly value="' . $data['rating'] . '"></div>';

		echo '<a class="btn btn-primary" href="qm_comments.php?oper=0&per=' . $data['per_id'] . '&ques=' . $data['ques_id'] . '">Go Back</a>';
	}

	function updateRow() {
		if ( !empty($_POST)) { // if $_POST filled then process the form
			$id = $_POST['com'];
			$comment = $_POST['comment'];
			$rating = $_POST['rating'];
			$per = $_POST['per'];
			$ques = $_POST['ques'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE qm_comments SET per_id = ? , ques_id = ?, comment = ?, rating = ? WHERE id= ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($per, $ques, $comment, $rating, $id));
			Database::disconnect();
			header("Location: qm_comments.php?oper=0&ques=". $ques . '&per=' . $per);
		} else {
			$id = $_GET['com'];
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM qm_comments where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Update Comment</h3></div>';
		echo '<form class="form-horizontal" action="qm_comments.php?oper=3" method="post">';

		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<input type="hidden" name="com" value="' . $_GET['com'] . '">';
		echo '<input type="hidden" name="ques" value="' . $_GET['ques'] . '">';

		echo '<div class="form-group"><label for="comment">Comment: </label><input class="form-control" name="comment" id="comment"'.
			'value="' .$data['comment'] . '"></div>';
		echo '<div class="form-group"><label for="rating">Rating: </label><input type="numeric" class="form-control" name="rating" id="rating"'.
			'value="' . $data['rating'] . '"></div>';

		echo '<button type="submit" class="btn btn-success">Update</button><span>   </span>';
		echo '<a class="btn btn-danger" href="qm_comments.php?oper=0&per='. $_GET['per'] . '&ques=' . $_GET['ques'] . '">Go back</a>';
		echo '</form></div>';
	}

	function deleteRow() {
		if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record
			$id = $_POST['id'];
			$ques = $_POST['ques'];
			$per = $_POST['per'];

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM qm_comments  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: qm_comments.php?oper=0&ques=". $ques . '&per=' . $per);

		} 
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Delete Comment</h3></div>';

		echo '<form class="form-horizontal" action="qm_comments.php?oper=4" method="post">';
		echo '<input type="hidden" name="id" value="' . $_GET['com'] . '">';
		echo '<input type="hidden" name="ques" value="' . $_GET['ques'] . '">';
		echo '<input type="hidden" name="per" value="' . $_GET['per'] . '">';
		echo '<p class="alert alert-error">Are you sure you want to delete ?</p>';
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-danger">Yes</button><span>   </span>';
		echo '<a class="btn btn-success" href="qm_comments.php?oper=0&per='. $_GET['per'] . '&ques=' . $_GET['ques'] . '">No</a>';
		echo '</div></form><br></div>';


	}
}

switch ($_GET['oper']) {
	case 0:  QmComments::listTable(); break;
	case 1:  QmComments::createRow(); break;
	case 2:  QmComments::readRow()  ; break;
	case 3:  QmComments::updateRow(); break;
	case 4:  QmComments::deleteRow(); break;
	default: echo 'error'; break;
}
?> 
