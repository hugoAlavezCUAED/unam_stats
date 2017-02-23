<?php
	/*
	*
	* Este archivo es utilizado para realizar la asignación de valores indispensables para la utilización del módulo unam_stats
	*
	*/
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');

	//Se verifica que el usuario actual esté autentificado
	if (!isloggedin()){
		error ("Para visualizar este recurso es necesario ingresar al sistema");
	}

	//Se verifica que el usuario actual tiene permisos de administradortz
	if(!is_siteadmin($USER->id)){
		error("no tiene autorización para revisar este contenido");
	}	

	//obtención de los roles en moodle
	$arr_role = get_data_role_all();


	$title = 'INSTALADOR MÓDULO STATS';
	$mi_url ='/unam_stats/instalar.php';

	$PAGE->requires->css('/unam_stats/css/datepicker.css');	
	$PAGE->requires->js('/unam_stats/js/jquery-2.2.3.min.js');			
	$PAGE->requires->js('/unam_stats/js/jquery3.js');	
	$PAGE->requires->js('/unam_stats/js/bootstrap-datepicker.js');
	$PAGE->requires->js('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.js');
	$PAGE->requires->js('/unam_stats/js/instalar.js');
	

	$PAGE->set_pagelayout('custom');
	$PAGE->set_url($mi_url);
	$PAGE->set_title($title);
	$PAGE->set_heading($title);
	$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

	$CFG->additionalhtmlhead .= '<meta name="robots" content="noindex" />';


	echo $OUTPUT->header();
?>
<fieldset>
    <legend>
      Manipulación de las tablas necesarias
    </legend>
    <table border="3" style="text-align: center;">

        <thead>
        	<th>Elemento</th>
          	<th>Descripción</th>
			<th>Existencia</th>
			<th>Tabla con datos</th>
			<th>Última fecha calculada</th>
			<th>Acciones</th>
        </thead>

        <tbody>
			<!-- FILA FORUM_STATS-->
          	<tr>
            	<td>Tabla unam_stats_forum</td>
            	<td>Tabla alamcenadora de los cálculos realizados diariamente por usuario en los foros</td>
				<!-- COLUMNA QUE VERIFICA SI LA TABLA ESTÁ EN EXISTENCIA-->
            	<td>
					<?php
					$exists_unam_stats_forum = check_table_moodle("unam_stats_forum");
					if($exists_unam_stats_forum)
						echo "Si";
					else
						echo "No";
					?>
            	</td>
				<!-- COLUMNA QUE MUESTRA EN CASO DE EXISTIR LA TABLA, SI ÉSTA POSEE DATOS  -->
				<td>
					<?php
					if($exists_unam_stats_forum){
						$data_table = check_table_data("unam_stats_forum");
						if($data_table)
							echo "Si";
						else
							echo "No";
					}
					else
						echo "No existe la tabla";
					?>
				</td>
				<!-- COLUMNA QUE MUESTRA EN CASO DE EXISTIR LA TABLA Y POSEER DATOS, EL ÚLTIMO DATO CALCULADO  -->
				<td>
					<?php
						if($exists_unam_stats_forum){
							if($data_table){
								$last_day = calculated_last_day("unam_stats_forum");
								echo transformation_of_date($last_day);
							}
							else{
								echo "No hay datos en la tabla";
							}
						}
						else{
							echo "No existe la tabla";
						}
					?>
				</td>
				<!-- COLUMNA QUE MUESTRA LAS ACCIONES A REALIZAR-->
				<td>
					<div id="contenido-tbl-forumdata">
						<?php
							if($exists_unam_stats_forum){
								if($data_table){
									?>
										<form name="truncate" id="truncate-fs" action="truncate" method="post">
											<input type="hidden" id="table-name-truncate" name="table" value="unam_stats_forum"/>
											<input type="hidden" id="action" name="action" value="1"/>
											<input type="button" id="button-truncate-fs" name="send" value="truncate"/>
											</form>
									<?php
								}
								else{
									echo "Tabla vacía";
								}
							}
							else{
								?>
									<form name="create" id="create-fs" action="create" method="post">
										<input type="hidden" id="table-name-truncate" name="table" value="unam_stats_forum"/>
										<input type="hidden" id="action" name="action" value="2"/>
										<input type="button" name="send" value="create" id="button-create-fs"/>
									</form>
								<?php
							}
						?>
					</div>
				</td>
          	</tr>


			<!--FILA USER_TIME-->
          	<tr>
            	<td>Tabla unam_stats_usertime</td>
            	<td>Tabla almacenadora del tiempo en plataforma por usuario</td>
				<!-- COLUMNA QUE VERIFICA SI LA TABLA ESTÁ EN EXISTENCIA-->
            	<td>
            		<?php
              			$existe_unam_stats_usertime = check_table_moodle("unam_stats_usertime");
						if($existe_unam_stats_usertime)
							echo "Si";
						else
							echo "No";
              		?>
            	</td>
				<!-- COLUMNA QUE MUESTRA EN CASO DE EXISTIR LA TABLA, SI ÉSTA POSEE DATOS  -->
				<td>
					<?php
						if($existe_unam_stats_usertime){
							$data_table = check_table_data("unam_stats_usertime");
							if($data_table)
								echo "Si";
							else
								echo "No";
						}
						else
							echo "No existe la tabla";
					?>
				</td>
				<!-- COLUMNA QUE MUESTRA EN CASO DE EXISTIR LA TABLA Y POSEER DATOS, EL ÚLTIMO DATO CALCULADO  -->
				<td>
					<?php
						if($existe_unam_stats_usertime){
							if($data_table){
								$last_day = calculated_last_day("unam_stats_usertime");
								echo transformation_of_date($last_day);
							}
							else{
								echo "No hay datos en la tabla";
							}
						}
						else{
							echo "No existe la tabla";
						}
					?>
				</td>
				<!-- COLUMNA QUE MUESTRA LAS ACCIONES A REALIZAR-->
				<td>
					<div id="contenido-tbl-userdata">
						<?php
							if($existe_unam_stats_usertime){
								if($data_table){
									?>
										<form name="truncate" id="truncate-ut" action="truncate" method="post">
											<input type="hidden" id="table-name-truncate-user" name="table" value="unam_stats_usertime" />
											<input type="hidden" id="action" name="action" value="1" />
											<input type="button" name="send" value="truncate" id="button-truncate-ut"/>
										</form>
									<?php
								}
								else{
									echo "Tabla vacía";
								}
							}
							else{
						?>
									<form name="create" id="create-ut" action="create" method="post">
										<input type="hidden" id="table-name-create" name="table" value="unam_stats_usertime"/>
										<input type="hidden" id="action" name="action" value="2"/>
										<input type="button" name="send" value="create" id="button-create-ut"/>
									</form>
							<?php
							}
							?>
					</div>
				</td>
          	</tr>
        </tbody>
    </table>
</fieldset>
<br>
<br>





<fieldset>
	<legend>
		Insumos requeridos para el cálculo de 'STATS'
	</legend>
	<form id="form-insumes" name="forum-insumes" method="post" action="instalar_preparacion.php">		
		<!-- VENTANA DE TIEMPO-->
		<div id="error-time-window" class="error-form-stats">
			<label>Por favor asigne un valor numérico al campo ventana de tiempo.</label>
		</div>
		<label>Ventana de tiempo: </label>
		<?php
			if($CFG->time_window == null){
				?>
					<input type="text" name="time_window" id="time-window"/>
				<?php
			}
			else
				echo "<p>".$CFG->time_window." Milisegundos</p>";
		?>


		<!-- FECHA INICIAL PARA EL CÁLCULO-->
		<div id="error-start-day" class="error-form-stats">
			<label>Por favor seleccione la fecha inicial para el cálculo.</label>
		</div>
		<label>Fecha inicial para el cálculo: </label>
		<?php
			if($CFG->start_day == null){
				?>
					
						<input type="text" name="start_day" id="start-day" class="datepicker"/>
					
				<?php
			}
			else{
				echo $start_day_format = transformation_of_date($CFG->start_day);				
			}
		?>

		<!-- ROLES ACEPTADOS PARA EL CÁLCULO-->
		<div id="error-role-calculate" class="error-form-stats">
			<label>Por favor seleccione los roles aceptados para el cálculo.</label>
		</div>
		<label>Roles aceptados para el cálculo: </label>
		<?php
		if($CFG->role_calculate == null){
			?>
				<select multiple name="role[]" id="role-calculate" size="6">
					<?php
						foreach ($arr_role as $arr_role_single){
							if($arr_role_single->name == "")
					 			echo "<option value='".$arr_role_single->id."'>".$arr_role_single->shortname." </option>";
					 		else
					 			echo "<option value='".$arr_role_single->id."'>".$arr_role_single->name." </option>";
					 	}
					?>
				</select>
			<?php
		}
		else{
			$data_role_calculate = get_data_role();
			echo "<ul id='role_calculate'>";
			foreach($data_role_calculate as $role){
				
				echo "<li>".$role->shortname."</li>";				
			}
			echo "</ul>";
		}
		?>

		<!-- ROLES ACEPTADOS PARA EL CÁLCULO-->
		<div id="error-role-allowed" class="error-form-stats">
			<label>Por favor seleccione los roles aceptados para consulta.</label>
		</div>
		<label>Roles permitidos para consulta: </label>
		<?php
			if($CFG->role_allowed == null){
				?>
					<select multiple name="role_allowed[]" id="role-allowed" size="6">
					</select>
				<?php
			}
			else{
				$data_role_allowed = get_data_role_allowed();
				echo "<ul id='role_allowed'>";
				foreach($data_role_allowed as $role){				
					echo "<li>".$role->shortname."</li>";
				}
				echo "</ul>";
			}
			?>			
	</form>
	<?php
	if($CFG->time_window == null || $CFG->start_day == null || $CFG->role_calculate == null || $CFG->role_allowed == null){
		?>
			<button id="send-form-stats">
				Enviar
			</button>
		<?php
	}
	?>
</fieldset>
<?php
	echo $OUTPUT->footer();
?>