<?php
	/*
	*
	*Este archivo es utilizado como índice para los roles que han sido aceptados para visualizar la información de estadísticas en el módulo unam_stats
	*
	*/
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');

	//Se verifica que el usuario actual esté autentificado
	if (!isloggedin()){
		error ("Para visualizar este recurso es necesario ingresar al sistema");
	}

	$title = 'INDICATORS PLATFORM';
	$mi_url ='/unam_stats/index2.php';
	$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

	//$PAGE->requires->css('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.structure.min.css');
	//$PAGE->requires->css('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css');

	$PAGE->requires->css('/unam_stats/css/datepicker.css');				
	$PAGE->requires->js('/unam_stats/js/jquery3.js');	
	$PAGE->requires->js('/unam_stats/js/jquery-2.2.3.min.js');		
	$PAGE->requires->js('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.js');
	$PAGE->requires->js('/unam_stats/js/jquery.canvasjs.min.js');
	$PAGE->requires->js('/unam_stats/js/bootstrap-datepicker.js');
	$PAGE->requires->js('/unam_stats/js/index2.js');	

	$PAGE->set_pagelayout('custom');
	$CFG->additionalhtmlhead .= '<meta name="robots" content="noindex" />';

	$PAGE->set_url($mi_url);
	$PAGE->set_title($title);
	$PAGE->set_heading($title);
	
	echo $OUTPUT->header();
?>
<form id="download_list" method="post" action="download_file_user.php">
<table>
<?php
//	echo '<input type="hidden" value="2187"          name="userid" id="userid" />';	
	echo '<input type="hidden" value="'.$USER->id.'" name="userid" id="userid" />';
	include_once('select_stats_2.php');
?>
	<tr>
		<td>
			<label>Start date: </label>	
		</td>
		<td>
			<input type="text" name="fecha_inicio" id="fecha_inicio">
		</td>
	</tr>
	<tr>
		<td>
			<label>End date: </label>	
		</td>
		<td>
			<input type="text" name="fecha_fin" id="fecha_fin">
		</td>	
	<tr>
		<td colspan="2" align="center">
			<input id="submit" style="display:none" type="submit" value="Show data">
		</td>	
	</tr>
	</table>
</form>

<?php
	echo '<div id="result" style="position: relative; padding-bottom: 80%; height: 0; overflow: hidden;" >';
	echo '</div>';
	echo $OUTPUT->footer();
?>
	
