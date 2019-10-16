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

$sqlQ = "SELECT * from board_games join eventlocation on evlocationID = eventLocation;";
//echo $sqlQ;
if (!$eventRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

//  RETRIEVE button pressed. 
if (isset($_POST['Retrieve'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "SELECT * from board_scoretracking where trkID = '".$_POST['trkID']."';";
		//echo $sqlQ;
		if (!$scoreRS = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($scoreRS->num_rows === 0) {
			$message = 'No tracking record exists.';
		} else {
			//echo 'Loading';
			$score = $scoreRS->fetch_assoc();
			//var_dump($memberRS);
			$trkID = $score['trkID'];
			$eventID = $score['eventID'];
			$firstPlace = $score['firstPlace'];
			$secondPlace = $score['secondPlace'];
			$thirdPlace = $score['thirdPlace'];
			$message = 'Information retrieved.';
		}		
}

//  UPDATE button pressed. 
if (isset($_POST['Update'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "UPDATE board_scoretracking set eventID = '".$_POST['eventID']."', firstPlace = '".$_POST['firstPlace']."', secondPlace = '".$_POST['secondPlace']."', thirdPlace = '".$_POST['thirdPlace']."' where trkID = '".$_POST['trkID']."';";
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
		$sqlQ = "DELETE from board_scoretracking where trkID = '".$_POST['trkID']."';";
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

//  RETRIEVE button pressed. 
if (isset($_POST['Insert'])) {
		if (isset($_POST['trkID']) && strlen($_POST['trkID']) > 0 ) {
		// Insert data.
			$sqlQ = "INSERT into board_scoretracking (trkID, eventID, firstPlace, secondPlace, thirdPlace) values ('".$_POST['trkID']."','".$_POST['eventID']."','".$_POST['firstPlace']."','".$_POST['secondPlace']."','".$_POST['thirdPlace']."');";
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
<title>Personal Details</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Score Board</a></h1>
		<form id="form_77994" class="mainclass"  method="post" action="">
					<div class="form_description">
			<h2>Score Board</h2>
			<p>Score Board</p>
		</div>						
			<ul >
			
		<li id="li_1" >
		<label class="description" for="trkID">Tracking ID</label>
		<div>
			<input id="trkID" name="trkID" class="element text medium" type="text" size="5" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 location ID between 1 & 999" value="<?php if (isset($trkID)) { echo $trkID; } ?>"/>
			<label>Enter a unique Tracking ID between 1 - 999</label>
		</div><p class="guidelines" id="trkID"><small>Enter a Tracking ID between 1 & 100</small></p>
		</li>

		<li id="li_2" >
		<label class="description" for="eventID">Event</label>
		<div>
			<select id="eventID" name="eventID">
				<?php 
					while ($event = $eventRS->fetch_assoc()) {
						$selected = '';
						if (isset($eventID)) {
							if ($eventID == $event['gameID']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$event['gameID']."' ".$selected." >".$event['event'].", ".$event['date'].", ".$event['evLocation']."</option>";
					} 
				?>
			</select>
			<label>Select Event</label>
		</div><p class="guidelines" id="eventID"><small>Event played</small></p>
		</li>	

		<h3>Placings.</h3>

		<li id="li_3" >
		<label class="description" for="firstPlace">First Place Winner</label>
		<div>
			<select id="firstPlace" name="firstPlace">
				<?php
					echo "<option value='' ></option>"; 
					$sqlQ = "SELECT * from players;";
					//echo $sqlQ;
					if (!$playerRS = $mysqli->query($sqlQ)) {
						echo "Error: Query failed to execute and here is why: \n";
						echo "Query: " . $sqlQ . "\n";
						echo "Errno: " . $mysqli->errno . "\n";
						echo "Error: " . $mysqli->error . "\n";
						exit;
					}
					while ($player = $playerRS->fetch_assoc()) {
						$selected = '';
						if (isset($firstPlace)) {
							if ($firstPlace == $player['memberID']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$player['memberID']."' ".$selected." >".$player['familyName']." ".$player['firstName']."</option>";
					} 
					unset($player);
					unset($playerRS);
				?>
			</select>
			<label>Select from list</label>
		</div><p class="guidelines" id="secondPlace"><small>Select Member from list</small></p>
		</li>	

		<li id="li_4" >
		<label class="description" for="secondPlace">Second Place Winner</label>
		<div>
			<select id="secondPlace" name="secondPlace">
				<?php 
					echo "<option value='' ></option>";
					$sqlQ = "SELECT * from players;";
					//echo $sqlQ;
					if (!$playerRS = $mysqli->query($sqlQ)) {
						echo "Error: Query failed to execute and here is why: \n";
						echo "Query: " . $sqlQ . "\n";
						echo "Errno: " . $mysqli->errno . "\n";
						echo "Error: " . $mysqli->error . "\n";
						exit;
					}
					while ($player = $playerRS->fetch_assoc()) {
						$selected = '';
						if (isset($secondPlace)) {
							if ($secondPlace == $player['memberID']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$player['memberID']."' ".$selected." >".$player['familyName']." ".$player['firstName']."</option>";
					} 
				?>
			</select>
			<label>Select from list</label>
		</div><p class="guidelines" id="thirdPlace"><small>Select Member from list</small></p>
		</li>			

		<li id="li_5" >
		<label class="description" for="thirdPlace">Third Place Winner</label>
		<div>
			<select id="thirdPlace" name="thirdPlace">
				<?php 
					echo "<option value='' ></option>";
					$sqlQ = "SELECT * from players;";
					//echo $sqlQ;
					if (!$playerRS = $mysqli->query($sqlQ)) {
						echo "Error: Query failed to execute and here is why: \n";
						echo "Query: " . $sqlQ . "\n";
						echo "Errno: " . $mysqli->errno . "\n";
						echo "Error: " . $mysqli->error . "\n";
						exit;
					}
					while ($player = $playerRS->fetch_assoc()) {
						$selected = '';
						if (isset($thirdPlace)) {
							echo 'GG: '.$thirdPlace.'  '.$player['memberID'];
							if ($thirdPlace == $player['memberID']) { $selected = ' selected '; }
						} 						
						echo "<option value='".$player['memberID']."' ".$selected." >".$player['familyName']." ".$player['firstName']."</option>";
					} 
				?>
			</select>
			<label>Select from list</label>
		</div><p class="guidelines" id="secondPlace"><small>Select Member from list</small></p>
		</li>

		<li class="buttons">
		    <input type="hidden" name="form_id" value="77994" />

			<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
			<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
			<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
			<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
			<br><br>
			<button type="button" onclick="location.href='/board_scoretracking.php';">Reset Form</button>
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