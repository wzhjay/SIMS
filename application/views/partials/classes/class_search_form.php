 <head>
	<meta charset="utf-8">

	<script>
		var selected_class_management_id = 0;
		var selected_class_delete_id = 0;
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

 			$('#class_info_search_submit').on('click', function() {
 				search_class_info_by_types();
 			});

 			class_search_load_branches();

 			$('#input_class_search_class_student_management_student_search').on('click', function() {
 				search_student_by_ic_name();
 			});

 			class_search_load_type();
		});

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

 			var start_from = '2000-01-01';
			var start_to  = '2100-01-01';
			var end_from = '2000-01-01';
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
												'<div id="class_search_collapse_body_'+key+'" class="panel-collapse collapse in">' + 
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
					 				if(el_id[3] == "management") {
					 					// menegement class student
					 					selected_class_management_id = class_id;
					 					load_class_students(class_id);
					 				} else if(el_id[3] == "delete") {
					 					// delete class
					 					selected_class_delete_id = class_id;
					 					get_class_student_by_id(class_id);
					 				}
					 			});
				            }
			        	}
			        }
			    },
			});//End ajax
 		}

 		function load_class_students(class_id) {
 			var target = $('#class_search_class_student_management_class_section ul');
 			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "getClassStudentsByClassID",
			    data:{class_id:class_id},
			    success:function(json){
			    	target.empty();
			    	target.append('<li class="list-group-item">No Student Found</li>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		// target.append(JSON.stringify(reply[key]));
				            		target.append(
				            			'<li>' + reply[key].ic + ' (' + reply[key].salutation + ' ' + reply[key].firstname + ' ' + reply[key].lastname + ')' +'</li>'
									);
				            	}
				            }
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
 			var target = $('#class_search_class_student_management_class_section select');
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
				            			'<option id="searched_student_id_'+reply[key].id+'">' + reply[key].ic + ' (' + reply[key].salutation + ' ' + reply[key].firstname + ' ' + reply[key].lastname + ')' +'</option>'
									);
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax

			$('#class_search_class_student_management_middle_section .btn').on('click', function() {
				$.each($('#class_search_class_student_management_class_section select option:selected'), function() {
					var student_id = $(this).attr('id').split('_')[3];
					assign_student_to_class(student_id);
				});
			});
 		}

 		function assign_student_to_class(student_id) {
 			var class_id = selected_class_management_id;
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
		<div class="col-xs-8"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="class_info_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="class_info_to_excel">To Excel</a>
		</div>
	</div>
	<br><br>
	<div id="class_search_results"></div>
</div>

<!-- Class student management Modal -->
<div class="modal fade" id="class-student-management-modal" tabindex="-1" role="dialog" aria-labelledby="class_student_management_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="class_student_management_modal_label">Class Student Management</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-6" id="class_search_class_student_management_class_section">
      			<div class="highlight">
      				<div class="row">
	      				<div class="col-xs-8">
	      					<label for="input_class_search_class_student_management_ic_name">请输入学员IC/名字</label>
							<input class="form-control" id="input_class_search_class_student_management_ic_name" placeholder="IC Number/Name">
						</div>
						<div class="col-xs-2">
							<br>
							<a class="button glow button-rounded button-flat" id="input_class_search_class_student_management_student_search">Search</a>
						</div>
					</div>
					<br>
					<select multiple class="form-control"></select>
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
					<ul class="list-group">
					  <li class="list-group-item">Cras justo odio</li>
					  <li class="list-group-item">Dapibus ac facilisis in</li>
					  <li class="list-group-item">Morbi leo risus</li>
					  <li class="list-group-item">Porta ac consectetur ac</li>
					  <li class="list-group-item">Vestibulum at eros</li>
					  <li class="list-group-item">Cras justo odio</li>
					  <li class="list-group-item">Dapibus ac facilisis in</li>
					  <li class="list-group-item">Morbi leo risus</li>
					  <li class="list-group-item">Porta ac consectetur ac</li>
					  <li class="list-group-item">Vestibulum at eros</li>
					</ul>
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
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>