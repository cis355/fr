<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_assign_create.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program adds/inserts a new assignment (table: fr_assignments)
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

if ( !empty($_POST)) {

	// initialize user input validation variables
	$personError = null;
	$eventError = null;
	$commentsError = null;
	
	// initialize $_POST variables
	$person = $_POST['person'];    // same as HTML name= attribute in put box
	$event = $_POST['event'];
	$comments = $_POST['comments'];	
	
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
	if (empty($comments)) {
		$commentsError = 'Please enter Comments or task to be performed';
		$valid = false;
	}
		
	// insert data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO fr_assignments 
			(assign_per_id,assign_event_id,assign_comments) 
			values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($person,$event,$comments));
		Database::disconnect();
		header("Location: fr_assignments.php");
	}
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
				<h3>Assign a Volunteer to an Event</h3>
			</div>
	
			<form class="form-horizontal" action="fr_assign_create.php" method="post">
		
				<div class="control-group">
					<label class="control-label">Volunteer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM fr_persons ORDER BY lname ASC, fname ASC';
							echo "<select class='form-control' name='person' id='person_id'>";
							foreach ($pdo->query($sql) as $row) {
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
							echo "<select class='form-control' name='event' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
								echo "<option value='" . $row['id'] . " '> " . 
									Functions::dayMonthDate($row['event_date']) . " (" . Functions::timeAmPm($row['event_time']) . ") - " .
									trim($row['event_description']) . " (" . 
									trim($row['event_location']) . ") " .
									"</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
								  
				<div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					<label class="control-label">Comments/Task</label>
					<div class="controls">
						<input name="comments" type="text"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>">
						<?php if (!empty($commentsError)): ?>
							<span class="help-inline"><?php echo $commentsError;?></span>
						<?php endif; ?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
						<a class="btn" href="fr_assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>