$( document ).ready(function() {

	$( "#fecha_inicio" ).datepicker({		
       	format: 'dd-mm-yyyy'
	});
	$( "#fecha_fin" ).datepicker({
		autoclose: true,
       	todayHighlight: true,
       	format: 'dd-mm-yyyy'
	});		

	
	$('#download_list').submit(function() {
		if(validar()){		
			return true;
		}
		else{
			return false;
		}

	});

	function validar(){
		var dato = -1;

		//se valida que el indicador sea válido
		dato = $('#indicator').val();
		if (dato =='0')
		{
			mensaje = " Selecciona un indicador válido";
			$( "#indicator" ).focus();
			return 0;
		}

		dato = $('#fecha_inicio').val();
		if (dato =='')
		{
			mensaje = " Selecciona una fecha de inicio válido";
			$( "#fecha_inicio" ).focus();
			return 0;
		}
		dato = $('#fecha_fin').val();
		if (dato =='')
		{
			mensaje = " Selecciona una fecha de inicio válido";
			$( "#fecha_fin" ).focus();
			return 0;
		}


		dato = $('#role').val();
		if (!dato)
		{
			mensaje = " Selecciona una fecha de inicio válido";
			$( "#role" ).focus();
			return 0;
		}
		return 1;
	}
	$("#submit").show();
});