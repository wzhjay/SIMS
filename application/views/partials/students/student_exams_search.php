<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_student_exam_search_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_student_exam_search_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#student_exam_search_submit').on('click', function() {
				student_search_exam_info();
			});

			$('#exam_search_results').bind("DOMSubtreeModified",function() {
			   $('#exam_search_results .button').unbind().bind('click', function() {
	 				var el_id = $(this).attr('id').split('_');
	 				var exam_record_id = el_id[3];
	 				selected_record_id = exam_record_id;
	 				if(el_id[2] == "update") {
	 					// update exam record
	 					load_exam_record(exam_record_id);
	 				} else if(el_id[2] == "delete") {
	 					// delete exam record
	 					var modalBody = $('#exam_delete_modal_label').closest('.modal-content').find('.modal-body');
						modalBody.empty();
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-10">'+
									'<label>Sure you want to delete this Exam record?</label><br>' +
									'<label>确定你要删除这条Exam记录？</label>' +
								'</div>' +	
							'</div>'
						);
	 					$('#exam_del_confirm_btn').on('click', function() {
	 						delete_exam_by_id(exam_record_id);
	 					});
	 				}
	 			});
			});
		});

		function student_search_exam_info() {
			var from = '0000-00-00';
			var to  = '2100-01-01';
			if($('#input_student_exam_search_from').val().trim() != "") {
				from = $('#input_student_exam_search_from').val();
			}
			if($('#input_student_exam_search_to').val().trim() != "") {
				to = $('#input_student_exam_search_to').val();
			}
			var target = $('#exam_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchExamInfo",
			    data:{from:from, to:to},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No Exam info found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
				            		target.append(
										'<div class="panel-group" id="exam_search_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="exam_search_collapse_'+key+'" href="#exam_search_collapse_body_'+key+'">Search Exam ' + num + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Name: <b>' + reply[key].firstname + ' ' + reply[key].lastname + '</b>' + '  /  Exam Date: <b>' + reply[key].exam_date + '</b>' + '</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="exam_search_update_'+reply[key].id+'" >Update</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="exam_search_delete_'+reply[key].id+'" data-toggle="modal" data-target="#exam-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													' </h4>' +
												'</div>' +
												'<div id="exam_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' +  
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>IC: ' + reply[key].ic + '</div>' +
														'</div>' + 
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-2">' +
															'<div>El: ' + reply[key].el_best +'</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>ER: ' + reply[key].er_best +'</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>EN: '+ reply[key].en_best + '</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>ES: '+ reply[key].es_best + '</div>' + 
														'</div>' +
														'<div class="col-xs-2">' +
															'<div>EW: '+ reply[key].ew_best + '</div>' + 
														'</div>' +
													'</div>' + 
													'<div class="row">' + 
														'<div class="col-xs-3">' +
															'<div>CMP: ' + reply[key].cmp +'</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>CON: ' + reply[key].con +'</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>WRI: '+ reply[key].wri + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>WPN: '+ reply[key].wpn + '</div>' + 
														'</div>' +
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Created: ' + reply[key].exam_created + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Modified: ' + reply[key].exam_modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Remark: '+ reply[key].exam_remark + '</div>' + 
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


		function delete_exam_by_id(exam_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteExamRecordByID",
			    data:{id:exam_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    
					    // clear deleted element
					    $('#exam_search_delete_' + exam_record_id).closest('.panel-group').remove();
					}else{
						//toastr.error("Fail to delete Exam info!");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchExamInfoDownload" method="POST" target="_blank">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_search_from">Exam Time From</label>
				<input name="from" class="form-control" id="input_student_exam_search_from">
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_search_to">To</label>
				<input name="to" class="form-control" id="input_student_exam_search_to">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-8"></div>
			<div class="col-xs-2">
				<a class="button glow button-rounded button-flat" id="student_exam_search_submit">Search [前100]</a>
			</div>
			<div class="col-xs-2">
				<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="exam_search_to_excel">
			</div>
		</div>
	</form>
	<br>
	<div id="exam_search_results">
	</div>
</div>

<!-- exam delete Modal -->
<div class="modal fade" id="exam-delete-modal" tabindex="-1" role="dialog" aria-labelledby="exam_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="exam_delete_modal_label">Delete Exam Record</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="exam_del_confirm_btn">Confirm</button>
      </div>
    </div>
  </div>
</div>