 <head>
	<meta charset="utf-8">

	<script>
		var update_selected_class_id = 0;
		$(document).ready(function($) {
			$('#class_creation_form').parsley();
			$('#input_class_start_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_class_end_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			class_load_branches();

			$('#class_new_submit').on('click', function() {
				create_new_class();
			});

			$('#class_update_submit').on('click', function() {
				update_class();
			});

			$('#class_class_code_check').on('click', function() {
				get_class_by_code();
			});

			load_class_type();
		});

		function load_class_type() {
			var types = $('#input_class_type');
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
			    				types.append('<option id="course_type_'+ reply[key].id +'" + value="'+ reply[key].code +'">' + reply[key].type + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load courses");
			        }
			    },
			});//End ajax
		}

		function class_load_branches() {
			var branches = $('#input_class_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.empty();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="class_new_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load branches");
			        }
			    }
			});//End ajax
		}

		function create_new_class() {
			var code = $('#input_class_code').val();
			var branch = $('#input_class_branch option:selected').attr('id').split('_');
			var branch_id = branch[3];
			var type = $('#input_class_type option:selected').val();
			var level = $('#input_class_level option:selected').val();
			var status = $('#input_class_status option:selected').val();
			var location = $('#input_class_location').val();
			var start_date = $('#input_class_start_date').val();
			var end_date = $('#input_class_end_date').val();
			var start_time = $('#input_class_start_time').val();
			var end_time = $('#input_class_end_time').val();
			var teacher_name = $('#input_class_teacher_name').val();
			var teacher_tel = $('#input_class_teacher_tel').val();
			var remark = $('#input_class_remark').val();

			// composite class name
			var class_name = 'WPL-P-' + type.toUpperCase() + '-' + level.substring(0, 3) + '-' + code;

			$.ajax({
				type:"post",
			    url:window.api_url + "createNewClass",
			    data:{
			    	code:code,
			    	class_name:class_name,
			     	branch_id:branch_id,
			     	type:type, 
			     	level:level, 
			     	status:status, 
			     	location:location, 
			     	start_date:start_date, 
			     	end_date:end_date, 
			     	start_time:start_time, 
			     	end_time:end_time, 
			     	teacher_name:teacher_name, 
			     	teacher_tel:teacher_tel, 
			     	remark:remark},
			    success:function(json){
			    	if(json.trim() != "") {
					    var reply = $.parseJSON(json);
					    if(reply == '1') {
					    	toastr.success("Create class success!");
					    	clear_class_form_inputs();
					    	load_all_classes();
					    }else{
					    	toastr.error("Fail to insert class data");
					    }
					}
					else {
						toastr.error("Fail to insert class api");
					}
			    }
			});//End ajax
		}

		function update_class() {
			var class_id = update_selected_class_id;
			var code = $('#input_class_code').val();
			var branch = $('#input_class_branch option:selected').attr('id').split('_');
			var branch_id = branch[3];
			var type = $('#input_class_type option:selected').val();
			var level = $('#input_class_level option:selected').val();
			var status = $('#input_class_status option:selected').val();
			var location = $('#input_class_location').val();
			var start_date = $('#input_class_start_date').val();
			var end_date = $('#input_class_end_date').val();
			var start_time = $('#input_class_start_time').val();
			var end_time = $('#input_class_end_time').val();
			var teacher_name = $('#input_class_teacher_name').val();
			var teacher_tel = $('#input_class_teacher_tel').val();
			var remark = $('#input_class_remark').val();

			// composite class name
			var class_name = 'WPL-P-' + type.toUpperCase() + '-' + level.substring(0, 3) + '-' + code;

			$.ajax({
				type:"post",
			    url:window.api_url + "updateClassByID",
			    data:{
			    	class_id:class_id,
			    	code:code,
			    	class_name:class_name,
			     	branch_id:branch_id,
			     	type:type, 
			     	level:level, 
			     	status:status, 
			     	location:location, 
			     	start_date:start_date, 
			     	end_date:end_date, 
			     	start_time:start_time, 
			     	end_time:end_time, 
			     	teacher_name:teacher_name, 
			     	teacher_tel:teacher_tel, 
			     	remark:remark},
			    success:function(json){
			    	if(json.trim() != "") {
					    var reply = $.parseJSON(json);
					    if(reply == '2') {
					    	toastr.success("Update class success!");
					    	clear_class_form_inputs();
					    }else{
					    	toastr.error("Fail to update class data");
					    }
					}
					else {
						toastr.error("Fail to call update class api");
					}
			    }
			});//End ajax
		}

		function get_class_by_code() {
			var code = $('#input_class_code').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "getClassInfoByCode",
			    data:{code:code},
			    success:function(json){
			    	var modalBody = $('#class_code_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.children().remove();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'<div class="col-xs-2" id="class_check_by_code_code">'+ 
											'<label>Class Code</label>' +
											'<div class="form-control">' + code + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_class_name">Name</label>' + 
											'<div class="form-control" id="sclass_check_by_code_class_name">' + reply[key].class_name + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_type">Type</label>' + 
											'<div class="form-control" id="sclass_check_by_code_type">' + reply[key].type + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_level">Level</label>' + 
											'<div class="form-control" id="sclass_check_by_code_level">' + reply[key].level + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_start_date">开课时间</label>' + 
											'<div class="form-control" id="sclass_check_by_code_start_date">' + reply[key].start_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_end_date">结课时间</label>' + 
											'<div class="form-control" id="class_check_by_code_end_date">' + reply[key].end_date + '</div>' + 
										'</div>' +
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_teacher_name">Teacher</label>' + 
											'<div class="form-control" id="class_check_by_code_teacher_name">' + reply[key].end_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_location">Teacher</label>' + 
											'<div class="form-control" id="class_check_by_code_location">' + reply[key].location + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="class_check_by_code_branch">Teacher</label>' + 
											'<div class="form-control" id="class_check_by_code_branch">' + reply[key].teacher_name + '</div>' + 
										'</div>' +
										'<div class="col-xs-4">' +
											'<label for="class_check_by_code_remark">备注</label>' +
											'<div class="form-control" id="class_check_by_code_remark">'+ reply[key].remark + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="class_check_by_code_modal_update_' + reply[key].class_id + '">Update</a>' + 
										'</div>' +
									'</div>' +
									'<hr>'
								);
					        }
				    	}
				    	$('#class-new-modal a').on('click', function() {
							var el_id = $(this).attr('id').split('_');
							var class_id = el_id[6];
							update_selected_class_id = class_id;	// assign global var for late update submit

							load_class_info(class_id);
							$('#class-new-modal').modal('hide');
						});
				    }
				    else {
				    	if(code.trim() == "") {
				    		code='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="class_check_by_code_code">'+ 
									'<label>Class Code Input</label>' +
									'<div class="form-control">' + code + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related class info found!<br>Please input valid class code.</label>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function load_class_info(class_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "getClassInfoByID",
			    data:{class_id:class_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		$('#input_class_code').val(reply[key].code);
								$('#input_class_name').val(reply[key].class_name);
								$('#input_class_location').val(reply[key].location);
								$('#input_class_start_date').val(reply[key].start_date);
								$('#input_class_end_date').val(reply[key].end_date);
								$('#input_class_start_time').val(reply[key].start_time);
								$('#input_class_end_time').val(reply[key].end_time);
								$('#input_class_teacher_name').val(reply[key].teacher_name);
								$('#input_class_teacher_tel').val(reply[key].teacher_tel);
								$('#input_class_remark').val(reply[key].remark);

								$('#input_class_status option[value="'+reply[key].status+'"]').attr('selected', 'selected');
								$('#input_class_level option[value="'+reply[key].level+'"]').attr('selected', 'selected');
								$('#input_class_type option[value="'+reply[key].type+'"]').attr('selected', 'selected');
								$('#input_class_branch option[id="class_new_branch_'+reply[key].branch_id+'"]').attr('selected', 'selected');
			            	}
			            }
			        }else{
			        	toastr.error("Fail to load class info!");
			        }
			    }
			});//End ajax
		}

		function clear_class_form_inputs() {
			$('#input_class_code').val('');
			$('#input_class_name').val('');
			$('#input_class_branch option[id="class_new_branch_1"]').attr('selected', 'selected');
			$('#input_class_type option[value="NA"]').attr('selected', 'selected');
			$('#input_class_level option[value="NA"]').attr('selected', 'selected');
			$('#input_class_status option[value="NA"]').attr('selected', 'selected');
			$('#input_class_location').val('');
			$('#input_class_start_date').val('');
			$('#input_class_end_date').val('');
			$('#input_class_start_time').val('');
			$('#input_class_end_time').val('');
			$('#input_class_teacher_name').val('');
			$('#input_class_teacher_tel').val('');
			$('#input_class_remark').val('');
		}
	</script>
</head>
<div class="highlight">
<form role="form" id="class_creation_form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_code">*Class Code(班级代码)</label>
			<input class="form-control" id="input_class_code" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="class_class_code_check" data-toggle="modal" data-target="#class-new-modal">Check</a>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-4">
			<label for="input_class_branch">*Branch(班级所在分部)</label>
			<select class="form-control" id="input_class_branch"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<label for="input_class_type">*Class Type(课程类型)</label>
			<select class="form-control" id="input_class_type" ></select>
		</div>
		<div class="col-xs-3">
			<label for="input_class_level">*Class Level(课程水平)</label>
			<select class="form-control" id="input_class_level">
		      <option value="NA">请选择</option>
		      <option value="BEGINNERS">初级</option>
		      <option value="INTERMEDIATE">中级</option>
		      <option value="ADVANCED">高级</option>
		    </select>
		</div>
		<div class="col-xs-3">
			<label for="input_class_status">*Class Status(班级状态)</label>
			<select class="form-control" id="input_class_status" >
		      <option value="NA">请选择</option>
		      <option value="preparing">未开班</option>
		      <option value="learning">已开班</option>
		      <option value="waitexam">待考试</option>
		      <option value="finished">已结束</option>
		    </select>
		</div>
		<div class="col-xs-3">
			<label for="input_class_location">*Location(上课地点)</label>
			<input class="form-control" id="input_class_location" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_start_date">*Start Date(开班时间)</label>
			<input class="form-control" id="input_class_start_date" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_class_end_date">*End Date(班级结束时间)</label>
			<input class="form-control" id="input_class_end_date" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_start_time">*Start Time (上课开始时间 0000~2359)</label>
			<input class="form-control" id="input_class_start_time" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_class_end_time">*End Time (上课结束时间 0000~2359)</label>
			<input class="form-control" id="input_class_end_time" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_teacher_name">*Teacher's Name(老师名字)</label>
			<input class="form-control" id="input_class_teacher_name" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_class_teacher_tel">*Teacher's Tel(老师电话)</label>
			<input class="form-control" id="input_class_teacher_tel" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_remark">Remark(备注)</label>
			<textarea class="form-control" id="input_class_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-7"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="class_new_submit">新建</a>
	</div>
	<div class="col-xs-3">
		<a class="button glow button-rounded button-flat" id="class_update_submit">更新班级信息</a>
	</div>
</div>
</div>

<!-- Class code Check Modal -->
<div class="modal fade" id="class-new-modal" tabindex="-1" role="dialog" aria-labelledby="class_code_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="class_code_check_modal_label">Class Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>