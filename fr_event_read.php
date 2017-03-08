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
$sql = "SELECT * FROM fr_events where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="../cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Shift Details</h3>
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
				
				<div class="form-actions">
					<a class="btn btn-primary" href="fr_assign_create.php?event_id=<?php echo $id; ?>">Volunteer for this shift</a>
					<a class="btn" href="fr_events.php">Back</a>
				</div>
				
			<div class="row">
				<h4>Volunteers Assigned to This Shift</h4>
			</div>
			
			<?php
				$pdo = Database::connect();
				$sql = "SELECT * FROM fr_assignments, fr_persons WHERE assign_per_id = fr_persons.id AND assign_event_id = " . $data['id'] . ' ORDER BY lname ASC, fname ASC';
				$countrows = 0;
				foreach ($pdo->query($sql) as $row) {
					echo $row['lname'] . ', ' . $row['fname'] . ' - ' . $row['mobile'] . '<br />';
					$countrows++;
				}
				if ($countrows == 0) echo 'none.';
			?>
			
			</div> <!-- end div: class="form-horizontal" -->
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
	
</body>
</html>