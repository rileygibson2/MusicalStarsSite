<!DOCTYPE html>
<html>
<head>
	<title>Record Test</title>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<link rel="stylesheet" type="text/css" href="css/dev.css">
</head>
<body onload="viewcounter()">
	<!--<div id="loginContainer">
		<p id="titletext">Admin</p>
		<input type="password" id="nPassword" name="password" onchange="login()"></input>
	</div>-->

	<div id="container">
		<div id="title">Site Stats</div>
		<div id="accountIcon" onmousedown="logout()"></div>

		<div id="todayContainer">
			<?php
				$fr = fopen("logs/home.txt", "r");
				$date = date('d-m-Y');
				while (($line=fgets($fr))!==false) {
					$rDate = substr($line, 0, 10);
					if ($date==$rDate) {
						echo fgets($fr)." visits today";
						break;
					}
				}
				fclose($fr);
			?>
		</div>

		<?php
			$c = true;
			$fr = fopen("logs/home.txt", "r");
			$count = 0;
			$curM = "";

			echo '<div id="boxContainer">';
			while (($line=fgets($fr))!==false) {
				if ($line!="\n") {
					//Date line
					if ($c==true) {
						//Set values
						$day = date('jS', strtotime($line));  
						$dayName = date('l', strtotime($line));
						$month = date('F', strtotime($line));

						//Assess Date
						if ($curM == "") {
							$curM = $month;
							echo '</div><div class="monthHeader" style="margin-top:2vh;">'.$month.'</div><div id="boxContainer">';
						}
						else if ($curM != $month) {
							$curM = $month;
							echo '</div><div class="monthHeader">'.$month.'</div><div id="boxContainer">';
						}

						//Set Metadata
						echo '<div id="mH'.$count.'" class="metaHidden">'.$line.'</div>';

						//Finally
						echo '<div class="box" onmousedown="expand('.$count.')">';
						echo ('<div id="date">'.$dayName.'</br>'.$day.'</div>');
						$c = false;
						$count++;
					}
					//Value line
					else {
						echo ('<div id="value">'.$line.' views</div>');
						echo '</div>';
						$c = true;
					}
				}
			}
			echo '</div>';
			fclose($fr);
		?>

	</div>

	<div id="expandedBox">
		<div id="closeButton" onmousedown="dexpand()"></div>
		<div id="expandTitle">Page Breakdown</div>
		<div id="expandSubTitle"></div>

		<div id="bar0" class="bar" onmouseover="barFade(0)" onmouseout="barUnfade(0)">
			<div id="bar0Nu" class="barNu"></div>
		</div>
		<div id="bar1" class="bar" onmouseover="barFade(1)" onmouseout="barUnfade(1)">
			<div id="bar1Nu" class="barNu"></div>
		</div>
		<div id="bar2" class="bar" onmouseover="barFade(2)" onmouseout="barUnfade(2)">
			<div id="bar2Nu" class="barNu"></div>
		</div>
		<div id="bar3" class="bar" onmouseover="barFade(3)" onmouseout="barUnfade(3)">
			<div id="bar3Nu" class="barNu"></div>
		</div>
		<div id="bar4" class="bar" onmouseover="barFade(4)" onmouseout="barUnfade(4)">
			<div id="bar4Nu" class="barNu"></div>
		</div>

		<div id="bar0T" class="barTitle">Home</div>
		<div id="bar1T" class="barTitle">Coming</div>
		<div id="bar2T" class="barTitle">Shows</div>
		<div id="bar3T" class="barTitle">Team</div>
		<div id="bar4T" class="barTitle">Enrol</div>
	</div>

</body>
<script type="text/javascript">
	
	function viewcounter() {
		for (var i = 0; i < 5; i++) {
			var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("POST", "viewcounter.php");
		    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		    xmlhttp.send("log="+pages[i]);
		}
	}




	function login() {
		var password = "mstarsadmm";
		var nPassword = document.getElementById("nPassword").value;

		if (nPassword == password) {
			document.getElementById("nPassword").setAttribute("style", "animation-name: disappear; animation-delay: 0s;");
			document.getElementById("titletext").setAttribute("style", "animation-name: moveDown;");
			document.getElementById("loginContainer").setAttribute("style", "animation-name: login;");
		}
		else {
			document.getElementById("nPassword").setAttribute("style", "animation-name: nullani; animation-delay: 0s;");
			setTimeout(function(){document.getElementById("nPassword").setAttribute("style", "animation-name: wrongpassword; animation-delay: 0s;");}, 0);
		}
	}

	function logout() {
		document.getElementById("loginContainer").setAttribute("style", "animation-name: logout;");
		document.getElementById("titletext").setAttribute("style", "animation-name: moveUp;");
		document.getElementById("nPassword").setAttribute("style", "animation-name: appear;");
		
	}

	var values = [20, 20, 20, 20, 20];
	var pages = ["home", "upcoming", "shows", "team", "enrol"];

	function refreshData(date, log, i){
      	var xmlhttp = new XMLHttpRequest();
	    xmlhttp.open("POST", "get.php");
	    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    xmlhttp.send("date="+date+"&log="+log);
	    xmlhttp.onreadystatechange = function() {
	    	if (this.readyState === 4 && this.status === 200) {
	    		var response = this.responseText.replace(/\D/g,'');

	    		if (response>95) values[i] = 95;
	        	else values[i] = response;

	        	document.getElementById("bar"+i+"Nu").innerHTML = response;
	      	}
	    }
    }

	function expand(i) {
		document.getElementById("container").style.animationName = "fadeout";
		document.getElementById("expandedBox").style.display = "block";
		document.getElementById("expandedBox").style.animationName = "expand";
		//Get data
		for (var z=0; z<5; z++) {
			refreshData(document.getElementById("mH"+i).innerHTML, pages[z], z);
		}
		setTimeout(function() {
			document.getElementById("closeButton").style.display = "block";
			document.getElementById("expandTitle").style.display = "block";
			document.getElementById("expandSubTitle").style.display = "block";
			document.getElementById("expandSubTitle").innerHTML = "For "+document.getElementById("mH"+i).innerHTML;
			for (var z=0; z<5; z++) slide(z);
		}, 400);
	}

	function dexpand() {
		document.getElementById("container").style.animationName = "fadein";
		document.getElementById("expandedBox").style.animationName = "dexpand";
		document.getElementById("closeButton").style.display = "none";
		document.getElementById("expandTitle").style.display = "none";
		document.getElementById("expandSubTitle").style.display = "none";
		for (var i=0; i<5; i++) {
			document.getElementById("bar"+i).style.height = 0+"vh";
			document.getElementById("bar"+i).style.marginTop = 96+"vh";
		}
	}

	function barFade(i) {
		for (var z=0; z<5; z++) {
			if (z!=i) {
				document.getElementById("bar"+z).style.animationName = "fadeout";
				document.getElementById("bar"+z+"T").style.animationName = "fadeoutm";
			}
		}
		document.getElementById("bar"+i+"Nu").style.opacity = 1;
		document.getElementById("bar"+i+"T").style.color = "rgb(255, 255, 255, 1)";
	}
	function barUnfade(i) {
		for (var z=0; z<5; z++) {
			if (z!=i) {
				document.getElementById("bar"+z).style.animationName = "fadein";
				document.getElementById("bar"+z+"T").style.animationName = "fadeinm";
			}
		}
		document.getElementById("bar"+i+"Nu").style.opacity = 0.6;
		document.getElementById("bar"+i+"T").style.color = "rgb(255, 255, 255, 0.6)";
	}

	function slide(i) {
		var id = null;
		var marg = 96;
		var height = 0;
		clearInterval(id);
		id = setInterval(frame, 5);

		function frame() {
			if (height == values[i]) clearInterval(id);
			else {
				height++
				marg--;
			    document.getElementById("bar"+i).style.height = height+"vh";
				document.getElementById("bar"+i).style.marginTop = marg+"vh";
			}
		}
	}
</script>
</html>