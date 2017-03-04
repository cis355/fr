<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_assign_delete.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program deletes one assignment's details (table: fr_assignments)
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

if ( !empty($_POST)) { // if user clicks "yes" (sure to delete), delete record

	$id = $_POST['id'];
	
	// delete data
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "DELETE FROM fr_assignments  WHERE id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	Database::disconnect();
	header("Location: fr_assignments.php");
} 
else { // otherwise, pre-populate fields to show data to be deleted

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	# get assignment details
	$sql = "SELECT * FROM fr_assignments where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	# get volunteer details
	$sql = "SELECT * FROM fr_persons where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($data['assign_per_id']));
	$perdata = $q->fetch(PDO::FETCH_ASSOC);
	
	# get event details
	$sql = "SELECT * FROM fr_events where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($data['assign_event_id']));
	$eventdata = $q->fetch(PDO::FETCH_ASSOC);
	
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
				<h3>Delete Assignment</h3>
			</div>
			
			<form class="form-horizontal" action="fr_assign_delete.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure you want to delete ?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Yes</button>
					<a class="btn" href="fr_assignments.php">No</a>
				</div>
			</form>
			
			<!-- Display same information as in file: fr_assign_read.php -->
			
			<div class="form-horizontal" >
			
				<div class="control-group">
					<label class="control-label">Volunteer</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $perdata['lname'] . ', ' . $perdata['fname'] ;?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Event</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo trim($eventdata['event_description']) . " (" . trim($eventdata['event_location']) . ") ";?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Date, Time</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo Functions::dayMonthDate($eventdata['event_date']) . ", " . Functions::timeAmPm($eventdata['event_time']);?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Comments/Task</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['assign_comments'];?>
						</label>
					</div>
				</div>
			
			</div> <!-- end div: class="form-horizontal" -->
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
	
</body>
</html>