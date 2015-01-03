 <head>
	<meta charset="utf-8">

	<script>
		var selected_class_id = 0;
		var selected_class_name = "";
		var selected_remove_student_id = 0;
		$(document).ready(function($) {
			event.preventDefault();

			$('#input_class_search_start_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_search_start_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_search_end_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_search_end_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_search_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_search_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

 			$('#class_info_search_submit').on('click', function() {
 				search_class_info_by_types();
 			});

 			class_search_load_branches();

 			$('#input_class_search_class_student_management_student_search').on('click', function() {
 				search_student_by_ic_name();
 			});

 			$('#input_class_search_class_student_management_student_search2').on('click', function() {
 				search_student_by_multiple_var();
 			});

 			class_search_load_type();

 			$('#remove_student_confirm').on('click', function() {
 				remove_student_from_class(selected_remove_student_id, selected_class_id);
 			});

 			$('#class_search_class_student_management_middle_section .btn').on('click', function() {
				$.each($('#class_search_student_search_results option:selected'), function() {
					var student_id = $(this).attr('id').split('_')[3];
					assign_student_to_class(student_id);
				});
			});
		});

 		function remove_student_from_class(selected_remove_student_id, selected_class_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "removeStudentFromClassByID",
			    data:{student_id:selected_remove_student_id, class_id:selected_class_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Remove success!");
					    
					    // clear deleted element
					    $('#class_students_student_' + selected_remove_student_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to remove student!");
					}
			    }
			});//End ajax	
 		}

		function class_search_load_type() {
			var types = $('#input_class_search_type');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllCourses",
			    data:{},
			    success:function(json){
			    	types.empty();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		types.append('<option value="NA">请选择</option>');
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				types.append('<option id="search_course_type_'+ reply[key].id +'" + value="'+ reply[key].code +'">' + reply[key].type + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load courses!");
			        }
			    },
			});//End ajax
		}

		function class_search_load_branches() {
			var branches = $('#input_class_search_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	branches.append('<option id="class_search_branch_ALL">ALL</option>');
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="class_search_branch_'+ reply[key].id +'" value="reply[key].id">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load braches!");
			        }
			    }
			});//End ajax
		}

 		function search_class_info_by_types() {
 			var code = $('#input_class_search_code').val();;
 			var type = $('#input_class_search_type option:selected').val();
 			var level = $('#input_class_search_level option:selected').val();
 			var status = $('#input_class_search_status option:selected').val();
 			var branch = $('#input_class_search_branch option:selected').attr('id').split('_');
 			var branch_id = branch[3];

 			var start_from = '0000-00-00';
			var start_to  = '2100-01-01';
			var end_from = '0000-00-00';
			var end_to = '2100-01-01';
			
			if($('#input_class_search_start_from').val().trim() != "") {
				start_from = $('#input_class_search_start_from').val();
			}

			if($('#input_class_search_start_to').val().trim() != "") {
				start_to = $('#input_class_search_start_to').val();
			}

			if($('#input_class_search_end_from').val().trim() != "") {
				end_from = $('#input_class_search_end_from').val();
			}

			if($('#input_class_search_end_to').val().trim() != "") {
				end_to = $('#input_class_search_end_to').val();
			}

			var target = $('#class_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchClassInfo",
			    data:{code:code, type:type, level:level, status:status, branch_id:branch_id, start_from:start_from, start_to:start_to, end_from:end_from, end_to:end_to},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No class info found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
				            		// target.append(JSON.stringify(reply[key]));
				            		target.append(
										'<div class="panel-group" id="class_search_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="class_search_collapse_'+key+'" href="#class_search_collapse_body_'+key+'">Class Name: <b>' + reply[key].class_name + '</b>  /  Code: <b>' + reply[key].code + '</b>  /  Course: <b>' + reply[key].type + '</b>  /  Status: <b>' + reply[key].status + '</b></a>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="class_search_student_management_'+reply[key].class_id+'" data-toggle="modal" data-target="#class-student-management-modal">Manage</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="class_search_class_delete_'+reply[key].class_id+'" data-toggle="modal" data-target="#class-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													'</h4>' +
												'</div>' +
												'<div id="class_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
													'<div class="row">' + 
														'<div class="col-xs-6">'+ 
															'<div>Name: ' + reply[key].class_name + '</div>' +
														'</div>' + 
														'<div class="col-xs-6">'+ 
															'<div>Code: ' + reply[key].code + '</div>' +
														'</div>' + 
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>Type: ' + reply[key].type + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Level: ' + reply[key].level + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>Location: ' + reply[key].location + '</div>' + 
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

				            	$('#class_search_results .button').on('click', function() {
					 				var el_id = $(this).attr('id').split('_');
					 				var class_id = el_id[4];
					 				selected_class_id = class_id;
					 				selected_class_name = $(this).closest('.row').find('.col-xs-8').find( "b:first-child" ).text();
					 				if(el_id[3] == "management") {
					 					// menegement class student
					 					load_class_students(class_id);
					 				} else if(el_id[3] == "delete") {
					 					// delete class
					 					get_class_student_by_id(class_id);

					 					$('#class_del_confirm_btn').on('click', function() {
					 						delete_class_by_id(class_id);
					 					});
					 				}
					 			});
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function delete_class_by_id(class_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "deleteClassByID",
			    data:{id:class_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    
					    // clear deleted element
					    $('#class_search_class_delete_' + class_id).closest('.panel-group').remove();
					}else{
						//toastr.error("Fail to delete ATO info!");
					}
			    }
			});//End ajax
 		}

 		function load_class_students(class_id) {
 			var target = $('#class_all_students_list');
 			target.empty();
			target.append('<div class="loading"></div>');
			$('#class_id_to_excel').val(class_id);
			$('#class_name_to_excel').val(selected_class_name);
			$.ajax({
				type:"post",
			    url:window.api_url + "getClassStudentsByClassID",
			    data:{class_id:class_id},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No Student Found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			var num = parseInt(key) + 1;
				    			if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="class_all_student_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h6 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="class_all_student_collapse_'+key+'" href="#class_all_student_collapse_body_'+key+'">Student ' + num + '  / Name: <b>' + reply[key].othername + '</b>  /  IC: <b>' + reply[key].ic + '</b>  /  Tel: <b>' + reply[key].tel + '</b></a><button id="class_students_student_' + reply[key].student_id + '" style="float:right;padding:3px;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#student-delete-modal">Delete</button>' + 
													' </h6>' +
												'</div>' +
												'<div id="class_all_student_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);

									$(document).ready(function() {
										// get student's exam records by student ic	
					    				var target2 = $('#class_all_student_collapse_body_' + key + ' .panel-body');
						    			$.ajax({
											type:"post",
										    url:window.api_url + "getStudentRecordsByIC",
										    data:{ic:reply[key].ic},
										    success:function(json2){
										    	if(json2.trim() != "") {
										    		var reply2 = $.parseJSON(json2);
										    		if(reply2.length > 0) {
											    		for (var key2 in reply2) {
											    			var num2 = parseInt(key2) + 1;
											    			if (reply2.hasOwnProperty(key2)) {
											            		target2.append(
											            			'<div class="row">' + 
												            			'<div class="col-xs-6">'+ 
												            				'<b>Exam Record ' + num2 + '</b>' +
												            			'</div>' + 
											            			'</div>' + 
											            			'<div class="row">' + 
																		'<div class="col-xs-6">'+ 
																			'<div>Exam Date: ' + reply2[key2].exam_date + '</div>' +
																		'</div>' + 
																		'<div class="col-xs-6">'+ 
																			'<div>Remark: '+ reply2[key2].exam_remark + '</div>' + 
																		'</div>' +
																	'</div>' + 
																	'<div class="row">' + 
																		'<div class="col-xs-12">'+ 
																			'<div>EL:' + reply2[key2].el_best + '    ER:' + reply2[key2].er_best + '    EN:' + reply2[key2].en_best + '    ES:' + reply2[key2].es_best + '    EW:' + reply2[key2].ew_best + '</div>' +
																		'</div>' + 
																	'</div>' + 
																	'<hr>'
																);
											            	}
											            }
										        	}
										        }
										    }
										});//End ajax
									});
					            }
				            }

				            $('#class_all_students_list .btn').on('click', function() {
				 				var el_id = $(this).attr('id').split('_');
				 				var student_id = el_id[3];
				 				selected_remove_student_id = student_id;
				 			});
			        	}
			        }
			    },
			});//End ajax
 		}

 		function get_class_student_by_id(class_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "getClassInfoByID",
			    data:{class_id:class_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		var modalBody = $('#class_delete_modal_label').closest('.modal-content').find('.modal-body');
				 					modalBody.empty();
				 					modalBody.append(
				 						'<div class="row">'+
								      		'<div class="col-xs-8">' +
								      			'<div class="highlight">'+
									      			'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Name: ' + reply[key].class_name + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Code: ' + reply[key].code + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Status: ' + reply[key].status + '</div>' + 
														'</div>' +
													'</div>' +
									      			'<div class="row">' + 
														'<div class="col-xs-4">'+ 
															'<div>Type: ' + reply[key].type + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' +
															'<div>Level: ' + reply[key].level + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>Location: ' + reply[key].location + '</div>' + 
														'</div>' +
													'</div>' +
												'</div>' +
								      		'</div>' +
								      		'<div class="col-xs-4">' +
								      			'<H4>Sure you want to delete this class?</h4>' +
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

 		function search_student_by_ic_name() {
 			var keyword = $('#input_class_search_class_student_management_ic_name').val();
 			var target = $('#class_search_student_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchStudentInfoByKeyword",
			    data:{keyword:keyword},
			    success:function(json){
			    	target.empty();
			    	target.append('<option class="list-group-item">No Student Found</option>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		// target.append(JSON.stringify(reply[key]));
				            		target.append(
				            			'<option id="searched_student_id_'+reply[key].student_id+'">' + reply[key].othername + ', IC: ' + reply[key].ic + ', Tel: ' + reply[key].tel + ', Reg No.: ' + reply[key].reg_no +'</option>'
									);
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function search_student_by_multiple_var() {
 			var course_type = $('#input_class_search_course_type').val();
 			var level = $('#input_class_search_student_level').val();
 			var slot = $('#input_class_search_class_time').val();

 			var from = '0000-00-00';
			var to  = '2100-01-01';
			if($('#input_class_search_from').val().trim() != "") {
				from = $('#input_class_search_from').val();
			}
			if($('#input_class_search_to').val().trim() != "") {
				to = $('#input_class_search_to').val();
			}
 			var have_class = $('#input_class_search_have_class').is(':checked') ? 'YES' : 'NO';

 			var target = $('#class_search_student_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchStudentInfoByMultipleVar",
			    data:{course_type:course_type, level:level, slot:slot, from:from, to:to, have_class:have_class},
			    success:function(json){
			    	target.empty();
			    	target.append('<option class="list-group-item">No Student Found</option>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		// target.append(JSON.stringify(reply[key]));
				            		target.append(
				            			'<option id="searched_student_id_'+reply[key].student_id+'">' + reply[key].othername + ', IC: ' + reply[key].ic + ', Tel: ' + reply[key].tel + ', Reg No.: ' + reply[key].reg_no +'</option>'
									);
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function assign_student_to_class(student_id) {
 			var class_id = selected_class_id;
 			$.ajax({
				type:"post",
			    url:window.api_url + "assignStudentToClass",
			    data:{class_id:class_id, student_id:student_id},
			    success:function(json){
			    	if(json.trim() != "") {
					    var reply = $.parseJSON(json);
					    if(reply == '1') {
					    	toastr.success("Assign student class success!");
					    	load_class_students(class_id);
					    }else{
					    	toastr.error("Student exist in this class. Fail to assign student to class!");
					    }
					}
					else {
						toastr.error("Fail to call api!");
					}
			    }
			});//End ajax
 		}
	</script>
</head>
<div class="highlight">
	<h4>输入查询信息</h4>
	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchClassInfoDownload" method="POST" target="_blank">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_class_search_code">Class Code(班级代码)</label>
				<input name='code' class="form-control" id="input_class_search_code">
			</div>
			<div class="col-xs-4">
				<label for="input_class_search_type">Class Type(课程类型)</label>
				<select name='type' class="form-control" id="input_class_search_type" ></select>
			</div>
			<div class="col-xs-4">
				<label for="input_class_search_type">Class Level(班级水平)</label>
				<select name='level' class="form-control" id="input_class_search_level">
			      	<option value="NA">请选择</option>
			     	<option value="BEGINNERS">初级</option>
			      	<option value="INTERMEDIATE">中级</option>
			      	<option value="ADVANCED">高级</option>
			      	<option value="LV1">LEVEL 1</option>
			      	<option value="LV3">LEVEL 3</option>
		    	</select>
		    </div>
		</div>
		<div class="row">
		    <div class="col-xs-4">
				<label for="input_class_search_status">Status(班级状态)</label>
				<select name='status' class="form-control" id="input_class_search_status" >
			      <option value="NA">请选择</option>
			      <option value="preparing">未开班</option>
			      <option value="learning">已开班</option>
			      <option value="waitexam">待考试</option>
			      <option value="finished">已结束</option>
			    </select>
			</div>
			<div class="col-xs-4">
				<label for="input_class_search_branch">Branch(分部 *操作员请选择ALL或者自己所在branch)</label>
				<select name='branch_id' class="form-control" id="input_class_search_branch" ></select>
			</div>
		</div>
		<label>Start Date(班级开始日期)</label>
		<div class="row">
			<div class="input-daterange">
				<div class="col-xs-4">
					<input name='start_from' class="form-control" id="input_class_search_start_from" placeholder="From">
				</div>
				<div class="col-xs-4">
					<input name='start_to' class="form-control" id="input_class_search_start_to" placeholder="To">
				</div>
			</div>
		</div>
		<label>End Date(班级结束日期)</label>
		<div class="row">
			<div class="input-daterange">
				<div class="col-xs-4">
					<input name='end_from' class="form-control" id="input_class_search_end_from" placeholder="From">
				</div>
				<div class="col-xs-4">
					<input name='end_to' class="form-control" id="input_class_search_end_to" placeholder="To">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-8"></div>
			<div class="col-xs-2">
				<a class="button glow button-rounded button-flat" id="class_info_search_submit">Search [前100]</a>
			</div>
			<div class="col-xs-2">
				<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="class_info_to_excel">
			</div>
		</div>
		<br><br>
	</form>
	<div id="class_search_results"></div>
</div>

<!-- Class student management Modal -->
<div class="modal fade" id="class-student-management-modal" tabindex="-1" role="dialog" aria-labelledby="class_student_management_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="class_student_management_modal_label">Class Student Management</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-6" id="class_search_class_student_management_search_section">
      			<div class="highlight">
      				<ul id="class_search_students_tabs" class="nav nav-tabs" role="tablist">
				      <li class="active"><a href="#class_search_students_tab1" role="tab" data-toggle="tab">精确查找</a></li>
				      <li class=""><a href="#class_search_students_tab2" role="tab" data-toggle="tab">Group模糊查找</a></li>
				    </ul>
				    <div id="class_search_students_tabs_content" class="tab-content">
				      <div class="tab-pane fade active in" id="class_search_students_tab1">
				        <div class="row">
		      				<div class="col-xs-8">
		      					<label for="input_class_search_class_student_management_ic_name">请输入学员IC/名字/HP</label>
								<input class="form-control" id="input_class_search_class_student_management_ic_name" placeholder="IC Number/Name/HP">
							</div>
							<div class="col-xs-2">
								<br>
								<a class="button glow button-rounded button-flat" id="input_class_search_class_student_management_student_search">Search</a>
							</div>
						</div>
				      </div>
				      <div class="tab-pane fade" id="class_search_students_tab2">
				      	<div class="row">
							<div class="input-daterange">
								<div class="col-xs-4">
									<label>注册时间 From</label>
									<input name="from" class="form-control" id="input_class_search_from" placeholder="From">
								</div>
								<div class="col-xs-4">
									<label>注册时间 To</label>
									<input name="to" class="form-control" id="input_class_search_to" placeholder="To">
								</div>
								<div class="col-xs-4">
									<div class="checkbox">
									    <label for="input_class_search_have_class">
									    	<input name="have_class" type="checkbox" id="input_class_search_have_class" value="YES"> 有班级
									    </label>
									</div>
								</div>
							</div>
						</div>
				        <div class="row">
		      				<div class="col-xs-3">
								<label for="input_class_search_course_type">Course Type</label>
								<select class="form-control" id="input_class_search_course_type">
									<option value="NA">请选择</option>
									<option id="input_class_search_course_type_1" value="cmp">英文综合</option>
									<option id="input_class_search_course_type_2" value="con">英文会话</option>
									<option id="input_class_search_course_type_3" value="wri">英文写作</option>
									<option id="input_class_search_course_type_3" value="wpn">数学</option>
									<!-- <option id="input_class_search_course_type_3" value="eness">ESS</option> -->
									<!-- <option id="input_class_search_course_type_4" value="encos">COS</option> -->
									<!-- <option id="input_class_search_course_type_5" value="encom">英文电脑</option> -->
									<!-- <option id="input_class_search_course_type_6" value="chcom">华文电脑</option> -->
									<!-- <option id="input_class_search_course_type_7" value="chpin">华文拼音</option> -->
									<!-- <option id="input_class_search_course_type_8" value="enpho">英文音标</option> -->
									<!-- <option id="input_class_search_course_type_9" value="engra">英文语法</option> -->
									<!-- <option id="input_class_search_course_type_10" value="chwri">华文写作</option> -->
									<!-- <option id="input_class_search_course_type_11" value="others">其他</option> -->
								</select>
							</div>
							<div class="col-xs-3">
								<label for="input_class_search_student_level">水平等级</label>
								<select class="form-control" id="input_class_search_student_level">
									<option value="NA">请选择</option>
									<option value="BEGINNERS">初级</option>
				                	<option value="INTERMEDIATE">中级</option>
				                	<option value="ADVANCED">高级</option>
								</select>
							</div>
							<div class="col-xs-3">
								<label for="input_class_search_class_time">想上课时间</label>
								<select class="form-control" id="input_class_search_class_time">
									<option value="NA">请选择</option>
									<option value="anytime">任意时间</option>
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
							<div class="col-xs-2">
								<br>
								<a class="button glow button-rounded button-flat" id="input_class_search_class_student_management_student_search2">Search</a>
							</div>
						</div>
				      </div>
				    </div>
					<select multiple class="form-control" id="class_search_student_search_results"></select>
      			</div>
      		</div>
      		<div class="col-xs-1" id="class_search_class_student_management_middle_section">
	      		<button type="button" class="btn btn-primary">
				  <span class="glyphicon glyphicon-arrow-right"></span> Assign
				</button>
      		</div>
      		<div class="col-xs-5" id="class_search_class_student_management_class_section">
      			<div class="highlight">
	      			<div class="row">
	      				<div class="col-xs-8">
	      					<label>班级所有学生</label>
						</div>
					</div>
					<br>
					<div id="class_all_students_list"></div>
	      		</div>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
      	<form action="<?php echo $this->config->base_url(); ?>index.php/api/getClassStudentsByClassIDToExcel" method="POST" target="_blank">
      		<div class="row">
      			<div class="col-xs-8"><input name="class_id" id="class_id_to_excel" style="visibility:hidden;"><input name="class_name" id="class_name_to_excel" style="visibility:hidden;"></div>
      			<div class="col-xs-2">
      				<input type="submit" value="To Excel" class="btn btn-primary">
      			</div>
      			<div class="col-xs-2">
	      			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	      		</div>
      		</div>
      	</form>
      </div>
    </div>
  </div>
</div>

<!-- Class delete Modal -->
<div class="modal fade" id="class-delete-modal" tabindex="-1" role="dialog" aria-labelledby="class_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="class_delete_modal_label">Delete Class</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="class_del_confirm_btn">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- student delete Modal -->
<div class="modal fade" id="student-delete-modal" tabindex="-1" role="dialog" aria-labelledby="student_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_delete_modal_label">Remove Studnet</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-8">
      			<H4>Sure you want to remove this student from this class?</h4>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="remove_student_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>