<?php
/* ---------------------------------------------------------------------------
 * filename    : fr_events.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program displays a list of events (table: fr_events)
 * ---------------------------------------------------------------------------
 */
session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: pink !important";>
    <div class="container">
	
		<div class="row">
			<h3>Events</h3>
		</div>
		
		<div class="row">
			<p>
				<a href="fr_event_create.php" class="btn btn-primary">Add New Event</a>
				<a href="logout.php" class="btn btn-warning">Logout</a> &nbsp;&nbsp;&nbsp;
				<a href="fr_persons.php">Volunteers</a> &nbsp;
				<a href="fr_events.php">Events</a> &nbsp;
				<a href="fr_assignments.php">Assignments</a>
			</p>
			
			<table class="table table-striped table-bordered" style="background-color: lightgrey !important";>
				<thead>
					<tr>
						<th>Date</th>
						<th>Time</th>
						<th>Location</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						include '../database/database.php';
						include 'functions.php';
						$pdo = Database::connect();
						$sql = 'SELECT * FROM fr_events ORDER BY event_date ASC, event_time ASC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. Functions::dayMonthDate($row['event_date']) . '</td>';
							echo '<td>'. Functions::timeAmPm($row['event_time']) . '</td>';
							echo '<td>'. $row['event_location'] . '</td>';
							echo '<td>'. $row['event_description'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="fr_event_read.php?id='.$row['id'].'">Details</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="fr_event_update.php?id='.$row['id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="fr_event_delete.php?id='.$row['id'].'">Delete</a>';
							if($_SESSION["fr_person_id"] == $row['person_in_charge']) echo " &nbsp;&nbsp;Me!";
							echo '</td>';
							echo '</tr>';
						}
						Database::disconnect();
					?>
				</tbody>
			</table>
    	</div>
	
    </div> <!-- end div: class="container" -->
	
  </body>
  
</html>