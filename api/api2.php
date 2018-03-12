<?php
	include '/home/gpcorser/public_html/database/database.php';
	$pdo = Database::connect();
	$sql = 'SELECT id, fname, lname FROM qm_persons';
	$rows = array();
	foreach ($pdo->query($sql) as $row) {
		$rows['person'][] = array(id=>$row['id'], fname=>$row['fname'], lname=>$row['lname']);
	}
	Database::disconnect();

	$json = json_encode($rows);
	echo($json);
?>
