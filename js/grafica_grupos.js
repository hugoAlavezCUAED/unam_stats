var groups = [];
var colors = ['#C10087','#B1F100','#34D800','#E038AD','#E065BB'];
var grouplist ="";

$( document ).ready(function() {

	dibujaChart(parent.obj_json);
});


function dibujaChart(obj_json){
	var i = 0,
	    s,
	    L = 200,
	    N = -1,
	    max_posts = 0,
	    desplaza = 0;
	    elements = {
	      nodes: [],
	      edges: []
	    };
	var userid = parseInt(obj_json.user.id);

	console.log("dibujaChart_2_2");
	console.log(obj_json);


	for (var idusuario in obj_json.data) {
//		console.log(obj_json.data[idusuario]);
//		console.log(typeof(idusuario));
//		console.log(userid);
		N++;

		var total_posts = parseInt(obj_json.data[idusuario].total_posts);
		if(total_posts > max_posts)
			max_posts = total_posts;

		if(parseInt(userid) == idusuario) //si existen autoenvíos
			i++;
		
		if($.inArray(obj_json.data[idusuario].groupid,groups) == -1){
			if(obj_json.data[idusuario].groupid > 0){
				grouplist += '<li style="color:'+ colors[i] +';">';
				groups.push(obj_json.data[idusuario].groupid);
				grouplist += obj_json.data[idusuario].groupname;
				grouplist += '</li>';
			}
			else{
				if($.inArray(obj_json.data[idusuario].courseid,groups) == -1){
					grouplist += '<li style="color:'+ colors[i] +';">';
					groups.push(obj_json.data[idusuario].courseid);
					grouplist += obj_json.data[idusuario].course_name;
					grouplist += '</li>';
				}
			}
			
		}

	}


    	$("#result").html("");
	$('#graph-control').html('<ul>'+grouplist+'</ul>');

	if (i < 1){ //cuando no existen autoenvíos se debe agregar el nodo manualmente
		this_color = '#000';
		var msj = '';
		var this_img ="../user/pix.php/"+userid+"/"+obj_json.user.picture+".jpg";

		//agrego el nodo
		elements.nodes.push({
			data:
 			{ 
				id: userid,
				NodeType : this_group,
				nombre: obj_json.user.firstname +' ' + obj_json.user.lastname,
				color: this_color,
				img: this_img				
			},

			position: { // the model position of the node (optional on init, mandatory after)
				x: 0,
				y: 0
      			}

		});
/*
		//agrego la arista
		elements.edges.push({
			data:
 			{ 
				source: userid, 
				target:this_userid,
				id: userid+'_'+this_userid, 
				label: msj,
				color: this_color 
			}, 
			classes: 'autorotate'
		});*/
		N++;
	}


	for (var idusuario in obj_json.data) {
		var this_userid = parseInt(idusuario);
		var msj = '';
		var this_img ="../user/pix.php/"+this_userid+"/"+obj_json.data[idusuario].picture+".jpg";
		var total_posts = parseInt(obj_json.data[idusuario].total_posts);
		var l = ((max_posts - total_posts)/max_posts)* L * 2;
		var this_x = (L + l) * Math.cos(Math.PI * 2 * i / N - Math.PI / 2);
		var this_y = (L + l) * Math.sin(Math.PI * 2 * i / N - Math.PI / 2);
		var this_group = obj_json.data[idusuario].groupid;
		if(this_group == '-1')
			this_group = obj_json.data[idusuario].courseid;

		var this_color = colors[$.inArray(this_group,groups)];


		if (userid == this_userid){
			//msj = total_posts  + " autoenvios";
			this_x = 0;
			this_y = 0;
			this_color = '#000';
		}else{
			msj = total_posts  + " posts";
			i++;

		}

		//agrego el nodo
		elements.nodes.push({
			data:
 			{ 
				id: this_userid,
				NodeType : this_group,
				nombre: obj_json.data[idusuario].firstname +' ' + obj_json.data[idusuario].lastname,
				courseid: obj_json.data[idusuario].courseid,
				color: this_color,
				img: this_img				
			},

			position: { // the model position of the node (optional on init, mandatory after)
				x: this_x,
				y: this_y
      			}

		});

		//agrego la arista
		elements.edges.push({
			data:
 			{ 
				source: userid, 
				target:this_userid,
				id: userid+'_'+this_userid, 
				label: msj,
				color: this_color 
			}, 
			classes: 'autorotate'
		});	
	}
	//console.log(elements);

	var cy = cytoscape({

		container: document.getElementById('graph-container'), // container to render in

		elements: elements,

		style: [ // the stylesheet for the graph
			{
				selector: 'node',
				style: {
					'background-color': 'data(color)',
					'label': 'data(nombre)',
					'background-image': 'data(img)',
					'background-fit': 'cover',
					'border-color': 'data(color)',
					'border-width': 3,
					'border-opacity': 0.5	

				}
			},
			{
				selector: 'edge',
				style: {
					'width': 3,
					'line-color': 'data(color)',
					'target-arrow-color': 'data(color)',
					'target-arrow-shape': 'triangle',
					'label': 'data(label)',
				        'curve-style': 'bezier'

				}

			},
			{
				selector: '.autorotate',
				style: {
					'edge-text-rotation': 'autorotate'
				}
			}
		],

		layout: {
			name: 'preset', 
			padding: 10
		}
	});


	cy.on('click', 'node', function(evt){
		var this_data =this.data();
		var url = "../user/view.php?id="+ this_data.id + "&course=" + this_data.courseid;
		window.open(url, "perfil");

	});

}

