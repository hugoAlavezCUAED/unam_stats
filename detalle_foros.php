<?php
	/*
	*
	*Este archivo es utilizado como índice para el administrador, donde podrá seleccionar los datos a descargar en formato .csv
	*
	*/
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');

	$roles = $_GET['roles'];
	$fecha_inicio = $_GET['fei'];
	$fecha_fin = $_GET['fef'];


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
	$mi_url ='/unam_stats/detalle_foros.php';	

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
	$array_users = get_user_id_name_role($roles);	
?>
	<form id="download_list" method="post" action="download_file_user.php">
	<?php	
		echo '<input type="hidden" value="2" name="indicator" id="indicator"/>';		
	?>
		<table>
			<caption>FORUM POST DETAIL</caption>
			<tbody>
				<tr align="left">
					<td>
						<label>Start date: </label>	
					</td>
					<td>
						<input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha_inicio;?>"/>
					</td>
				</tr>
				<tr align="left">
					<td>
						<label>End date: </label>	
					</td>
					<td>
						<input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $fecha_fin;?>"/>
					</td>	
				</tr>
				<tr align="left">
					<td>Select user for view: </td>
					<td>
						<select id="userid" name="userid">
							<?php
							foreach ($array_users as $user){
								echo "<option value=".$user->id.">".$user->lastname.", ".$user->firstname." (".$user->shortname.")"."</option>";
							}
							?>					
						</select>
					</td>
				</tr>
				<tr align="center">
					<td>
						<input id="submit" type="submit" value="Show data">
					
					</td>										
				</tr>				
			</tbody>
		</table>				
	</form>
	<form method="post" action="index.php">
		<table>
			<tr>
				<td>
					<input type="submit" value="return to indicators platform" id="return"/>
				</td>
			</tr>
		</table>
	</form>	
<?php
	echo '<div id="result" style="position: relative; padding-bottom: 80%; height: 0; overflow: hidden;" >';
	echo '</div>';
	echo $OUTPUT->footer();
?>