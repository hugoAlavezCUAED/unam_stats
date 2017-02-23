<?php

	///////////////////////////////////////////
	/*Datos obtenidos mediante el método POST*/
	///////////////////////////////////////////

	//La variable indicator contiene la opción seleccionada por el usuario
	$indicator = $_POST['indicator'];
	//las variables fecha_inicio y fecha_fin contienen el período de cálculo y descarga de la información requerida
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
	//la variable userid posee el id del usuario 
	$userid = $_POST['userid'];


	require_once(dirname(__FILE__) . '/../config.php');
	require_once('lib.php');
	require_once($CFG->libdir.'/formslib.php');
	require_once($CFG->dirroot.'/user/profile/lib.php');
	require_once($CFG->dirroot . '/user/editlib.php');


	/*Ajuste de las fechas para adecuar al formato GMT*/
	$offset = date("Z");
	$offset *= 1;
	$fecha_inicio = strtotime($fecha_inicio);
	$fecha_fin = strtotime($fecha_fin);
	$fecha_inicio += $offset;
	$fecha_fin += $offset;


//	$string_roles = "()";
	$output ="";
	
	/*Se genera la cadena para cada opción*/
	switch($indicator){
		case 1: 
			$string_output = "time_platform";
			$output = get_time_platform_user($fecha_inicio, $fecha_fin, $userid);
		break;

		case 2: 
			$string_output = "forum_posts";
			$output["data"] = get_records_unam_stats_forum2($userid, $fecha_inicio, $fecha_fin);
			$output["user"] = core_user::get_user($userid);
		break;

		case 3:
			$string_output = "messages_on_the_messenger";
		break;

		case 4:
			$string_output = "forum_posts_details";		
		break;
	}

	$output["opcion"] = array ("opcion"=>$indicator);

	echo json_encode($output);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*function pa_probar($opcion){

	$output["opcion"] = array ("opcion"=>$opcion);
	return $output;
}*/
?>
