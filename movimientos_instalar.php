<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once('lib.php');
$result = "hecho";
//La variable acción posee el identificador para crear o trucar la tabla mediante AJAX
$accion = addslashes(htmlspecialchars($_POST["action"]));
//La table_name posee el nombre de la tabla para crearla o trucarla mediante AJAX
$table_name = addslashes(htmlspecialchars($_POST["table"]));
//TRUNCAR TABLA
if($accion == 1){
  truncate_table_database($table_name);
}
//CREAR TABLA
if($accion == 2){
	if($table_name == "unam_stats_forum"){
    	create_table_unam_stats_forum($table_name);
  	}
  	if($table_name == "unam_stats_usertime"){
    	create_table_unam_stats_usertime($table_name);
  	}
}
echo $result;
?>