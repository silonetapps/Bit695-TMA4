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

//  Retrieve button pressed.
if (isset($_POST['Retrieve'])) {
	// RETRIEVE button pressed.
		$sqlQ = "SELECT * from eventLocation WHERE evlocationID = '".$_POST['evlocationID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($result->num_rows === 0) {
			$message = 'Event Location ID does not exist.';
		} else {
			//echo 'Loading';
			$evRS = $result->fetch_assoc();
			//var_dump($evRS);
			$evlocationID = $evRS['evlocationID'];
			$evLocation = $evRS['evLocation'];
			$message = 'Information retrieved.';
		}		
}

//  Retrieve button pressed.
if (isset($_POST['Update'])) {
	// UPDATE button pressed. Load up.
		$sqlQ  = "UPDATE eventLocation SET ";
		$sqlQ .= " evLocation = '".$_POST['evLocation']."' ";
		$sqlQ .= " WHERE evlocationID = '".$_POST['evlocationID']."';";
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
		$sqlQ = "DELETE from eventLocation where evlocationID = '".$_POST['evlocationID']."';";
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
		if (isset($_POST['evlocationID']) && strlen($_POST['evlocationID']) > 0 ) {
		// Insert data.
			$sqlQ  = "INSERT into eventLocation (";
			$sqlQ .= "evlocationID, evLocation) values (";
			$sqlQ .= " '".$_POST['evlocationID']."', ";
			$sqlQ .= " '".$_POST['evLocation']."')";
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

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

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
		<label class="description" for="evlocationID">Event Location ID </label>
		<div>
			<input id="evlocationID" name="evlocationID" class="element text medium" type="text" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 digit event ID between 1 & 999" value="<?php if (isset($evlocationID)) { echo $evlocationID; } ?>"/>
		</div><p class="guidelines" id="evlocationID"><small>Enter a event ID between 1 & 100</small></p>
		</li>

		<li id="li_3" >
		<label class="description" for="evLocation">Address</label>
		<div>
			<input id="evLocation" name="evLocation" class="element text medium" type="text" maxlength="255" title="Event Location" value="<?php if (isset($evLocation)) { echo $evLocation; } ?>"/> 
		</div><p class="guidelines" id="evLocation"><small>Address for Event</small></p>
		</li>		

		<li class="buttons">
			    <input type="hidden" name="form_id" value="77994" />
				<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
				<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
				<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
				<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
				<br><br>
				<button type="button" onclick="location.href='/eventLocation.php';">Reset Form</button>
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