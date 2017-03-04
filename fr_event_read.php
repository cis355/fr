<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_event_read.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program displays one event's details (table: fr_events)
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

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# get event details
$sql = "SELECT * FROM fr_events where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

# get person details
$sql = "SELECT * FROM fr_persons where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($data['person_in_charge']));
$perdata = $q->fetch(PDO::FETCH_ASSOC);

Database::disconnect();
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
				<h3>Event Details</h3>
			</div>
			
			<div class="form-horizontal" >
			
				<div class="control-group">
					<label class="control-label">Date</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo Functions::dayMonthDate($data['event_date']);?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Time</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo Functions::timeAmPm($data['event_time']);?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Location</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['event_location'];?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Description</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['event_description'];?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Person in Charge</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $perdata['lname'] . ', ' . $perdata['fname'] ;?>
						</label>
					</div>
				</div>
				
				<div class="form-actions">
					<a class="btn" href="fr_events.php">Back</a>
				</div>
			
			</div> <!-- end div: class="form-horizontal" -->
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
	
</body>
</html>