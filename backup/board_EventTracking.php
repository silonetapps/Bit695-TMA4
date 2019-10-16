<?php

// Connect to mysql DB
$mysqli = new mysqli('127.0.0.1', 'root', 'root', 'bit695');
if ($mysqli->connect_errno) {
	echo "Sorry, DB connection failure.";
	echo "Error: Failed to make a MySQL connection, here is why: \n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	echo "Error: " . $mysqli->connect_error . "\n";
	exit;
}

// Get lookup data
$sqlQ = "SELECT * from board_gamesassigned;";
//echo $sqlQ;
if (!$bgassignRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}
	
$sqlQ = "SELECT * from board_gameslocations;";
//echo $sqlQ;
if (!$bglocRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

$sqlQ = "SELECT * from board_scoretracking;";
//echo $sqlQ;
if (!$bgscoreRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}


//  Retrieve button pressed.
if (isset($_POST['Retrieve'])) {
	// RETRIEVE button pressed.
		$sqlQ = "SELECT * from board_eventtracking WHERE eventID = '".$_POST['eventID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($result->num_rows === 0) {
			$message = 'eventID does not exist.';
		} else {
			//echo 'Loading';
			$evRS = $result->fetch_assoc();
			//var_dump($evRS);
			$eventID = $evRS['eventID'];
			$eventDateTime = $evRS['eventDateTime'];
			$eventLocation = $evRS['eventLocation'];
			$gamesID = $evRS['gamesID'];
			$boardGamesAssigned_assignID = $evRS['boardGamesAssigned_assignID'];
			$boardGamesLocations_locID = $evRS['boardGamesLocations_locID'];
			$message = 'Information retrieved.';
		}		
}

//  Retrieve button pressed.
if (isset($_POST['Update'])) {
	// UPDATE button pressed. Load up.
		$sqlQ  = "UPDATE board_eventtracking SET ";
		$sqlQ .= " eventDateTime = '".$_POST['eventDateTime']."', ";
		$sqlQ .= " eventLocation = '".$_POST['eventLocation']."', ";
		$sqlQ .= " gamesID = '".$_POST['gamesID']."', ";
		$sqlQ .= " boardGamesAssigned_assignID = '".$_POST['boardGamesAssigned_assignID']."', ";
		$sqlQ .= " boardGamesLocations_locID = '".$_POST['boardGamesLocations_locID']."' ";
		$sqlQ .= " WHERE eventID = '".$_POST['eventID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		} else {
			$message = 'Record Updated.';
		}
}

//  DELETE button pressed. 
if (isset($_POST['Delete'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "DELETE from board_eventtracking where eventID = '".$_POST['eventID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		} else {
			$message = 'Record Deleted.';
		}
}

//  INSERT button pressed.
if (isset($_POST['Insert'])) {
		if (isset($_POST['eventID']) && strlen($_POST['eventID']) > 0 ) {
		// Insert data.
			$sqlQ  = "INSERT into board_eventtracking (";
			$sqlQ .= "eventID, eventDateTime, eventLocation, gamesID, boardGamesAssigned_assignID, boardGamesLocations_locID) values (";
			$sqlQ .= " '".$_POST['eventID']."', ";
			$sqlQ .= " '".$_POST['eventDateTime']."', ";			
			$sqlQ .= " '".$_POST['eventLocation']."', ";
			$sqlQ .= " '".$_POST['gamesID']."', ";
			$sqlQ .= " '".$_POST['boardGamesAssigned_assignID']."', ";
			$sqlQ .= " '".$_POST['boardGamesLocations_locID']."')";
			if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
			} else {
				$message = 'Record added.';
			}
	} else {
			$message = 'No data loaded.';		
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Event Tracking</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>

<script>
function updlocid() {
	var x = document.getElementById("boardGamesAssigned_assignID");
	alert(x.value);
	document.getElementById("boardGamesLocations_locID").val = document.getElementById("boardGamesAssigned_assignID");
}
</script>

<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Event Tracking</a></h1>
		<form id="form_77994" class="mainclass"  method="post" action="">
					<div class="form_description">
			<h2>Event Tracking</h2>
			<p>Event Details</p>
		</div>						
			<ul >
			
		<li id="li_1" >
		<label class="description" for="eventID">eventID </label>
		<div>
			<input id="eventID" name="eventID" class="element text medium" type="text" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 digit event ID between 1 & 999" value="<?php if (isset($eventID)) { echo $eventID; } ?>"/>
		</div><p class="guidelines" id="email"><small>Enter a event ID between 1 & 100</small></p>
		</li>		
		
		<li id="li_2" >
		<label class="description" for="eventDateTime">Event Date/Time </label>
		<span>
			<input id="eventDateTime" name= "eventDateTime" class="element text" maxlength="255" size="40" title="Requires date/time of event" value="<?php if (isset($eventDateTime)) { echo $eventDateTime; } ?>"/>
			<label>First</label>
		</span>
		</li>		

		<li id="li_3" >
		<label class="description" for="eventLocation">Event Location </label>
		<div>
			<input id="eventLocation" name="eventLocation" class="element text medium" type="text" maxlength="255" title="Event Location" value="<?php if (isset($eventLocation)) { echo $eventLocation; } ?>"/> 
		</div><p class="guidelines" id="email"><small>Location for Event</small></p>
		</li>		
		
		<li id="li_6" >
		<label class="description" for="gamesID">Game </label>
		<div>
			<select id="gamesID" name="gamesID">
				<?php 
					while ($bgloc = $bglocRS->fetch_assoc()) {
						echo "<option value='".$bgloc['locID']."'>".$bgloc['gamename']."</option>";
					} 
				?>
			</select>
		</div><p class="guidelines" id="gamesID"><small>Selected Game</small></p> 
		</li>

		<li id="li_5" >
		<label class="description" for="boardGamesAssigned_assignID">Game Assigned ID </label>
		<div>
			<select id="boardGamesAssigned_assignID" name="boardGamesAssigned_assignID">
				<?php 
					while ($bgassign = $bgassignRS->fetch_assoc()) {
						echo "<option value='".$bgassign->fields['assignID']."'>".$bgassign->fields['assignID']."</option>";
					} 
				?>
			</select>
		</div><p class="guidelines" id="boardGamesAssigned_assignID"><small>Selected Game</small></p> 
		</li>

		<li id="li_7" >
		<label class="description" for="boardGamesLocations_locID">Game Location</label>
		<div>
			<input id="boardGamesLocations_locID" name="boardGamesLocations_locID" class="element text medium" type="text" maxlength="255" title="Selected Game" value="<?php if (isset($boardGamesLocations_locID)) { echo $boardGamesLocations_locID; } ?>"/>
		</div><p class="guidelines" id="boardGamesLocations_locID"><small>Selected Game</small></p> 
		</li>



		<li class="buttons">
			    <input type="hidden" name="form_id" value="77994" />
				<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
				<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
				<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
				<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
				<button type="button" onclick="location.href='/index.php';">Reset Form</button>
				<button type="button" onclick="location.href='/';">Main Menu</button>
		</li>
			</ul>
		</form>	
		<?php 
		if (isset($message)) {
			echo "<div>";
			echo "<p>".$message."</p>";
			echo "</div>";
		} else {
			echo "<p></p>";
		}
		?>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>

<?php

//phpinfo();

?>