<?php
mysql_connect("localhost","nmccarth","correct horse battery staple");
mysql_select_db("nmccarth");

$id = 1; 
if(isset($_POST['img_id'])) $id = $_POST['img_id'];

$query = "SELECT name, size, content, type 
	FROM gpc_upload2 WHERE id=$id";
$result  = mysql_query ($query);
$name    = mysql_result($result, 0, "name");
$size    = mysql_result($result, 0, "size");
$type    = mysql_result($result, 0, "type");
$content = mysql_result($result, 0, "content");
header("Content-length: $size");
header("Content-type: $type");
// header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=$name");
ob_clean();
flush();
echo $content;
exit;

?>
