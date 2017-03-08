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
$sessionid = $_SESSION['fr_person_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="../cardinal_logo.png" type="image/png" />
</head>

<body style="background-color: pink !important";>
    <div class="container">
	
		<div class="row">
			<h3>Shifts</h3>
		</div>
		
		<div class="row">
			<p>Each shift is 4 hours.</p>
			<p>
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_event_create.php" class="btn btn-primary">Add Shift</a>';
				?>
				<a href="logout.php" class="btn btn-warning">Logout</a> &nbsp;&nbsp;&nbsp;
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_persons.php">Volunteers</a> &nbsp;';
				?>
				<a href="fr_events.php">Shifts</a> &nbsp;
				<?php if($_SESSION['fr_person_title']=='Administrator')
					echo '<a href="fr_assignments.php">AllShifts</a>&nbsp;';
				?>
				<a href="fr_assignments.php?id=<?php echo $sessionid; ?>">MyShifts</a>&nbsp;
			</p>
			
			<table class="table table-striped table-bordered" style="background-color: lightgrey !important">
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
						$sql = 'SELECT `fr_events`.*, SUM(case when assign_per_id ='. $_SESSION['fr_person_id'] .' then 1 else 0 end) AS sumAssigns, COUNT(`fr_assignments`.assign_event_id) AS countAssigns FROM `fr_events` LEFT OUTER JOIN `fr_assignments` ON (`fr_events`.id=`fr_assignments`.assign_event_id) GROUP BY `fr_events`.id ORDER BY `fr_events`.event_date ASC, `fr_events`.event_time ASC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. Functions::dayMonthDate($row['event_date']) . '</td>';
							echo '<td>'. Functions::timeAmPm($row['event_time']) . '</td>';
							echo '<td>'. $row['event_location'] . '</td>';
							if ($row['countAssigns']==0)
								echo '<td>'. $row['event_description'] . ' - UNSTAFFED </td>';
							else
								echo '<td>'. $row['event_description'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="fr_event_read.php?id='.$row['id'].'">Details</a> &nbsp;';
							if ($_SESSION['fr_person_title']=='Volunteer' )
								echo '<a class="btn btn-primary" href="fr_event_read.php?id='.$row['id'].'">Volunteer</a> &nbsp;';
							if ($_SESSION['fr_person_title']=='Administrator' )
								echo '<a class="btn btn-success" href="fr_event_update.php?id='.$row['id'].'">Update</a>&nbsp;';
							if ($_SESSION['fr_person_title']=='Administrator' 
								&& $row['countAssigns']==0)
								echo '<a class="btn btn-danger" href="fr_event_delete.php?id='.$row['id'].'">Delete</a>';
							if($row['sumAssigns']==1) 
								echo " &nbsp;&nbsp;Me";
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