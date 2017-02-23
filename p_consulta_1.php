<?php
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');
	$arr_reporte = unserialize($_POST['arr_reporte']);
	$ouput = "";
	foreach($arr_reporte as $i => $v){
		foreach($v as $w){
			if ($i == 0){
				$ouput .= $w . ',';
			} else{
				$ouput .= $w . ',';
			}
		}	
		$ouput[strlen($ouput) - 1] = "\n";
	}	
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $ouput;
?>
