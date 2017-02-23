<?php

	/*
	*
	*Este archivo es utilizado como índice para el administrador, donde podrá seleccionar los datos a descargar en formato .csv
	*
	*/
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');


	//Se verifica que el usuario actual esté autentificado
	if (!isloggedin()){
		error ("Para visualizar este recurso es necesario ingresar al sistema");
	}

	//Se verifica que el usuario actual tiene permisos para ver sus estadísticas
	$aceptado = stats_authorized_user($USER->id, $CFG->role_allowed);

	if ($aceptado){
		//Se verifica que existan las variable para hacer el calculo en las tablas
		if($CFG->time_window == null || $CFG->start_day == null || $CFG->role_calculate == null || $CFG->role_allowed == null || !check_table_moodle("unam_stats_forum") || !check_table_moodle("unam_stats_usertime")){
			header('Location:../index.php');
			die();
		}
		header('Location:index2.php');
		die();

	}

	//Se verifica que el usuario actual tiene permisos de administradortz
	if(!is_siteadmin($USER->id)){
		error("no tiene autorización para revisar este contenido");
		die();
	}

	//Se verifica para el rol de administrador que los elementos necesarios estén listos, para mostrar el formulario que generará los cálculos
	if($CFG->time_window == null || $CFG->start_day == null || $CFG->role_calculate == null || $CFG->role_allowed == null || !check_table_moodle("unam_stats_forum") || !check_table_moodle("unam_stats_usertime")){
		header('Location:instalar.php');
		die();
	}


	$title = 'INDICATORS PLATFORM';
	$mi_url ='/unam_stats/index.php';

	$PAGE->requires->css('/unam_stats/css/datepicker.css');	
	$PAGE->requires->js('/unam_stats/js/jquery-2.2.3.min.js');					
	$PAGE->requires->js('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.js');	
	$PAGE->requires->js('/unam_stats/js/bootstrap-datepicker.js');	
	$PAGE->requires->js('/unam_stats/js/index.js');	

	$PAGE->set_pagelayout('custom');
	$PAGE->set_url($mi_url);
	$PAGE->set_title($title);
	$PAGE->set_heading($title);
	$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

	$CFG->additionalhtmlhead .= '<meta name="robots" content="noindex" />';


	echo $OUTPUT->header();
	$arr_role = get_data_role();
?>
<form id="download_list" method="post" action="download_file.php">
<table>

<?php
	include_once('select_stats.php');
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
	<td>
		<label>Select role to download forum: </label>
	</td>
	<td>
		<select multiple name="role[]" id="role" size="9">
			<?php
			foreach ($arr_role as $arr_role_single) {
				if($arr_role_single->name == "")
			 		echo "<option value='".$arr_role_single->id."'>".$arr_role_single->shortname."</option>";
			 	else
			 		echo "<option value='".$arr_role_single->id."'>".$arr_role_single->name."</option>";
			 }
			?>
		</select>
	</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input id="submit" style="display:none" type="submit" value="Download data">
		</td>
	</tr>
	</table>
</form>
<?php
	echo $OUTPUT->footer();
?>
