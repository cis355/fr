<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_assign_update.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program updates an assignment (table: fr_assignments)
 * ---------------------------------------------------------------------------
 */
session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
require '../database/database.php';
require 'functions.php';

$id = $_GET['id'];

if ( !empty($_POST)) { // if $_POST filled then process the form
	
	# same as create

	// initialize user input validation variables
	$personError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$person = $_POST['person_id'];    // same as HTML name= attribute in put box
	$event = $_POST['event_id'];
	
	// validate user input
	$valid = true;
	if (empty($person)) {
		$personError = 'Please choose a volunteer';
		$valid = false;
	}
	if (empty($event)) {
		$eventError = 'Please choose an event';
		$valid = false;
	} 
		
	if ($valid) { // if valid user input update the database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE fr_assignments set assign_per_id = ?, assign_event_id = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($person,$event,$id));
		Database::disconnect();
		header("Location: fr_assignments.php");
	}
} else { // if $_POST NOT filled then pre-populate the form
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM fr_assignments where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$person = $data['assign_per_id'];
	$event = $data['assign_event_id'];
	Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Update Assignment</h3>
			</div>
	
			<form class="form-horizontal" action="fr_assign_update.php?id=<?php echo $id?>" method="post">
		
				<div class="control-group">
					<label class="control-label">Volunteer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM fr_persons ORDER BY lname ASC, fname ASC';
							echo "<select class='form-control' name='person_id' id='person_id'>";
							foreach ($pdo->query($sql) as $row) {
								if($row['id']==$person)
									echo "<option selected value='" . $row['id'] . " '> " . $row['lname'] . ', ' .$row['fname'] . "</option>";
								else
									echo "<option value='" . $row['id'] . " '> " . $row['lname'] . ', ' .$row['fname'] . "</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">Event</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM fr_events ORDER BY event_date ASC, event_time ASC';
							echo "<select class='form-control' name='event_id' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
								if($row['id']==$event) {
									echo "<option selected value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " . trim($row['event_description']) . " (" . trim($row['event_location']) . ") " . "</option>";
								}
								else {
									echo "<option value='" . $row['id'] . " '> " . Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " . trim($row['event_description']) . " (" . trim($row['event_location']) . ") " . "</option>";
								}
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="fr_assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>