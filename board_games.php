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

$sqlQ = "SELECT * from board_gameslocations join players on players.memberID =  board_gameslocations.memberID;";
//echo $sqlQ;
if (!$bglocRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

$sqlQ = "SELECT * from board_gameslocations;";
//echo $sqlQ;
if (!$availbleRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

$sqlQ = "SELECT * from eventlocation;";
//echo $sqlQ;
if (!$evlocRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

//  RETRIEVE button pressed. gameID should have been loaded.
if (isset($_POST['Retrieve'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "SELECT * from board_games WHERE gameID = '".$_POST['gameID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($result->num_rows === 0) {
			$message = 'No upcoming game record exists for that ID.';
		} else {
			//echo 'Loading';
			$gameRS = $result->fetch_assoc();
			//var_dump($memberRS);
			$gameID = $gameRS['gameID'];
			$boardGame = $gameRS['boardGame'];
			$notes = $gameRS['notes'];
			$date = $gameRS['date'];
			$event = $gameRS['event'];
			$eventLocation = $gameRS['eventLocation'];
			$locID = $gameRS['locID'];
			$message = 'Upcoming game retrieved.';
		}		
}

//  UPDATE button pressed. gameID should have been loaded.
if (isset($_POST['Update'])) {
	// Retrieve button pressed. Load up.
		$sqlQ  = "UPDATE board_games SET ";
		$sqlQ .= "boardGame = '".$_POST['boardGame']."', ";
		$sqlQ .= " notes = '".$_POST['notes']."', ";
		$sqlQ .= " `date` = '".$_POST['date']."', ";
		$sqlQ .= " `event` = '".$_POST['event']."', ";
		$sqlQ .= " `eventLocation` = '".$_POST['eventLocation']."', ";
		$sqlQ .= " locID = '".$_POST['locID']."' ";
		$sqlQ .= " WHERE gameID = '".$_POST['gameID']."';";
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

//  DELETE button pressed. gameID should have been loaded.
if (isset($_POST['Delete'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "DELETE from board_games WHERE gameID = '".$_POST['gameID']."';";
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
		if (isset($_POST['gameID']) && strlen($_POST['gameID']) > 0 ) {   // Key must have some data
		// Insert data.
			$sqlQ = "INSERT into board_games (gameID, boardGame, notes,`date`,`event`, eventLocation, locID) values (";
			$sqlQ .= " '".$_POST['gameID']."',";
			$sqlQ .= " '".$_POST['boardGame']."',";
			$sqlQ .= " '".$_POST['notes']."',";
			$sqlQ .= " '".$_POST['date']."',";
			$sqlQ .= " '".$_POST['event']."',";
			$sqlQ .= " '".$_POST['eventLocation']."',";
			$sqlQ .= " '".$_POST['locID']."');";
			//echo $sqlQ;
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
<title>Upcoming Games</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Game</a></h1>
		<form id="form_77994" class="mainclass"  method="post" action="">
					<div class="form_description">
			<h2>Upcoming Games</h2>
			<p>Enter the details for upcoming games</p>
		</div>						
			<ul >
			
		<li id="li_1" >
		<label class="description" for="gameID">game ID </label>
		<div>
			<input id="gameID" name="gameID" class="element text medium" type="text" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 game ID between 1 & 999" value="<?php if (isset($gameID)) { echo $gameID; } ?>"/>
			<label>Enter a unique game ID between 1 - 999</label>
		</div><p class="guidelines" id="gameID"><small>Enter a gameID between 1 & 100</small></p>
		</li>			
		<li id="li_2" >
		<label class="description" for="boardGame">GameName </label>
		<span>
			<select id="boardGame" name="boardGame">
				<?php 
					while ($availble = $availbleRS->fetch_assoc()) {
						$selected = '';
						if (isset($boardGame)) {
							if ($boardGame == $availble['gamename']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$availble['gamename']."' ".$selected." >".$availble['gamename']."</option>";
					} 
				?>
			</select>			
			<!-- <input id="boardGame" name= "boardGame" class="element text" maxlength="255" size="50" title="Name of the game" value="<?php if (isset($boardGame)) { echo $boardGame; } ?>"/> -->
			<label>Name of the game</label>
		</span>
		</li>

		<li id="li_4" >
		<label class="description" for="date">Event Date/Time </label>
		<div>
			<input id="date" name="date" class="element text medium" type="text" title="Event Date" value="<?php if (isset($date)) { echo $date; } ?>"/>
			<label>Event Date/Time</label>
		</div><p class="guidelines" id="date"><small>Date/Time event scheduled</small></p>
		</li>

		<li id="li_5" >
		<label class="description" for="event">Event Name </label>
		<div>
			<input id="event" name="event" class="element text medium" type="text" title="Event Name" value="<?php if (isset($event)) { echo $event; } ?>"/>
			<label>Event Name</label>
		</div><p class="guidelines" id="event"><small>Event Name</small></p>
		</li>

		<li id="li_8" >
		<label class="description" for="eventLocation">Event Location</label>
		<div>
			<select id="eventLocation" name="eventLocation">
				<?php 
					while ($evloc = $evlocRS->fetch_assoc()) {
						$selected = '';
						if (isset($eventLocation)) {
							if ($eventLocation == $evloc['evlocationID']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$evloc['evlocationID']."' ".$selected." >".$evloc['evLocation']."</option>";
					} 
				?>
			</select>
			<!-- <input id="locID" name="locID" class="element text medium" type="text" title="Requires a 3 location ID between 1 & 999" value="<?php if (isset($locID)) { echo $locID; } ?>"/> -->
			<label>Location for Event</label>
		</div><p class="guidelines" id="locID"><small>Location for Event</small></p>
		</li>

		<li id="li_6" >
		<label class="description" for="locID">Who has the game</label>
		<div>
			<select id="locID" name="locID">
				<?php 
					while ($bgloc = $bglocRS->fetch_assoc()) {
						$selected = '';
						if (isset($locID)) {
							if ($locID == $bgloc['locID']) { $selected = ' selected '; }
						} 
						echo "<option value='".$bgloc['locID']."' ".$selected." >".$bgloc['gamename']." is owned by ".$bgloc['firstName'].", ".$bgloc['familyName']."</option>";
					} 
				?>
			</select>
			<!-- <input id="locID" name="locID" class="element text medium" type="text" title="Requires a 3 location ID between 1 & 999" value="<?php if (isset($locID)) { echo $locID; } ?>"/> -->
			<label>Who owns the game</label>
		</div><p class="guidelines" id="locID"><small>locID of owner of game</small></p>
		</li>

		<li id="li_3" >
		<label class="description" for="position">Notes </label>
		<div>
			<input id="notes" name="notes" class="element text medium" type="text" title="Notes on upcoming game" value="<?php if (isset($notes)) { echo $notes; } ?>"/>
			<label>Notes</label>
		</div><p class="guidelines" id="notes"><small>Note on upcoming game</small></p>
		</li>

		<li class="buttons">
		    <input type="hidden" name="form_id" value="77994" />
			<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
			<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
			<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
			<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
			<br><br>
			<button type="button" onclick="location.href='/board_games.php';">Reset Form</button>
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