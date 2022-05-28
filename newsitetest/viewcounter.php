<?php
	//ini_set('display_errors', '0');
	//GET DATA
		$date = date('d-m-Y');

	//READ FILE
		$content = file_get_contents("logs/".$_POST["log"].".txt");

		$dateInstance = file("logs/".$_POST["log"].".txt");
		$rDate = substr($dateInstance[sizeof($dateInstance)-2], 0, 10);
		$rValue = $dateInstance[sizeof($dateInstance)-1];
		$newValue = $rValue+1;

		if ($date==$rDate) {
			$result = substr($content, 0, strlen($content)-strlen($rValue)).$newValue;
		}
		else {
			$result = $content.PHP_EOL.PHP_EOL.$date.PHP_EOL."1";
		}
		file_put_contents("logs/".$_POST["log"].".txt", $result);
		echo "done";
?>