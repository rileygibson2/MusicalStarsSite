<!DOCTYPE html>
<html>
<head>
	<title>Enrol | Musical Stars</title>
	<link rel="stylesheet" type="text/css" href="css/enrol.css" media='screen and (min-device-width: 980px) and (max-device-width: 5000px)'>
	<link rel="stylesheet" type="text/css" href="css/enrol700px.css" media='screen and (min-device-width: 0px) and (max-device-width: 980px)'/>
	<link rel="stylesheet" type="text/css" href="css/enrol700px.css" media='screen and (min-width: 0px) and (max-width: 980px)'/>
	<link rel="icon" type="image/png" href="assets/favicongreen.png">
</head>
<body>
	<div id="menu">
		<a href="../index.html"><div id="logo"></div></a>
		<a href="enrol.php"><div class="aButton" id="lastButton">Enrol</div></a>
		<a href="teachers.html"><div class="aButton">Team</div></a>
		<a href="shows.html"><div class="aButton">Shows</div></a>
		<a href="upcoming.html"><div class="aButton">Upcoming</div></a>
	</div>

	<div id="container">
		<div id="bubble1Housing"></div>
		<div id="bubble1"></div>
		<div id="bubble2Housing"></div>
		<div id="bubble2"></div>

		<div id="header">Enrol</div>
		<div id="text">Contact Talita on 021-410-015</br>or info@musicalstars.co.nz</div>

		<form id="form" autocomplete="on" action="" method="post" >
  			<input type="text" class="littleInput" id="name" name="name" placeholder="Name" maxlength="20" required>
  			<input type="text" class="littleInput" id="number" name="number" placeholder="Phone Number" maxlength="20" pattern="^[0-9]*$" required>
  			<input type="text" class="littleInput" id="email" name="email" placeholder="Email Address" maxlength="30" required>
  			<input type="text" class="littleInput" id="cName" name="cName" placeholder="Child's Name" maxlength="20" required>
  			<input type="text" class="littleInput" id="DOB" name="DOB" placeholder="Date of Birth" maxlength="20" required>
  			 <select type="text" name="venue" class="littleInput" required>
  			 	<option value="">Preferred Venue</option>
			 	<option value="Karori">Karori</option>
			  	<option value="LowerHutt">Lower Hutt</option>
			  	<option value="Kilbernie">Kilbernie</option>
			</select>
  			<input type="textarea" class="littleInput" id="message" name="message" placeholder="Anything else you'd like to tell us" maxlength="20">
  			<input type="submit" value="Submit" id="submit">
		</form>
	</div>

	<?php
		// define variables and set to empty values
		$name = $email = $gender = $comment = $website = "";
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = test_input($_POST["name"]);
		 	$number = test_input($_POST["number"]);
		  	$email = test_input($_POST["email"]);
		  	$cName = test_input($_POST["cName"]);
		  	$DOB = test_input($_POST["DOB"]);
			$venue = test_input($_POST["venue"]);
		  	$message = test_input($_POST["message"]);
			
			$to = "riley2.gibson2@gmail.com";
			$subject = "New Message From Online Form";
			$toSend = "Name: ".$name."\n"."Number: ".$number."\n"."Email: ".$email."\n"."Childs Name: ".$cName."\n"."Date Of Birth: ".$DOB."\n"."Venue: ".$venue."\n"."Message: ".$message;
			$header = 'From: contact-form@musicalstars.co.nz';
			
			if (mail($to, $subject, $toSend, $header)==FALSE) {
				echo "<script>document.getElementById('form').innerHTML = '<p id='response'>Something went wrong..........</p>';</script>";
			}
			else {
				echo "<script>document.getElementById('form').innerHTML = '<p id=response>Thank you!</br>We will get back to you very soon!</p>';</script>";
			}
		}

		function test_input($data) {
		  	$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}
	?>
</body>
</html>