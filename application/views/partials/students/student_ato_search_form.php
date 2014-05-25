<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_student_ato_search_from').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_student_ato_search_to').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#student_ato_search_submit2').on('click', function() {
				student_search_ato_info();
			});
		});

		function student_search_ato_info() {
			var from = '2000-01-01';
			var to  = '2100-01-01';
			if($('#input_student_ato_search_from').val().trim() != "") {
				from = $('#input_student_ato_search_from').val();
			}
			if($('#input_student_ato_search_to').val().trim() != "") {
				to = $('#input_student_ato_search_to').val();
			}
			var target = $('#ato_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchATOInfo",
			    data:{from:from, to:to},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No ATO info found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
				    				// target.append(JSON.stringify(reply[key]));
				            		target.append(
										'<div class="panel-group" id="ato_search_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="ato_search_collapse_'+key+'" href="#ato_search_collapse_body_'+key+'">Search ATO ' + num + '</a>' + 
													' </h4>' +
												'</div>' +
												'<div id="ato_search_collapse_body_'+key+'" class="panel-collapse collapse in">' + 
												'<div class="panel-body">' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>IC Number: ' + reply[key].ic + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">'+ 
															'<div>Name: ' + reply[key].salutation + ' ' + reply[key].firstname + ' ' + reply[key].lastname +'</div>' +
														'</div>' + 
													'</div>' +
													'<hr>' +  
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Exam Type: ' + reply[key].pre_post + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Class Start Date ' + reply[key].class_start_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Class End Date: '+ reply[key].class_end_date + '</div>' + 
														'</div>' +
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-4">' +
															'<div>Class Code: '+ reply[key].class_code + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Attendance: '+ reply[key].attendance + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">'+ 
															'<div>Recommend Level: ' + reply[key].recommend_level + '</div>' +
														'</div>' + 
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-2">' +
															'<div>El: ' + reply[key].el +'</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>ER: ' + reply[key].er +'</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>EN: '+ reply[key].en + '</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>ES: '+ reply[key].es + '</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>EW: '+ reply[key].ew + '</div>' + 
														'</div>' +
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-2">'+ 
															'<div>Exam Location: ' + reply[key].exam_location + '</div>' +
														'</div>' + 
														'<div class="col-xs-2">' +
															'<div>Exam Time: ' + reply[key].exam_time +'</div>' + 
														'</div>' +
													'</div>' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>Created: ' + reply[key].created + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Modified: ' + reply[key].modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-6">' +
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
	<div class="row">
		<form role="form">
			<div id="student_ato_search">
				<div class="input-daterange" id="student_ato_datepicker">
					<div class="col-xs-4">
						<input class="form-control" id="input_student_ato_search_from" placeholder="From">
					</div>
					<div class="col-xs-4">
						<input class="form-control" id="input_student_ato_search_to" placeholder="To">
					</div>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_ato_search_submit2">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_ato_to_excel2">To Excel</a>
		</div>
	</div>
	<div id="ato_search_results">
	</div>
</div>