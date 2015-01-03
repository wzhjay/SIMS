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
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_student_ato_search_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#student_ato_search_submit2').on('click', function() {
				student_search_ato_info();
			});
		});

		function student_search_ato_info() {
			var from = '0000-00-00';
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
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="ato_search_collapse_'+key+'" href="#ato_search_collapse_body_'+key+'">Search ATO ' + num + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Name: <b>' + reply[key].firstname + ' ' + reply[key].lastname + '</b>' + '  /  Exam Type: <b>' + reply[key].pre_post + '</b>' + '</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="ato_search_update_'+reply[key].id+'" >Update</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="ato_search_delete_'+reply[key].id+'" data-toggle="modal" data-target="#ato-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													' </h4>' +
												'</div>' +
												'<div id="ato_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' +  
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
														'<div class="col-xs-3">'+ 
															'<div>Exam Location: ' + reply[key].exam_location + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Exam Time: ' + reply[key].exam_time +'</div>' + 
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

				            $('#ato_search_results .button').on('click', function() {
				 				var el_id = $(this).attr('id').split('_');
				 				var ato_record_id = el_id[3];
				 				selected_ato_id = ato_record_id;
				 				if(el_id[2] == "update") {
				 					// update ato record
				 					load_ato_info(ato_record_id);
				 				} else if(el_id[2] == "delete") {
				 					// delete ato record
				 					var modalBody = $('#ato_delete_modal_label').closest('.modal-content').find('.modal-body');
									modalBody.empty();
									modalBody.append(
										'<div class="row">' + 
											'<div class="col-xs-10">'+
												'<label>Sure you want to delete this ATO record?</label><br>' +
												'<label>确定你要删除这条ATO记录？</label>' +
											'</div>' +	
										'</div>'
									);
				 					$('#ato_del_confirm_btn').on('click', function() {
				 						delete_ato_by_id(ato_record_id);
				 					});
				 				}
				 			});
			        	}
			        }
			    },
			});//End ajax
		}

		function delete_ato_by_id(ato_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteATOByID",
			    data:{id:ato_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    
					    // clear deleted element
					    $('#ato_search_delete_' + ato_record_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to delete ATO info!");
					}
			    }
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
	<br><br>
	<div id="ato_search_results">
	</div>
</div>

<!-- ato delete Modal -->
<div class="modal fade" id="ato-delete-modal" tabindex="-1" role="dialog" aria-labelledby="ato_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ato_delete_modal_label">Delete ATO Record</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="ato_del_confirm_btn">Confirm</button>
      </div>
    </div>
  </div>
</div>