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

$sqlQ = "SELECT * from players;";
//echo $sqlQ;
if (!$playerRS = $mysqli->query($sqlQ)) {
		echo "Error: Query failed to execute and here is why: \n";
		echo "Query: " . $sqlQ . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
}

//  Retrieve button pressed. memebrID should have been loaded.
if (isset($_POST['Retrieve'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "SELECT * from board_gameslocations where locID = '".$_POST['locID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($result->num_rows === 0) {
			$message = 'No location record exists for that game.';
		} else {
			//echo 'Loading';
			$memberRS = $result->fetch_assoc();
			//var_dump($memberRS);
			$gamename = $memberRS['gamename'];
			$memberID = $memberRS['memberID'];
			$locID = $memberRS['locID'];
			$message = 'Player with game retrieved.';
		}		
}

//  UPDATE button pressed. locID should have been loaded.
if (isset($_POST['Update'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "UPDATE board_gameslocations set memberID = '".$_POST['memberID']."', gamename = '".$_POST['gamename']."' where locID = '".$_POST['locID']."';";
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

//  DELETE button pressed. locID should have been loaded.
if (isset($_POST['Delete'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "DELETE from board_gameslocations where locID = '".$_POST['locID']."';";
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

//  INSERT button pressed. memebrID should have been loaded.
if (isset($_POST['Insert'])) {
		if (isset($_POST['locID']) && strlen($_POST['locID']) > 0 ) {
		// Insert data.
			$sqlQ = "INSERT into board_gameslocations (locID, memberID, gamename) values ('".$_POST['locID']."','".$_POST['memberID']."','".$_POST['gamename']."');";
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
<title>Game Owners</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Game Owners</a></h1>
		<form id="form_77994" class="mainclass"  method="post" action="">
					<div class="form_description">
			<h2>Game location/Owner Details</h2>
			<p>Enter the Member and associated game</p>
		</div>						
			<ul >

		<li id="li_1" >
		<label class="description" for="locID">Location ID</label>
		<div>
			<input id="locID" name="locID" class="element text medium" type="text" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 location ID between 1 & 999" value="<?php if (isset($locID)) { echo $locID; } ?>"/>
			<label>Enter a unique Location ID between 1 - 999</label>
		</div><p class="guidelines" id="locID"><small>Enter a Location ID between 1 & 100</small></p>
		</li>

		<li id="li_2" >
		<label class="description" for="memberID">Member who owns Game</label>
		<div>
			<select id="memberID" name="memberID">
				<?php 
					while ($player = $playerRS->fetch_assoc()) {
						echo "<option value='".$player['memberID']."'>".$player['familyName']." ".$player['firstName']."</option>";
					} 
				?>
			</select>
			<label>Select from list</label>
		</div><p class="guidelines" id="memberID"><small>Select Member from list</small></p>
		</li>		
		
		<li id="li_3" >
		<label class="description" for="gamename">Name of game</label>
		<div>
			<input id="gamename" name="gamename" class="element text medium" type="text" maxlength="255" title="Name of Game" value="<?php if (isset($gamename)) { echo $gamename; } ?>"/>
		</div><p class="guidelines" id="gamename"><small>Name of Game</small></p> 
		</li>



		<li class="buttons">
		    <input type="hidden" name="form_id" value="77994" />
			<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
			<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
			<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
			<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
			<br><br>
			<button type="button" onclick="location.href='/board_gameslocations.php';">Reset Form</button>
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