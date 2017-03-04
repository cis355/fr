<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_assignments.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program displays a list of assignments (table: fr_assignments)
 * definition  : An assignment is a task for a volunteer at an event. 
 * ---------------------------------------------------------------------------
 */

session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
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

<body>
    <div class="container">
	
		<div class="row">
			<h3>Assignments</h3>
		</div>
		
		<div class="row">
			<p>
				<a href="fr_assign_create.php" class="btn btn-primary">Add New Assignment</a>
				<a href="logout.php" class="btn btn-warning">Logout</a> &nbsp;&nbsp;&nbsp;
				<a href="fr_persons.php">Volunteers</a> &nbsp;
				<a href="fr_events.php">Events</a> &nbsp;
				<a href="fr_assignments.php">Assignments</a>
			</p>
			
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Date</th>
						<th>Time</th>
						<th>Location</th>
						<th>Event</th>
						<th>Volunteer</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					include '../database/database.php';
					include 'functions.php';
					$pdo = Database::connect();

					$sql = 'SELECT * FROM fr_assignments 
					LEFT JOIN fr_persons ON fr_persons.id = fr_assignments.assign_per_id 
					LEFT JOIN fr_events ON fr_events.id = fr_assignments.assign_event_id
					ORDER BY event_date ASC, event_time ASC, lname ASC, lname ASC;';

					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. Functions::dayMonthDate($row['event_date']) . '</td>';
						echo '<td>'. Functions::timeAmPm($row['event_time']) . '</td>';
						echo '<td>'. $row['event_location'] . '</td>';
						echo '<td>'. $row['event_description'] . '</td>';
						echo '<td>'. $row['lname'] . ', ' . $row['fname'] . '</td>';
						echo '<td width=250>';
						# use $row[0] because there are 3 fields called "id"
						echo '<a class="btn" href="fr_assign_read.php?id='.$row[0].'">Details</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="fr_assign_update.php?id='.$row[0].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="fr_assign_delete.php?id='.$row[0].'">Delete</a>';
						if($_SESSION["fr_person_id"] == $row['assign_per_id']) echo " &nbsp;&nbsp;Me!";
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