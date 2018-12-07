<?php

ini_set('max_execution_time', '0');
// for($i = 0;$i < 12;$i++ ){
// // $i = 0;
// $limit = $i*5000;
$db = new MySQLi("localhost","root","","doubanbook");
$sql = "select DISTINCT url from tag_book_url";
$result = $db->query($sql);
if(!$result){
	echo "error";die();
}
while($attr = $result->fetch_row()){
	// sleep(0.01);
	// $db = new MySQLi("localhost","root","","doubanbook");
	$sql = "insert into book_url (url) values ('{$attr[0]}')";
	$db->query($sql);
	// mysqli_close($db);
}
mysqli_free_result($result);
mysqli_close($db);
echo "ok";
// }