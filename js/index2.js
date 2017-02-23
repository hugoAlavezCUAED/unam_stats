var obj_json = null;

$( document ).ready(function() {

	$( "#fecha_inicio" ).datepicker({
		autoclose: true,
       	todayHighlight: true,
       	format: 'dd-mm-yyyy'
	});
	$( "#fecha_fin" ).datepicker({
		autoclose: true,
       	todayHighlight: true,
       	format: 'dd-mm-yyyy'
	});
	
	$('#download_list').submit(function() { 
		if(validar()){
			$.ajax({
			    type: 'POST',
			    url: $(this).attr('action'),
			    data: $(this).serialize(),			    
			    // Se recibe el objeto JSON
			    complete: function(data) {
				console.log(data);
				obj_json = jQuery.parseJSON(data.responseText);
				console.log(obj_json);


				switch(parseInt(obj_json.opcion.opcion)){
					case 1:
						dibujaChart_1(obj_json);
					break;
					case 2:
						dibujaChart_2(obj_json);
					break;
					case 3:
						dibujaChart_3(obj_json);
					break;
					case 4:
						dibujaChart_4(obj_json);
					break;
					default:
						alert("si aparece esto estas haciendo algo maltz");
				}

			    }
			}) 

		}
		return false;  
		
	});

	$("#submit").show();	

});


function dibujaChart_4(obj_json) 
{
	$('#result').html("aqui va la gráfica " + obj_json.opcion.opcion);

}
function dibujaChart_3(obj_json) 
{
	$('#result').html("aqui va la gráfica " + obj_json.opcion.opcion);
}

function dibujaChart_2(obj_json) 
{
	var x = document.createElement("IFRAME");
	x.setAttribute("src", "grafica_grupos.php");
	x.setAttribute("id", "grafica_grupos");
	x.setAttribute("height", "200");
	x.setAttribute("width", "200");
    	$("#result").html("");
    	$("#result").append(x); 
    	$("#grafica_grupos").css("position", "absolute");
    	$("#grafica_grupos").css("top", "0");
    	$("#grafica_grupos").css("left", "0");
    	$("#grafica_grupos").css("width", "100%");
    	$("#grafica_grupos").css("height", "80%");
}


function dibujaChart_1(obj_json) 
{
	var dps =[];

	dps[1]= {
			type:"spline", 
			markerSize: 5, 
			showInLegend: true, 
			legendText: "Tiempos promedio", 
			color: "rgba(213,159,15,.99)", 
			dataPoints:new Array()
		}; 
	dps[0]= {
			toolTipContent: "{x}<br/>{y} minutos",			
			type:"splineArea",
			markerSize: 5, 
			showInLegend: true, 
			legendText: "Tiempos usuario ", 
			color: "rgba(0,61,121,.99)",  
			dataPoints:new Array()
		}; 

	for (var elemento in obj_json.header) {
		if (!isNaN(elemento)){
			var fElemento = new Date(elemento*1000);
			
			var nuser = parseInt(obj_json.user[elemento])/60;
			var nprom = parseInt(obj_json.prom[elemento])/60;

			dps[1].dataPoints.push({x: fElemento, y:nprom });
			dps[0].dataPoints.push({x: fElemento, y:nuser });


		}

	}

	var chart2 = new CanvasJS.Chart("result",
	{
		title:{
			text: "Datos de acceso de " + obj_json.user.firstname + " " + obj_json.user.lastname,
			fontSize: 40,
			},  
	axisX: {
		lineThickness:2,
		title: "fecha",
		labelFontSize: 15,
		labelFontColor: "black",
		intervalType: "week"

	      }, 		
	axisY:{
		title: "Minutos",
		labelFontSize: 15,
		labelFontColor: "black",
		suffix: " min"
	}, 
		data: dps
	});

	chart2.render();

}
function prueba(obj) {
	console.log("prueba");
    setTimeout(function(){ obj.render(); }, 5000);
	console.log( new Date());
}

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

	return 1;
}

