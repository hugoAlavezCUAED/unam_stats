$( document ).ready(function() {

for (i = 0; i < json_data.length; i++) {
	json_data[i].x = new Date(json_data[i].x * 1000);
}
console.log(json_data);

$("#chart").CanvasJSChart({ //Pass chart options
	zoomEnabled: true,
	panEnabled: true,		
	title: {
		text: "Tiempo en plataforma"             
        },
	axisY: {
		title: "Tiempo en segundos"
	},
	data: [
	{
		type: "area", //change it to column, spline, line, pie, etc
		dataPoints: json_data
	}
	]
	});
});