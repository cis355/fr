<?php
/* ---------------------------------------------------------------------------
 * filename    : fr_test.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program resets all passwords to "robot"
 * ---------------------------------------------------------------------------
 */

include '../database/database.php';

// ------------------------------------------------
// create an array from the table
// ------------------------------------------------
$pdo = Database::connect();
$sql = "SELECT * FROM fr_persons";
$persons = array();
$personcount = 0;
$lastid = 0;
foreach ($pdo->query($sql) as $row) {
	$personcount++;
	$t = array($row['id'],$row['fname'],$row['lname'],$row['email'],$row['mobile'],$row['password'],$row['filename'],$row['filesize'],$row['filetype'],$row['filecontent'],$row['title']); 
	array_push($persons, $t);
	echo $row['id'] . " ";
}
Database::disconnect();
echo "array created. <br />";


// ------------------------------------------------
// replace every record in the table
// ------------------------------------------------
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
for($i=0; $i < $personcount; $i++) {
	$sql = "DELETE FROM fr_persons WHERE id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($persons[$i][0]));
	$sql = "INSERT INTO fr_persons (id,fname,lname,email,mobile,password,filename,filesize,filetype,filecontent,title) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($persons[$i][0],$persons[$i][1],$persons[$i][2],$persons[$i][3],$persons[$i][4],$persons[$i][5],$persons[$i][6],$persons[$i][7],$persons[$i][8],$persons[$i][9],$persons[$i][10]));
}
Database::disconnect();
echo ("done."); exit();

?>