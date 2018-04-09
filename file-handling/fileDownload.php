<?php

// connect to database
mysql_connect("localhost","nmccarth","correct horse battery staple");
mysql_select_db("nmccarth");

$query = "SELECT id, name, size, type FROM gpc_upload2";
$result  = mysql_query ($query);

// display list
while ($row = mysql_fetch_assoc($result)) 
{
	echo "<p>" . $row['id'] . ' ' . $row['name'] . 
		' ' . $row['size'] . ' ' . $row['type'] . "</p>";
}
echo "<form method='post' action='d2.php' >";
echo "<input name='img_id' type='text'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
echo '<a href="fileUpload.php">Upload more files</a>';
?>
