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

//  Retrieve button pressed. memebrID should have been loaded.
if (isset($_POST['Retrieve'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "SELECT * from players where memberID = '".$_POST['memberID']."';";
		//echo $sqlQ;
		if (!$result = $mysqli->query($sqlQ)) {
				echo "Error: Query failed to execute and here is why: \n";
				echo "Query: " . $sqlQ . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
		}
		if ($result->num_rows === 0) {
			$message = 'MemberID does not exist.';
		} else {
			//echo 'Loading';
			$memberRS = $result->fetch_assoc();
			//var_dump($memberRS);
			$memberID = $memberRS['memberID'];
			$fname = $memberRS['firstName'];
			$sname = $memberRS['familyName'];
			$email = $memberRS['email'];
			$phone = $memberRS['phone'];
			$message = 'Information retrieved.';
		}		
}

//  Retrieve button pressed. memebrID should have been loaded.
if (isset($_POST['Update'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "UPDATE players set firstName = '".$_POST['fname']."', familyName = '".$_POST['sname']."', email = '".$_POST['email']."', phone = '".$_POST['phone']."' where memberID = '".$_POST['memberID']."';";
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

//  Retrieve button pressed. memebrID should have been loaded.
if (isset($_POST['Delete'])) {
	// Retrieve button pressed. Load up.
		$sqlQ = "DELETE from players where memberID = '".$_POST['memberID']."';";
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

//  Retrieve button pressed. memebrID should have been loaded.
if (isset($_POST['Insert'])) {
		if (isset($_POST['memberID']) && strlen($_POST['memberID']) > 0 ) {
		// Insert data.
			$sqlQ = "INSERT into players (memberID, firstName, familyName, email, phone) values ('".$_POST['memberID']."','".$_POST['fname']."','".$_POST['sname']."','".$_POST['email']."','".$_POST['phone']."');";
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

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Personal Details</a></h1>
		<form id="form_77994" class="mainclass"  method="post" action="">
					<div class="form_description">
			<h2>Personal Details</h2>
			<p>Enter your personal details</p>
		</div>						
			<ul >
			
					<li id="li_4" >
		<label class="description" for="memberID">MemberID </label>
		<div>
			<input id="memberID" name="memberID" class="element text medium" type="text" maxlength="255" min="1" max="999" pattern="\d{1,3}" title="Requires a 3 digit Member ID between 1 & 999" value="<?php if (isset($memberID)) { echo $memberID; } ?>"/>
		</div><p class="guidelines" id="email"><small>Enter a Member ID between 1 & 100</small></p>
		</li>		<li id="li_1" >
		<label class="description" for="fname">Name </label>
		<span>
			<input id="fname" name= "fname" class="element text" maxlength="255" size="3" pattern="[A-Z][a-z]{3,255}" title="Requires at least 3 characters with the first letter capiltalised" value="<?php if (isset($fname)) { echo $fname; } ?>"/>
			<label>First</label>
		</span>
		<span>
			<input id="sname" name= "sname" class="element text" maxlength="255" size="14" pattern="[A-Z][a-z]{3,255}" title="Requires at least 3 characters with the first letter capiltalised" value="<?php if (isset($sname)) { echo $sname; } ?>"/>
			<label>Last</label>
		</span> 
		</li>		<li id="li_2" >

		<label class="description" for="email">Email </label>
		<div>
			<input id="email" name="email" class="element text medium" type="text" maxlength="255" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Requires a valid email address" value="<?php if (isset($email)) { echo $email; } ?>"/> 
		</div><p class="guidelines" id="email"><small>Enter a valid email</small></p>
		</li>		<li id="li_3" >
		<label class="description" for="phone">Phone </label>
		<div>
			<input id="phone" name="phone" class="element text medium" type="text" maxlength="255" pattern="[0-9]{2,3} [0-9]{6,9}" title="Requires phonenumber format areacode number - e.g. 021 1234567" value="<?php if (isset($phone)) { echo $phone; } ?>"/> 
		</div><p class="guidelines" id="phone"><small>Enter Phone Number</small></p> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="77994" />

				<input id="Insert" class="button_text" type="submit" name="Insert" value="Insert" />
				<input id="Retrieve" class="button_text" type="submit" name="Retrieve" value="Retrieve" />
				<input id="Update" class="button_text" type="submit" name="Update" value="Update" />
				<input id="Delete" class="button_text" type="submit" name="Delete" value="Delete" />
				<button type="button" onclick="location.href='/index.php';">Reset Form</button>
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