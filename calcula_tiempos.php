<?php
/*se configura la pagina */
	define('CLI_SCRIPT', true);
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');
	
	$memoria_inicial = memory_get_usage();
	$memo_ini=memory_get_peak_usage();	
	$time_ini=_microtime();

	
	echo 'Memoria inicial: ' . $memoria_inicial . '
	
	memo ini: '. $memo_ini .'
	
	';
	
	
	
	calculate_unam_stats_usertime_for_instalation(); 
	
	$time_fin=_microtime();
	$memo_fin=memory_get_peak_usage();	
	$memoria_final = memory_get_usage();
	echo '
	Memoria final: ' . $memoria_final . '
	
	memo ini: '. $memo_fin .'

	';


	

echo "Usados un máximo de: ".round(($memo_fin - $memo_ini)/(1024*1024),2). "Mb";

?>
