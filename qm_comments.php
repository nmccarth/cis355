<?php 

include '/home/gpcorser/public_html/database/header.php';
include '/home/gpcorser/public_html/database/database.php';
// include 'session.php';

class QmComments { 

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
		echo '<tr><th>com id</th><th>per id</th><th>ques id</th><th>comment</th><th>rating</th>'.
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
			echo '<a class="btn btn-secondary" href="qm_comments.php?oper=2&per='. $_GET['per'] .
				'&ques=' . $_GET['ques'] . '">Read</a>';

			echo ' ';
			echo '<a class="btn btn-success" href="qm_comments.php?oper=3&per='. $_GET['per'] .
				'&ques=' . $_GET['ques'] . '&com=' . $row['id'] . '">Update</a>';

			echo ' ';
			echo '<a class="btn btn-danger" href="qm_comments.php?oper=4&per='. $_GET['per'] .
				'&ques=' . $_GET['ques'] . '&com=' . $row['id'] . '">Update</a>';

			echo '</tr>';
		}
		Database::disconnect();
		echo '</tbody></table></div></div></body>';
	}

	function createRow() {
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Create Comment</h3></div>';

		echo '<form class="form-horizontal" action="qm__comments.php" method="get">';
		echo '<div class="form-group row"><label for="comment" class="col-2 col-form-label">';
		echo 'Comment</label><div class="col-10"><input class="form-control" type="text" id="comment';
		echo '"></div></div><div class="form-group row"><label for="rating" class="col-2';
		echo ' col-form-label">Rating</label><div class="col-10"><input class="form-control"';
		echo ' type="number" id="rating"></div></div>';

		echo '<div class="form-actions"><button type="submit" class="btn btn-success">Create</button';
		echo '><a class="btn btn-danger" href="qm_per_list.php">Back</a></div></form>'


		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO qm_comments (per_id, ques_id, comment, rating) values(?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($GET_['per'], $GET_['ques'], $GET_['comment'], $GET_['rating']));
		Database::disconnect();
		header("Location: qm_comments");

	}

	function readRow() {
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Read Comment</h3></div>';

	}

	function updateRow() {
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Update Comment</h3></div>';

	}

	function deleteRow() {
		// begin body section
		echo '<body><div class="container">';

		// title of page
		echo '<div class="row"><h3>Comments</h3></div>';

	}
}

switch ($_GET['oper']) {
case 0: QmComments::listTable(); break;
case 1: QmComments::createRow(); break;
case 2: QmComments::readRow()  ; break;
case 3: QmComments::updateRow(); break;
case 4: QmComments::deleteRow(); break;
}
?> 
