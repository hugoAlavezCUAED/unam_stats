<?php
	/*Se colocan las cabeceras que serán de utilidad en el archivo*/
	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');
	require_once($CFG->libdir.'/formslib.php');
	require_once($CFG->dirroot.'/user/profile/lib.php');
	require_once($CFG->dirroot . '/user/editlib.php');

	///////////////////////////////////////////
	/*Datos obtenidos mediante el método POST*/
	///////////////////////////////////////////

	/*la variable indicator contiene el valor 1 en caso de ser time_platform, 2 para forum_post, 3 para messages_on_the_messenger y 4 para forum_posts_details*/
	$indicator = $_POST['indicator'];

	/*la variable roles contiene el id de los roles que fueron seleccionados por el usuario para realizar sus cálculos*/
	$roles = $_POST['role'];
	
	/*Se utiliza UTC como default time zone*/
	date_default_timezone_set('UTC');
	/*La variale fecha_inicio contiene el día de inicio para realizar las consultas y el cálculo*/
	$fecha_inicio = $_POST['fecha_inicio'];

	/*Se utiliza UTC como default time zone*/
	date_default_timezone_set('UTC');
	/*La variale fecha_fin contiene el día de inicio para realizar las consultas y el cálculo*/
	$fecha_fin = $_POST['fecha_fin'];

	/*Se verifica que el usuario actual esté autentificado*/
	if (!isloggedin()){
		error ("Para visualizar este recurso es necesario ingresar al sistema");
		die();
	}

	$fecha_inicio_format = $fecha_inicio;
	$fecha_fin_format = $fecha_fin;

	/*Se inicializa la variable $string_roles en vacío para posteriormente agregar el id de los roles seprado por comas (,)*/
	$string_roles = "";

	/*Se inicializa la variable output en vacío, la que será utilizada para imprimir en el archivo .csv los datos obtenidos*/
	$output ="";

	/*Se formatea el rol o roles elegidos por el usuario */
	if(count($roles) > 0){
		if(count($roles) == 1){
			$string_roles = $roles[0];
		}
		else{
			for ($i = 0; $i < count($roles); $i++){
				$string_roles .= $roles[$i].",";
			}
			$string2_roles = strlen($string_roles);
			$string_roles = substr($string_roles, 0, $string2_roles-1);
		}
	}

	////////////////////////////////////////////////////
	/*Ajuste de las fechas para adecuar al formato GMT*/
	////////////////////////////////////////////////////
	
	$offset = date("Z");
	$offset *= 1;
	/*El formato de la fecha de inicio cambia a long (timestamp)*/
	$fecha_inicio = strtotime($fecha_inicio);
	/*El formato de la fecha de fin cambia a long (timestamp)*/
	$fecha_fin = strtotime($fecha_fin);
	/*Se realiza el ajuste de la fecha inicio y fin realizando la suma del valor de la variable offset*/
	$fecha_inicio += $offset;
	$fecha_fin += $offset;	
	
	/*Se genera la cadena para cada opción*/
	switch($indicator){
		case 1:
			$string_output = "time_platform";
			$output = get_time_platform($fecha_inicio, $fecha_fin, $string_roles);
		break;

		case 2:
			$string_output = "forum_posts";
			$users = get_user_id_role($string_roles);
			$users_str = array_to_string($users);
			$arr_msg_forum = get_masseges_forum_role($fecha_inicio, $fecha_fin, $users_str);
			$output = get_data($arr_msg_forum, array("id"));
		break;

		case 3:
			$string_output = "messages_on_the_messenger";
			$users = get_user_id_role($string_roles);
			$users_str = array_to_string($users);
			$arr_msg_messenger = get_messages_messenger_role($fecha_inicio, $fecha_fin, $users_str);
			$output = get_data($arr_msg_messenger);
		break;
		case 4:
			header('Location:detalle_foros.php?roles='.$string_roles."&fei=".$fecha_inicio_format."&fef=".$fecha_fin_format);
			die();
			//$string_output = "forum_posts_details";
			//$output = get_unam_stats_forum_details($fecha_inicio, $fecha_fin, $string_roles);
		break;
	}
	//Cabeceras para generar el archivo con extensión csv
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=".$string_output.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");
//	echo "<pre> $output </pre>";
	echo $output;
?>
