 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();

			load_all_classes();
		});

		function load_all_classes() {
			var target = $('#class_all');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllClassInfo",
			    data:{},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No class info</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
				            		target.append(
										'<div class="panel-group" id="class_all_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="class_all_collapse_'+key+'" href="#class_all_collapse_body_'+key+'">Class ' + num + '  /  Class Name: <b>' + reply[key].class_name + '</b>  /  Code: <b>' + reply[key].code + '</b>  /  Course: <b>' + reply[key].type + '</b>  /  Status: <b>' + reply[key].status + '</b> /  Branch: <b>' + reply[key].name + '</b></a>' + 
													' </h4>' +
												'</div>' +
												'<div id="class_all_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>Type: ' + reply[key].type + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Level ' + reply[key].level + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>Location ' + reply[key].location + '</div>' + 
														'</div>' +
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-3">' +
															'<div>Start Date: '+ reply[key].start_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>End Date: '+ reply[key].end_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">'+ 
															'<div>Start Time: ' + reply[key].start_time + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">'+ 
															'<div>End Time: ' + reply[key].end_time + '</div>' +
														'</div>' + 
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Teacher: ' + reply[key].teacher_name + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															"<div>Teacher's Tel: " + reply[key].teacher_tel +'</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															"<div>Branch: " + reply[key].name +'</div>' + 
														'</div>' +
													'</div>' + 
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Created: ' + reply[key].created + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Modified: ' + reply[key].modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Remark: '+ reply[key].remark + '</div>' + 
														'</div>' +
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<div id="class_all"></div>
</div>