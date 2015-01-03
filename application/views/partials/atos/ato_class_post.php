 <head>
	<meta charset="utf-8">

	<script>
		var selected_class_id = 0;
		var selected_remove_student_id = 0;
		$(document).ready(function($) {
			$('#input_ato_class_exam_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});
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

 			class_search_load_type();

 			$('#remove_student_confirm').on('click', function() {
 				remove_student_from_class(selected_remove_student_id, selected_class_id);
 			});

 			$('#ato_class_post_build_ato').on('click', function(){
				build_ato_of_class();
			});

			$('#ato_class_post_build_select_all').on('click', function(){ 
				var checkboxs = $('#class_search_class_student_management_class_section').find('input');
				$.each(checkboxs, function(i, e) {
					$(e).prop("checked", true);
				});
			});

			$('#ato_class_post_build_select_null').on('click', function(){ 
				var checkboxs = $('#class_search_class_student_management_class_section').find('input');
				$.each(checkboxs, function(i, e) {
					$(e).prop("checked", false);
				});
			});
		});

 	// 	function ato_class_load_admin_users() {
		// 	var users = $('#input_ato_class_op');
		// 	$.ajax({
		// 		type:"post",
		// 	    url:window.api_url + "getAllAdminUsers",
		// 	    data:{},
		// 	    success:function(json){
		// 	    	users.children().remove();
		// 	    	if(json != null) {
		// 	    		var reply = $.parseJSON(json);
		// 	    		for (var key in reply) {
		// 	    			if (reply.hasOwnProperty(key)) {
		// 	            		users.append('<option id="ato_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
		// 	            	}
		// 	            }
		// 	        }else{
		// 	        	toastr.error("fail to load users");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }

		// function ato_class_load_branches() {
		// 	var branches = $('#input_ato_class_branch');
		// 	$.ajax({
		// 		type:"post",
		// 	    url:window.api_url + "getAllBranches",
		// 	    data:{},
		// 	    success:function(json){
		// 	    	branches.children().remove();
		// 	    	if(json != null) {
		// 	    		var reply = $.parseJSON(json);
		// 	    		for (var key in reply) {
		// 	    			if (reply.hasOwnProperty(key)) {
		// 	    				branches.append('<option id="ato_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
		// 	    			}
		// 	    		}
		// 	        }else{
		// 	        	toastr.error("fail to load braches");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }

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
			    				branches.append('<option id="class_search_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
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
															'<div class="col-xs-10">' +
																'<a data-toggle="collapse" data-parent="class_search_collapse_'+key+'" href="#class_search_collapse_body_'+key+'">Class Name: <b>' + reply[key].class_name + '</b>  /  Code: <b>' + reply[key].code + '</b>  /  Course: <b>' + reply[key].type + '</b>  /  Status: <b>' + reply[key].status + '</b></a>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="class_search_student_management_'+reply[key].class_id+'" data-toggle="modal" data-target="#class-student-management-modal">班级ATO生成</a>' + 
															'</div>' + 
														'</div>' + 
													'</h4>' +
												'</div>' +
												'<div id="class_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
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
					 				if(el_id[3] == "management") {
					 					// menegement class student
					 					load_class_students(class_id);
					 					$(document).ready(function(){
					 						// ato_class_load_branches();
					 						// ato_class_load_admin_users();
					 						$('#input_ato_class_exam_date').datepicker({
												format: 'yyyy-mm-dd',
												todayHighlight: true
											});
					 					});
					 				}
					 			});
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function build_ato_of_class() {
 			var exam_location = $('#input_ato_class_exam_location').val();
			var exam_date = $('#input_ato_class_exam_date').val();
			var exam_time = $('#input_ato_class_exam_time').val();

			var el = $('#input_ato_class_el').is(':checked') ? 'YES' : 'NO';
			var er = $('#input_ato_class_er').is(':checked') ? 'YES' : 'NO';
			var en = $('#input_ato_class_en').is(':checked') ? 'YES' : 'NO';
			var es = $('#input_ato_class_es').is(':checked') ? 'YES' : 'NO';
			var ew = $('#input_ato_class_ew').is(':checked') ? 'YES' : 'NO';

			// var ato_branch = $('#input_ato_class_branch option:selected').attr('id').split('_');
			// var ato_branch_id = ato_branch[2];
			// var ato_op = $('#input_ato_class_op option:selected').attr('id').split('_');
			// var ato_op_id = ato_op[2];
			var remark  = $('#input_ato_class_remark').val();


			// get class info with selelcted class id
			$.ajax({
				type:"post",
			    url:window.api_url + "getClassInfoByID",
			    data:{class_id:selected_class_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				    				// create ato record for each student in this class
				    				$.each($('#class_all_students_list .panel-group .panel-title input'), function(){ 
										if($(this).is(':checked')){

											var el_id = $(this).attr('id').split('_');
											var student_id = el_id[3];
											var student_ic = el_id[4];
											var pre_post = 'POST';
											var class_code = reply[key].code;
											var attendance = '100';
											var post_change_date = 'NO';
											var recommend_level = reply[key].level;

											$.ajax({
												type:"post",
											    url:window.api_url + "createATOInfo",
											    data:{	ic:student_ic,
										    		pre_post:pre_post, 
										    		recommend_level:recommend_level, 
										    		class_code:class_code, 
										    		attendance:attendance,
										    		post_change_date:post_change_date,
										    		el:el,
										    		er:er,
										    		en:en,
										    		es:es,
										    		ew:ew, 
										    		exam_location:exam_location,
										    		exam_date:exam_date,
										    		exam_time:exam_time,
										    		// ato_branch_id:ato_branch_id,
										    		// ato_op_id:ato_op_id,
										    		remark:remark},
											    success:function(json2){
											    	if(json2.trim() == '1') {
											    		var str_suc = "Create ATO info for student " + student_ic + " successfully!"
											    		toastr.success(str_suc);
											        } else {
											        	var str_fail = "Create ATO info for student " + student_ic + " failed!"
											        	toastr.error(str_fail);
											        }
											    },
											});//End ajax
										}
									});
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function load_class_students(class_id) {
 			var target = $('#class_all_students_list');
 			target.empty();
			target.append('<div class="loading"></div>');
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
														'<a data-toggle="collapse" data-parent="class_all_student_collapse_'+key+'" href="#class_all_student_collapse_body_'+key+'">Student ' + num + '  / Name: <b>' + reply[key].firstname + ' ' + reply[key].lastname + '</b>  /  IC: <b>' + reply[key].ic + '</b>  /  Tel: <b>' + reply[key].tel + '</b></a><input id="class_students_student_' + reply[key].student_id + '_' + reply[key].ic + '" style="float:right;padding:3px;" type="checkbox" checked>' + 
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
																			'<div>Remark: '+ reply2[key2].remark + '</div>' + 
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
	</script>
</head>
<div class="highlight">
	<h4>输入查询信息</h4>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_search_code">Class Code</label>
			<input class="form-control" id="input_class_search_code">
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_type">Class Type</label>
			<select class="form-control" id="input_class_search_type" ></select>
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_type">Class Level</label>
			<select class="form-control" id="input_class_search_level">
		      	<option value="NA">请选择</option>
		     	<option value="BEGINNERS">初级</option>
		      	<option value="INTERMEDIATE">中级</option>
		      	<option value="ADVANCED">高级</option>
	    	</select>
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-4">
			<label for="input_class_search_status">Status</label>
			<select class="form-control" id="input_class_search_status" >
		      <option value="NA">请选择</option>
		      <option value="preparing">未开班</option>
		      <option value="learning">已开班</option>
		      <option value="waitexam">待考试</option>
		      <option value="finished">已结束</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_branch">Branch</label>
			<select class="form-control" id="input_class_search_branch" ></select>
		</div>
	</div>
	<label>Start Date</label>
	<div class="row">
		<div class="input-daterange">
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_start_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_start_to" placeholder="To">
			</div>
		</div>
	</div>
	<label>End Date</label>
	<div class="row">
		<div class="input-daterange">
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_end_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_end_to" placeholder="To">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-10"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="class_info_search_submit">Search</a>
		</div>
	</div>
	<br><br>
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
      		<div class="col-xs-5" id="class_search_class_student_management_search_section">
      			<div class="highlight">
  					<h4>考试信息</h4><hr>
  					<div class="row">
						<div class="col-xs-4">
							<label for="input_ato_class_exam_location">Exam Location</label>
							<select class="form-control" id="input_ato_class_exam_location">
								<option value="NA">请选择</option>
					      		<option value="JE">Jurong East</option>
					      		<option value="PY">Paya Lebar</option>
					      	</select>
						</div>
						<div class="col-xs-4">
							<label for="input_ato_class_exam_date">Exam Date</label>
							<input class="form-control" id="input_ato_class_exam_date">
						</div>
						<div class="col-xs-4">
							<label for="input_ato_class_exam_time">Exam Time</label>
							<select class="form-control" id="input_ato_class_exam_time">
				                <option value="NA">请选择</option>
				                <option value="09">上午九点</option>
				                <option value="14">下午两点</option>
				                <option value="19">晚上七点</option>
				            </select>
						</div>
					</div>
					<h4>考试科目</h4><hr>
					<div class="row">
						<div class="col-xs-4">
							<div class="checkbox">
							    <label for="input_ato_class_el">
							    	<input type="checkbox" id="input_ato_class_el"> 听力EL
							    </label>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="checkbox">
						    	<label for="input_ato_class_er">
						    		<input type="checkbox" id="input_ato_class_er"> 阅读ER
						    	</label>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="checkbox">
							    <label for="input_ato_class_en">
							    	<input type="checkbox" id="input_ato_class_en"> 数学EN
							    </label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="checkbox">
						    	<label for="input_ato_class_es">
						    		<input type="checkbox" id="input_ato_class_es"> 会话ES
						    	</label>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="checkbox">
							    <label for="input_ato_class_ew">
							    	<input type="checkbox" id="input_ato_class_ew"> 写作EW
							    </label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<label for="input_ato_remark">Remark</label>
							<textarea class="form-control" id="input_ato_class_remark" rows="3"></textarea>
						</div>
					</div>
      			</div>
      		</div>
      		<div class="col-xs-7" id="class_search_class_student_management_class_section">
      			<div class="highlight">
	      			<div class="row">
	      				<div class="col-xs-8">
	      					<label>班级所有学生</label>
						</div>
						<div class="col-xs-2">
	      					<button type="button" class="btn btn-primary" id="ato_class_post_build_select_all">全选</button>
						</div>
						<div class="col-xs-2">
	      					<button type="button" class="btn btn-primary" id="ato_class_post_build_select_null">全不选</button>
						</div>
					</div>
					<br>
					<div id="class_all_students_list"></div>
					<div class="row">
						<div class="col-xs-9"></div>
						<div class="col-xs-2">
							<button type="button" class="btn btn-primary" id="ato_class_post_build_ato">Build ATO</button>
						</div>
					</div>
	      		</div>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>