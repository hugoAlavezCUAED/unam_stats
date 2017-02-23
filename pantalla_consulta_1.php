<?php
/*se configura la pagina */
	require_once(dirname(__FILE__) . '/../config.php');
	//verifico que me hayan pasado el id del profesor
	if (isset($_POST["teachers"])) {
		$idusuario = $_POST["teachers"];
	}else{
		error("No es posible consultar esta página escribiendo la url directamente");
	}

	require_once('lib.php');
	$title = 'Tiempo en plataforma';
	$mi_url = '/robot/pantalla_consulta_1.php';	


	$PAGE->requires->js('/robot/js/jquery-2.2.3.min.js');
	$PAGE->requires->js('/robot/js/jquery.canvasjs.min.js');
	$PAGE->requires->js('/robot/js/pantalla_consulta_1.js');

	$PAGE->set_pagelayout('custom');
	$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
	$PAGE->set_url($mi_url);
	$PAGE->set_title($title);
	$PAGE->set_heading($title);	


	$venta_tiempo = 1800;
	$f_inicio = 1451606400;
	$f_fin = 1461110399;

	/*comienza el despliegue de información en la pantalla*/
	echo $OUTPUT->header();

	$teacher = core_user::get_user($idusuario);
	echo '<br/><strong>nombre: '.$teacher->firstname . ' '.$teacher->lastname.'</strong>' ;
	echo '<br/><br/>Ultimo acceso al sistema: '.gmdate('d/m/Y H:i:s', $teacher->lastlogin);
	echo '<br/>Ultimo registro de actividad: '.gmdate('d/m/Y H:i:s', $teacher->lastaccess);
	

	$l = consulta_logs_usuario($idusuario,$f_inicio,$f_fin);
	$total_segundos_usuario = computo_tiempo($l, $venta_tiempo);
	
	echo '<br/><br/>El tiempo estimado en plataforma para el periodo <strong>'.gmdate('d/m/Y H:i:s', $f_inicio).' - '.gmdate('d/m/Y H:i:s', $f_fin).'</strong> es de '.conversorSegundosHoras($total_segundos_usuario).' segundos<br/><br/>';

	$store_records = get_records_teacher_time($idusuario, $f_inicio, $f_fin);
	$acum = 0;
	$json_data = '[';
	foreach ($store_records as $record) {
		$json_data .= '{x : '.$record->time_start.', y:'.$record->total_time.'},';
		$acum += $record->total_time;
	}

	$json_data[strlen($json_data) - 1] = ']';

	echo '<br/> Tiempo total con los registros de la base datos = '. conversorSegundosHoras($acum) . ' segundos';
	$diff = $total_segundos_usuario - $acum;
	$diff = $diff < 0 ? ($diff * -1): $diff;
	$diff = conversorSegundosHoras($diff);
	
	echo '<br/> La diferencia entre el cálculo y la suma es de  '.$diff . 'segundos<br/><br/>';
	echo '<div id="chart"></div>';
	echo '<script>var json_data = '.$json_data.';</script>';

	/*se imprime el footer de la página*/
	echo $OUTPUT->footer();

?>
