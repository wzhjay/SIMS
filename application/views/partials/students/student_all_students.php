<head>
	<meta charset="utf-8">

	<script>
		var selected_stundet_delete_id = 0;
		$(document).ready(function($) {
		    $('#input_student_search_all_students_search1').on('click', function() {
				all_students_search_student_by_name_ic();
			});

			$('#input_student_search_all_students_search2').on('click', function() {
				search_student_by_multiple_var();
			});

			$('#input_student_search_all_students_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_student_search_all_students_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});
		});

		function all_students_search_student_by_name_ic() {
			var keyword = $('#input_student_search_all_students_ic_name').val();
			var target = $('#student_all_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
				url:window.api_url + "searchStudentInfoByKeyword",
				data:{keyword:keyword},
				success:function(json){
					target.empty();
					target.append('<h4>No Students Found.</h4><hr>');
					if(json != null) {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.empty();
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="student_info_record_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-10">' +
																'<a data-toggle="collapse" data-parent="student_info_record_collapse_'+key+'" href="#student_info_record_collapse_body_'+key+'">Student Record ' + num + '  /  IC: <b>' + reply[key].ic + '</b>  /  Name: <b>' + reply[key].othername + '</b>  /  Tel: <b>' + reply[key].tel + '</b>/  Branch: <b>' + reply[key].name + '</b></a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="search_all_students_delete_'+reply[key].student_id+'" data-toggle="modal" data-target="#student-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													' </h4>' +
												'</div>' +
												'<div id="student_info_record_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-4">'+ 
																'<div>IC: ' + reply[key].ic + '</div>' +
															'</div>' + 
															'<div class="col-xs-4">' +
																'<div>Name: ' + reply[key].othername +'</div>' + 
															'</div>' +
															'<div class="col-xs-4">' +
																'<div>Tel: '+ reply[key].tel + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Registration Date: ' + reply[key].reg_date + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Registration Number: ' + reply[key].reg_no +'</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Tel Home: '+ reply[key].tel_home + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Source: '+ reply[key].source + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Created: ' + reply[key].created + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Modified: ' + reply[key].modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Remark: '+ reply[key].student_remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}

								$('#student_all_search_results .button').on('click', function() {
					 				var el_id = $(this).attr('id').split('_');
					 				var student_id = el_id[4];
					 				if(el_id[3] == "delete") {
					 					// delete student
					 					selected_stundet_delete_id = student_id;
					 					var modalBody = $('#student_delete_modal_label').closest('.modal-content').find('.modal-body');
										modalBody.empty();
										modalBody.append(
											'<div class="row">' + 
												'<div class="col-xs-10">'+
													'<label>Sure you want to delete this Student record?</label><br>' +
													'<label>确定你要删除这条学生记录？</label>' +
												'</div>' +	
											'</div>'
										);
					 					$('#search_student_delete_confirm').on('click', function() {
											delete_student_info_by_id(student_id);
										});
					 				}
					 			});
							}
						} else {
							target.append('<p>No Student Records found</p><br>');
						}
					}
				}
			});//End ajax
		}

		function search_student_by_multiple_var() {
 			var course_type = $('#input_student_search_all_students_search_course_type').val();
 			var level = $('#input_student_search_all_students_student_level').val();
 			var slot = $('#input_student_search_all_students_class_time').val();
 			var from = '0000-00-00';
			var to  = '2100-01-01';
			if($('#input_student_search_all_students_from').val().trim() != "") {
				from = $('#input_student_search_all_students_from').val();
			}
			if($('#input_student_search_all_students_to').val().trim() != "") {
				to = $('#input_student_search_all_students_to').val();
			}
 			var have_class = $('#input_student_search_all_have_class').is(':checked') ? 'YES' : 'NO';

 			var target = $('#student_all_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchStudentInfoByMultipleVar",
			    data:{course_type:course_type, level:level, slot:slot, from:from, to:to, have_class:have_class},
			    success:function(json){
			    	target.empty();
			    	target.append('<h4>No Students Found.</h4><hr>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
				            		target.append(
										'<div class="panel-group" id="student_info_record_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-10">' +
																'<a data-toggle="collapse" data-parent="student_info_record_collapse_'+key+'" href="#student_info_record_collapse_body_'+key+'">Student Record ' + num + '  /  IC: <b>' + reply[key].ic + '</b>  /  Name: <b>' + reply[key].othername + '</b>  /  Tel: <b>' + reply[key].tel + '</b>/  Branch: <b>' + reply[key].name + '</b></a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="search_all_students_delete_'+reply[key].student_id+'" data-toggle="modal" data-target="#student-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													' </h4>' +
												'</div>' +
												'<div id="student_info_record_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Registration Date: ' + reply[key].reg_date + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Registration Number: ' + reply[key].reg_no +'</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Tel Home: '+ reply[key].tel_home + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Source: '+ reply[key].source + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Created: ' + reply[key].created + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Modified: ' + reply[key].modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Remark: '+ reply[key].student_remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
				            	}

				            	$('#student_all_search_results .button').on('click', function() {
					 				var el_id = $(this).attr('id').split('_');
					 				var student_id = el_id[4];
					 				if(el_id[3] == "delete") {
					 					// delete student
					 					selected_stundet_delete_id = student_id;
					 					var modalBody = $('#student_delete_modal_label').closest('.modal-content').find('.modal-body');
										modalBody.empty();
										modalBody.append(
											'<div class="row">' + 
												'<div class="col-xs-10">'+
													'<label>Sure you want to delete this Student record?</label><br>' +
													'<label>确定你要删除这条学生记录？</label>' +
												'</div>' +	
											'</div>'
										);
					 					$('#search_student_delete_confirm').on('click', function() {
											delete_student_info_by_id(student_id);
										});
					 				}
					 			});
				            }
			        	}  else {
							target.append('<p>No Student Records found</p><br>');
						}
			        }
			    },
			});//End ajax
		}

		function delete_student_info_by_id(student_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteStudentInfoByID",
			    data:{student_id:student_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    
					    // clear deleted element
					    $('#search_all_students_delete_' + student_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to delete student info!");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<ul id="class_search_students_tabs" class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#student_search_all_students_tab1" role="tab" data-toggle="tab">精确查找</a></li>
      <li class=""><a href="#student_search_all_students_tab2" role="tab" data-toggle="tab">Group模糊查找</a></li>
    </ul>
    <div id="class_search_students_tabs_content" class="tab-content">
      <div class="tab-pane fade active in" id="student_search_all_students_tab1">
      	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchStudentInfoDownload1" method="POST" target="_blank"><form action="<?php echo $this->config->base_url(); ?>index.php/api/searchStudentInfoDownload1" method="POST" target="_blank">
	        <div class="row">
				<div class="col-xs-4">
					<label for="input_student_search_all_students_ic_name">请输入学员IC/名字/HP</label>
					<input name="keyword" class="form-control" id="input_student_search_all_students_ic_name" placeholder="IC Number/Name/HP">
				</div>
				<div class="col-xs-4"></div>
				<div class="col-xs-2">
					<br>
					<a class="button glow button-rounded button-flat" id="input_student_search_all_students_search1">Search</a>
				</div>
				<div class="col-xs-2">
					<br>
					<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="input_student_search_all_students_excel1">
				</div>
			</div>
		</form>
      </div>
      <div class="tab-pane fade" id="student_search_all_students_tab2">
	    <form action="<?php echo $this->config->base_url(); ?>index.php/api/searchStudentInfoDownload2" method="POST" target="_blank">
		    <div class="row">
				<div class="input-daterange">
					<div class="col-xs-4">
						<label>注册时间 From</label>
						<input name="from" class="form-control" id="input_student_search_all_students_from" placeholder="From">
					</div>
					<div class="col-xs-4">
						<label>注册时间 To</label>
						<input name="to" class="form-control" id="input_student_search_all_students_to" placeholder="To">
					</div>
					<div class="col-xs-4">
						<div class="checkbox">
						    <label for="input_student_search_all_have_class">
						    	<input name="have_class" type="checkbox" id="input_student_search_all_have_class" value="YES"> 有班级
						    </label>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
					<div class="col-xs-3">
					<label for="input_student_search_all_students_course_type">Course Type</label>
					<select name="course_type" class="form-control" id="input_student_search_all_students_search_course_type">
						<option value="NA">请选择</option>
						<option id="input_student_search_all_students_course_type_1" value="cmp">英文综合</option>
						<option id="input_student_search_all_students_course_type_2" value="con">英文会话</option>
						<option id="input_student_search_all_students_course_type_3" value="wri">英文写作</option>
						<option id="input_student_search_all_students_course_type_3" value="wpn">数学</option>
					</select>
				</div>
				<div class="col-xs-3">
					<label for="input_student_search_all_students_student_level">水平等级</label>
					<select name="level" class="form-control" id="input_student_search_all_students_student_level">
						<option value="NA">请选择</option>
						<option value="BEGINNERS">初级</option>
	                	<option value="INTERMEDIATE">中级</option>
	                	<option value="ADVANCED">高级</option>
					</select>
				</div>
				<div class="col-xs-3">
					<label for="input_student_search_all_students_class_time">想上课时间</label>
					<select name="slot" class="form-control" id="input_student_search_all_students_class_time">
						<option value="NA">请选择</option>
						<option value="any_am">平时早上</option>
	                	<option value="any_pm">平时下午</option>
	                	<option value="any_eve">平时晚上</option>
	                	<option value="sat_am">周六早上</option>
	                	<option value="sat_pm">周六下午</option>
	                	<option value="sat_eve">周六晚上</option>
	                	<option value="sun_am">周日早上</option>
	                	<option value="sun_pm">周日下午</option>
	                	<option value="sun_eve">周日晚上</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-8"></div>
				<div class="col-xs-2">
					<br>
					<a class="button glow button-rounded button-flat" id="input_student_search_all_students_search2">Search</a>
				</div>
				<div class="col-xs-2">
					<br>
					<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="input_student_search_all_students_excel2">
				</div>
			</div>
		</form>
      </div>
    </div>
    <br>
	<div id="student_all_search_results"></div>
</div>

<!-- Class delete Modal -->
<div class="modal fade" id="student-delete-modal" tabindex="-1" role="dialog" aria-labelledby="student_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_delete_modal_label">Delete Studnet</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="search_student_delete_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>