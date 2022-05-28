<?php
	//ini_set('display_errors', '0');
	$result = "0";
	$filename = "logs/".$_POST["log"].".txt";
	if ($filename!=null) {
		$count = 0;
		$contents = file($filename);
		foreach($contents as $line) {
			if ($line==$_POST["date"]) {
				$result = $contents[++$count];
				break;
			}
			$count++;
		}
		echo($result);
	}
?>;