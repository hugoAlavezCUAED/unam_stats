$( document ).ready(function() {

	
	$(".error-form-stats").css("color", "red");
	$(".error-form-stats").hide();



	//Botón create table unam_stats_forum
	$(function(){
		$("#button-create-fs").click(function(){
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#create-fs").serialize(),
				success: function(data){
					console.log("ok");
					$("#contenido-tbl-forumdata").empty();
					$("#contenido-tbl-forumdata").html(data);
				}
			});
			return false;
		});
	});

	//Botón Truncate table unam_stats_forum
	$(function(){
		$("#button-truncate-fs").click(function(){
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#truncate-fs").serialize(),
				success: function(data){
					$("#contenido-tbl-forumdata").empty();
					$("#contenido-tbl-forumdata").html(data);
				}
			});
			return false;
		});
	});




	//Botón create table unam_stats_usertime
	$(function(){
		$("#button-create-ut").click(function(){			
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#create-ut").serialize(),
				success: function(data){					
					$("#contenido-tbl-userdata").empty();
					$("#contenido-tbl-userdata").html(data);
				}
			});
			return false;
		});
	});

	//Botón Truncate table unam_stats_usertime
	$(function(){
		$("#button-truncate-ut").click(function(){
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#truncate-ut").serialize(),
				success: function(data){
					$("#contenido-tbl-userdata").empty();
					$("#contenido-tbl-userdata").html(data);
				}
			});
			return false;
		});
	});



	//Botón create table unam_stats_usertime_course
	$(function(){
		$("#button-create-utc").click(function(){			
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#create-utc").serialize(),
				success: function(data){					
					$("#contenido-tbl-userdata-course").empty();
					$("#contenido-tbl-userdata-course").html(data);
				}
			});
			return false;			
		});
	});

	//Botón Truncate table unam_stats_usertime
	$(function(){
		$("#button-truncate-utc").click(function(){
			var url = "movimientos_instalar.php";
			$.ajax({
				type: "POST",
				url: url,
				data: $("#truncate-utc").serialize(),
				success: function(data){
					$("#contenido-tbl-userdata-course").empty();
					$("#contenido-tbl-userdata-course").html(data);
				}
			});
			return false;
		});
	});



	//Botón que envía el formulario stats
	$(function(){
		$("#send-form-stats").click(function(){
			$(".error-form-stats").hide();

			var time_window = $("#time-window").val();
			var start_day = $("#start-day").val();			
			var role_calculate = $("#role-calculate").val();			
			var role_allowed = $("#role-allowed").val();					
			//Validación de time_window
			if(time_window == "" || isNaN(time_window)){
				$("#error-time-window").show("slow");
				$("#time-window").focus();
				return false;
			}

			//Validación de start_day
			else if(start_day == ""){
				$("#error-start-day").show("slow");
				$("#start-day").focus();
				return false;
			}

			//Validación role_calculate
			else if(role_calculate == ""){				
				$("#error-role-calculate").show("slow");
				$("#role-calculate").focus();
				return false;
			}

			//Validación
			else if(role_allowed == ""){
				$("#error-role-allowed").show("slow");
				$("#role-allowed").focus();
				return false;
			}
			else{
				$("#form-insumes").submit();
			}
		});
	});

	//Función que genera dinámicamnte el contenido del select múltiple role_allowed
	$(function(){
		$("#role-calculate").change(function(){
			$("#role-allowed").html("");
			var opciones = $("#role-calculate").val();
			var opcionestexto = $("#role-calculate option:selected" ).text();
			var opcionesplit = opcionestexto.split(" ");
			for(i=0; i < opciones.length; i ++){
				$("#role-allowed").append(new Option(opcionesplit[i], opciones[i], false, false));
			}
		});
	});

	$(function(){
		$('.datepicker').datepicker({
			autoclose: true,
       		todayHighlight: true,
       		format: 'dd-mm-yyyy'
		});
     });

});
