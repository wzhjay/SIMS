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

			$('#student_ato_search_submit3').on('click', function() {
				student_search_ato_ic_info();
			});

			$('#ato_search_results').bind("DOMSubtreeModified",function() {
			   $('#ato_search_results .button').unbind().bind('click', function() {
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
			});

			$('#student_ato_search_delete_all').on('click', function() {
				// delete ato record
				var modalBody = $('#ato_delete_all_modal_label').closest('.modal-content').find('.modal-body');
				modalBody.empty();
				modalBody.append(
					'<div class="row">' + 
						'<div class="col-xs-10">'+
							'<label>Sure you want to delete all searched ATO records?</label><br>' +
							'<label>确定你要删除所有ATO搜索记录？</label>' +
						'</div>' +	
					'</div>'
				);
				$('#ato_del_all_confirm_btn').on('click', function() {
					ato_del_all_searched();
				});
			});
		});

		function ato_del_all_searched() {
			var el_ids = $('#ato_search_results').find('.panel-title .row .col-xs-2:nth-child(3) a');
			$.each(el_ids, function(i, e) {
				var el_id = $(e).attr('id').split('_');
				var ato_record_id = el_id[3];
				delete_ato_by_id(ato_record_id);
			});			
		}

		function student_search_ato_info() {
			var class_code = $('#input_student_ato_search_class_code').val().trim();
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
			    data:{from:from, to:to, class_code:class_code},
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
																'<a data-toggle="collapse" data-parent="ato_search_collapse_'+key+'" href="#ato_search_collapse_body_'+key+'">Search ATO ' + num + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Name: <b>' + reply[key].othername + '</b>' + '  /  Exam Type: <b>' + reply[key].pre_post + '</b>' + '</a>' + 
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
															'<div>IC: ' + reply[key].ic + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Class Code: '+ reply[key].class_code + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Attendance: '+ reply[key].attendance + '</div>' + 
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
														'<div class="col-xs-4">'+ 
															'<div>Exam Location: ' + reply[key].exam_location + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">'+ 
															'<div>Exam Datetime: ' + reply[key].exam_date + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Exam Time: ' + reply[key].exam_time +'</div>' + 
														'</div>' +
													'</div>' + 
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Created: ' + reply[key].ato_created + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Modified: ' + reply[key].ato_modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Remark: '+ reply[key].ato_remark + '</div>' + 
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

		function student_search_ato_ic_info() {
			var ic  = $('#input_ato_student_search_ic').val().trim();
			var target = $('#ato_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentATOInfoByIC",
			    data:{ic:ic},
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
																'<a data-toggle="collapse" data-parent="ato_search_collapse_'+key+'" href="#ato_search_collapse_body_'+key+'">Search ATO ' + num + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Name: <b>' + reply[key].othername + '</b>' + '  /  Exam Type: <b>' + reply[key].pre_post + '</b>' + '</a>' + 
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
															'<div>IC: ' + reply[key].ic + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Class Code: '+ reply[key].class_code + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Attendance: '+ reply[key].attendance + '</div>' + 
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
														'<div class="col-xs-4">'+ 
															'<div>Exam Location: ' + reply[key].exam_location + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">'+ 
															'<div>Exam Datetime: ' + reply[key].exam_date + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Exam Time: ' + reply[key].exam_time +'</div>' + 
														'</div>' +
													'</div>' + 
													'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Created: ' + reply[key].ato_created + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Modified: ' + reply[key].ato_modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Remark: '+ reply[key].ato_remark + '</div>' + 
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
						toastr.error("Fail to delete ATO info! Might due to 7 days closed to exam date for PRE ATO.");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<ul id="class_search_students_tabs" class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#ato_search_tab1" role="tab" data-toggle="tab">时间班级模糊查找</a></li>
      <li class=""><a href="#ato_search_tab2" role="tab" data-toggle="tab">IC查找</a></li>
      <div id="ato_tabs_content" class="tab-content">
      <div class="tab-pane fade active in" id="ato_search_tab1">
      	<br>
      	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchATOInfoDownload" method="POST" target="_blank">
			<div class="row">
				<div class="col-xs-4">
					<label for="input_student_ato_search_from">From</label>
					<input name="from" class="form-control" id="input_student_ato_search_from">
				</div>
				<div class="col-xs-4">
					<label for="input_student_ato_search_to">To</label>
					<input name="to" class="form-control" id="input_student_ato_search_to">
				</div>
				<div class="col-xs-4">
					<label for="input_student_ato_search_class_code">Class Code</label>
					<input name="class_code" class="form-control" id="input_student_ato_search_class_code">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6"></div>
				<div class="col-xs-2">
					<a class="button glow button-rounded button-flat" id="student_ato_search_delete_all" data-toggle="modal" data-target="#ato-delete-all-modal">Delete All</a>
				</div>
				<div class="col-xs-2">
					<a class="button glow button-rounded button-flat" id="student_ato_search_submit2">Search [前100]</a>
				</div>
				<div class="col-xs-2">
					<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="ato_search_to_excel">
				</div>
			</div>
		</form>
      </div>
      <div class="tab-pane fade" id="ato_search_tab2">
      	<br>
      	<div id="ato_student_ic_search">
	      	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchATOByICInfoDownload" method="POST" target="_blank">
				<div class="col-xs-2">
					<label for="input_ato_student_search_ic">请输入学员IC：</label>
				</div>
				<div class="col-xs-4">
					<input name="ic" class="form-control" id="input_ato_student_search_ic">
				</div>
				<div class="col-xs-2"></div>
				</div>
				<div class="col-xs-2">
					<a class="button glow button-rounded button-flat" id="student_ato_search_submit3">Search</a>
				</div>
				<div class="col-xs-2">
					<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="ato_search_to_excel2">
				</div>
			</form>
      	</div>
    </ul>
	<br>
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

<!-- ato delete all Modal -->
<div class="modal fade" id="ato-delete-all-modal" tabindex="-1" role="dialog" aria-labelledby="ato_delete_all_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ato_delete_all_modal_label">Delete ATO Record</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="ato_del_all_confirm_btn">Confirm</button>
      </div>
    </div>
  </div>
</div>