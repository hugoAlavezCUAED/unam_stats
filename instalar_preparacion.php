<?php
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');
  	global $CFG;

	/*Datos obtenidos mediante el método POST*/
	$time_window = $_POST['time_window'];
	$role = $_POST['role'];
	date_default_timezone_set('UTC');
	$start_day = $_POST['start_day'];
  	$role_separed = "";
	$role_allowed = $_POST['role_allowed'];
	$role_allowed_separed = "";
	$bandera_creacion_tablas = true;

	//Se verifica que el usuario actual esté autentificado
	if (!isloggedin()){
		error ("Para visualizar este recurso es necesario ingresar al sistema");
		die();
	}

	$title = 'INSTALADOR MÓDULO STATS';
	$mi_url ='/unam_stats/instalar_preparacion.php';

	$PAGE->requires->css('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.structure.min.css');
	$PAGE->requires->css('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css');
	$PAGE->requires->js('/unam_stats/js/jquery-2.2.3.min.js');
	$PAGE->requires->js('/unam_stats/js/jquery-ui-1.11.4.custom/jquery-ui.min.js');
	$PAGE->requires->js('/unam_stats/js/index.js');

	$PAGE->set_pagelayout('custom');
	$PAGE->set_url($mi_url);
	$PAGE->set_title($title);
	$PAGE->set_heading($title);
	$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

	$CFG->additionalhtmlhead .= '<meta name="robots" content="noindex" />';
  	echo $OUTPUT->header();

  	//verificar si las variables en config están creadas

  	//variable time_window
  	if($CFG->time_window == null)
		insert_config("time_window", $time_window);

  	//variable start_day
  	if($CFG->start_day == null){
        $offset = date("Z");//Variable offset que contiene la diferencia del GMT para ser aplicada en las variables tipo date
        $offset *= 1;//Se multiplica por 1 para transformar la cadena a un entero
        $start_day_tmstp = strtotime($start_day);        
        $start_day_tmstp += $offset;        
        insert_config("start_day", $start_day_tmstp);
  	}

  	//variable role_calculate
  	if($CFG->role_calculate == null){
    	for($i = 0; $i < sizeof($role); $i++){
			$role_separed .= $role[$i].",";
    	}
    	$length_role_separed = strlen($role_separed);
    	$role_send = substr($role_separed,0,$length_role_separed-1);
    	insert_config("role_calculate", $role_send);
  	}

	//variable role_allowed
  	if($CFG->role_allowed == null){
    	for($j = 0; $j < sizeof($role_allowed); $j++){
          	$role_allowed_separed .= $role[$j].",";
    	}
    	$length_role_allowed_separed = strlen($role_allowed_separed);
    	$role_send_allowed = substr($role_allowed_separed,0,$length_role_allowed_separed-1);
    	insert_config("role_allowed", $role_send_allowed);
  	}
  	?>
	<table style="width: 100%; text-align: center;" border="1px;">
      	<thead>
        	<tr>
          		<th>Elemento</th>
				<th>valor</th>
          		<th>Estatus</th>
        	</tr>
      	</thead>
      	<tbody>
	        <tr>
	          	<td>Tabla unam_stats_usertime</td>		          					
	          	<td>
	          	<?php
					if(check_table_moodle("unam_stats_usertime"))
						echo "Creado";
					else{
						echo "No creado";
						$bandera_creacion_tablas = false;
					}
				?>		          		
	          	</td>
				<?php
				if(check_table_moodle("unam_stats_usertime")){
					echo "<td style='background: #99ff99;'>";
					echo "OK";
					echo "</td>";
				}
				else{
					echo "<td style='background: red;'>";
					echo "NO creado";
					echo "</td>";
					$bandera_creacion_tablas = false;
				}
				?>	          	
	        </tr>

	        <tr>
	          	<td>Tabla unam_stats_forum</td>
				<td>
	          	<?php
					if(check_table_moodle("unam_stats_forum"))
						echo "Creado";
					else{
						echo "No creado";
						$bandera_creacion_tablas = false;
					}
				?>		          		
	          	</td>
				<?php
				if(check_table_moodle("unam_stats_forum")){
					echo "<td style='background: #99ff99;'>";
					echo "OK";
					echo "</td>";
				}
				else{
					echo "<td style='background: red;'>";
					echo "NO creado";
					echo "</td>";
					$bandera_creacion_tablas = false;
				}
				?>	          	
	        </tr>
	        <tr>
	          	<td>$CFG->time_window</td>
				<td>
	            	<?php
						echo $time_window." Milisegundos";
					?>
	          	</td>
	          	<td style="background: #99ff99;">OK</td>
	        </tr>

	        <tr>
	          	<td>$CFG->start_day</td>
				<td>
	            	<?php
	            		echo $start_day;						
					?>
	          	</td>
	          	<td style="background: #99ff99;">OK</td>
	        </tr>

	        <tr>
	          	<td>$CFG->role_calculate</td>
				<td>
	            	<?php						
						$data_role_calculate = get_data_role_per_ids($role_send);
						echo "<ul id='role_calculate'>";
						foreach($data_role_calculate as $role){
							
							echo "<li>".$role->shortname."</li>";				
						}
						echo "</ul>";
					?>
	          	</td>
	          	<td style="background: #99ff99;">OK</td>
        	</tr>

	        <tr>
	        	<td>$CFG->role_allowed</td>
				<td>
	            	<?php						
						$data_role_allowed = get_data_role_per_ids($role_send_allowed);
						echo "<ul id='role_allowed'>";
						foreach($data_role_allowed as $role){				
							echo "<li>".$role->shortname."</li>";
						}
						echo "</ul>";
					?>
	          	</td>
	          	<td style="background: #99ff99;">OK</td>
	        </tr>
  		</tbody>
  	</table>
	<br>
	
	<?php
	if(!$bandera_creacion_tablas){
	?>
		<center>
			<p>
			Alguno de los insumos no está configurado, por favor regrese a la instalación y verifique que las tablas estén creadas y las variantes configuradas correctamente
			</p>
		</center>			
	<?php
	}
	else{
	?>		
		<p>
		La instalación de los insumos necesarios está completa, para comenzar a hacer uso de la aplicación es necesario seguir las siguientes instrucciones:
		</p>
		<br>
		<p>
		NOTA: Lea todos los puntos siguientes antes de hacerlos.
		</p>
		<br>
		<ol>
			<li>
				Purgar todas las cachés para poder utilizar los elementos anteriormente configurados. Para hacerlo puede dar clic en este <a href="<?php echo $CFG->wwwroot . '/admin/purgecaches.php';?>">enlace</a>.
			</li>			
			<li>			
				Salir de la sesion de Moodle.
			</li>
			<li>
				Abrir una línea de comandos (terminal) y posicionarse en el directorio "unam_stats".
			</li>
			<li>
				En la línea de comandos ejecutar como super usuario la siguiente instrucción:       php calcula_foros.php
			</li>
			<li>
				En la línea de comandos ejecutar como super usuario la siguiente instrucción:       php calcula_tiempos.php
			</li>
			<li>
				Una vez realizados los pasos anteriores la aplicación "unam_stats" podrá utilizarse. 
			</li>				
		</ol>	
	<?php
	}
	echo $OUTPUT->footer();
?>