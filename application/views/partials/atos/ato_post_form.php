<head>
	<meta charset="utf-8">

	<script>
		var selected_ato_id = 0;
		$(document).ready(function($) {
			$('#ato_post_form').parsley();
			$('#input_ato_exam_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			// ato_load_admin_users();
			// ato_load_branches();

			$('#ato_create_submit').on('click', function() {
				insert_ato_info();
			});

			$('#ato_update_submit').on('click', function() {
				update_ato_info(selected_ato_id);
			});

			$('#student_ato_ic_check').on('click', function() {
				get_ato_by_ic();
			});

			$('#student_ato_class_check').on('click', function() {
				get_class_by_class_code();
			});

			$('#input_ato_pre_post').change(function() {
				if($(this).val()=="PRE") { 
					$('#input_ato_class_code').prop('disabled', true); 
					$('#student_ato_class_check').hide(); 
					$('#input_ato_attendance').prop('disabled', true); 
					// $('#input_ato_post_change_date').prop('disabled', true); 
				} else if($(this).val()=="POST") {
					$('#input_ato_class_code').prop('disabled', false); 
					$('#student_ato_class_check').show(); 
					$('#input_ato_attendance').prop('disabled', false); 
					// $('#input_ato_post_change_date').prop('disabled', false); 
				}
			});
		});

		// function ato_load_admin_users() {
		// 	var users = $('#input_ato_op');
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

		// function ato_load_branches() {
		// 	var branches = $('#input_ato_branch');
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

		function insert_ato_info() {
			var ic = $('#input_ato_ic').val();
			var pre_post = $('#input_ato_pre_post').val();
			// var recommend_level = $('#input_ato_recommend_level').val();
			var class_code = $('#input_ato_class_code').val();
			var attendance = $('#input_ato_attendance').val();
			var post_change_date = $('#input_ato_post_change_date').is(':checked') ? 'YES' : 'NO';
			var el = $('#input_ato_el').is(':checked') ? 'YES' : 'NO';
			var er = $('#input_ato_er').is(':checked') ? 'YES' : 'NO';
			var en = $('#input_ato_en').is(':checked') ? 'YES' : 'NO';
			var es = $('#input_ato_es').is(':checked') ? 'YES' : 'NO';
			var ew = $('#input_ato_ew').is(':checked') ? 'YES' : 'NO';
			var exam_location = $('#input_ato_exam_location').val();
			var exam_date = $('#input_ato_exam_date').val();
			var exam_time = $('#input_ato_exam_time').val();
			// var ato_branch = $('#input_ato_branch option:selected').attr('id').split('_');
			// var ato_branch_id = ato_branch[2];
			// var ato_op = $('#input_ato_op option:selected').attr('id').split('_');
			// var ato_op_id = ato_op[2];
			var remark  = $('#input_ato_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "createATOInfo",
			    data:{	ic:ic,
			    		pre_post:pre_post, 
			    		// recommend_level:recommend_level, 
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
			    success:function(json){
			    	if(json.trim() == '1') {
					    toastr.success("Insert success!");
					    clear_ato_inputs();
					}else{
						toastr.error("Fail to insert ato info!");
					}
			    }
			});//End ajax
		}

		function update_ato_info(ato_id) {
			var ic = $('#input_ato_ic').val();
			var pre_post = $('#input_ato_pre_post').val();
			// var recommend_level = $('#input_ato_recommend_level').val();
			var class_code = $('#input_ato_class_code').val();
			var attendance = $('#input_ato_attendance').val();
			var post_change_date = $('#input_ato_post_change_date').is(':checked') ? 'YES' : 'NO';
			var el = $('#input_ato_el').is(':checked') ? 'YES' : 'NO';
			var er = $('#input_ato_er').is(':checked') ? 'YES' : 'NO';
			var en = $('#input_ato_en').is(':checked') ? 'YES' : 'NO';
			var es = $('#input_ato_es').is(':checked') ? 'YES' : 'NO';
			var ew = $('#input_ato_ew').is(':checked') ? 'YES' : 'NO';
			var exam_location = $('#input_ato_exam_location').val();
			var exam_date = $('#input_ato_exam_date').val();
			var exam_time = $('#input_ato_exam_time').val();
			// var ato_branch = $('#input_ato_branch option:selected').attr('id').split('_');
			// var ato_branch_id = ato_branch[2];
			// var ato_op = $('#input_ato_op option:selected').attr('id').split('_');
			// var ato_op_id = ato_op[2];
			var remark  = $('#input_ato_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "updateATOInfo",
			    data:{	id:ato_id,
			    		pre_post:pre_post, 
			    		// recommend_level:recommend_level, 
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
			    success:function(json){
			    	if(json.trim() == '2') {
						toastr.success("Update success!");
					    clear_ato_inputs();
					}else{
						toastr.error("fail to update ato info");
					}
			    }
			});//End ajax
		}

		function clear_ato_inputs() {
			$('#input_ato_ic').val('');
			$('#input_ato_class_code').val('');
			$('#input_ato_attendance').val('');
			$('#input_ato_post_change_date').prop('checked', false);
			$('#input_ato_el').prop('checked', false);
			$('#input_ato_er').prop('checked', false);
			$('#input_ato_en').prop('checked', false);
			$('#input_ato_es').prop('checked', false);
			$('#input_ato_ew').prop('checked', false);
			$('#input_ato_exam_date').val('');
			$('#input_ato_remark').val('');
		}

		function get_ato_by_ic() {
			var ic = $('#input_ato_ic').val();
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentATOInfoByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#student_ato_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.empty();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'<div class="col-xs-2" id="student_ato_ic_check_model_ic">'+ 
											'<label>IC Number</label>' +
											'<div class="form-control">' + ic + '</div>' +
										'</div>' + 
										'<div class="col-xs-3">' + 
											'<label for="student_ato_ic_check_model_exam_date">考试时间</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_date">' + reply[key].exam_date + ' ' + reply[key].exam_time + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_exam_type">考试类型</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_type">' + reply[key].pre_post + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_exam_location">考试地点</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_location">' + reply[key].exam_location + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_exam_change_date">是否改期</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_change_date">' + reply[key].post_change_date + '</div>' + 
										'</div>' +
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-2">'+ 
											'<label>EL</label>' +
											'<div class="form-control">' + reply[key].el + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">'+ 
											'<label>ER</label>' +
											'<div class="form-control">' + reply[key].er + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">'+ 
											'<label>EN</label>' +
											'<div class="form-control">' + reply[key].en + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">'+ 
											'<label>ES</label>' +
											'<div class="form-control">' + reply[key].es + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">'+ 
											'<label>EW</label>' +
											'<div class="form-control">' + reply[key].ew + '</div>' +
										'</div>' + 
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-6">' +
											'<label for="student_ato_ic_check_model_remark">备注</label>' +
											'<div class="form-control" id="student_ato_ic_check_model_remark">'+ reply[key].ato_remark + '</div>' + 
										'</div>' +
										'<div class="col-xs-4"></div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="student_ato_ic_check_modal_update_' + reply[key].id + '">Update</a>' + 
										'</div>' +
									'</div>' +
									'<hr>'
								);
					        }
				    	}
				    	$('#student-ato-modal a').on('click', function() {
							var el_id = $(this).attr('id').split('_');
							var ato_id = el_id[6];
							selected_ato_id = ato_id;	// assign global var for late update submit

							load_ato_info(ato_id);
							$('#student-ato-modal').modal('hide');
						});
				    }
				    else {
				    	if(ic.trim() == "") {
				    		ic='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="student_ato_ic_check_model_ic">'+ 
									'<label>IC Number Input</label>' +
									'<div class="form-control">' + ic + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related ATO info found!<br>Please input valid IC number.</label>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function get_class_by_class_code() {
			var class_code = $('#input_ato_class_code').val().trim();
			$.ajax({
				type:"post",
			    url:window.api_url + "getClassInfoByCode",
			    data:{code:class_code},
			    success:function(json){
			    	var modalBody = $('#student_ato_class_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.empty();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'<div class="col-xs-3">'+ 
											'<label>Classs Code</label>' +
											'<div class="form-control">' + class_code + '</div>' +
										'</div>' + 
										'<div class="col-xs-3">' + 
											'<label>班级名字</label>' + 
											'<div class="form-control">' + reply[key].class_name + '</div>' + 
										'</div>' +
										'<div class="col-xs-3">' + 
											'<label>科目</label>' + 
											'<div class="form-control">' + reply[key].type + '</div>' + 
										'</div>' +
										// '<div class="col-xs-3">' + 
										// 	'<label>等级</label>' + 
										// 	'<div class="form-control">' + reply[key].level + '</div>' + 
										// '</div>' +
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-4">'+ 
											'<label>课程日期</label>' +
											'<div class="form-control">' + reply[key].start_date + " ~ " + reply[key].end_date + '</div>' +
										'</div>' + 
										'<div class="col-xs-4">' + 
											'<label>课程时段</label>' + 
											'<div class="form-control">' + reply[key].start_time + " ~ " + reply[key].end_time + '</div>' + 
										'</div>' +
										'<div class="col-xs-4">' + 
											'<label>老师信息</label>' + 
											'<div class="form-control">' + reply[key].teacher_name + '(' + reply[key].teacher_tel + ')' + '</div>' + 
										'</div>' +
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-6">' +
											'<label>备注</label>' +
											'<div class="form-control">'+ reply[key].remark + '</div>' + 
										'</div>' +
									'</div>'
								);
					        }
				    	}
				    }
				    else {
				    	if(class_code.trim() == "") {
				    		class_code='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4">'+ 
									'<label>Class Code Input</label>' +
									'<div class="form-control">' + class_code + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related Class info found!<br>Please input valid class code.</label>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function load_ato_info(ato_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "getATOInfoByID",
			    data:{id:ato_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		$('#input_ato_ic').val(reply[key].ic);
								$('#input_ato_class_code').val(reply[key].class_code);
								$('#input_ato_attendance').val(reply[key].attendance);
								(reply[key].post_change_date == "YES") ? $('#input_ato_post_change_date').prop('checked', true) : $('#input_ato_post_change_date').prop('checked', false);
								(reply[key].el == "YES") ? $('#input_ato_el').prop('checked', true) : $('#input_ato_el').prop('checked', false);
								(reply[key].er == "YES") ? $('#input_ato_er').prop('checked', true) : $('#input_ato_er').prop('checked', false);
								(reply[key].en == "YES") ? $('#input_ato_en').prop('checked', true) : $('#input_ato_en').prop('checked', false);
								(reply[key].es == "YES") ? $('#input_ato_es').prop('checked', true) : $('#input_ato_es').prop('checked', false);
								(reply[key].ew == "YES") ? $('#input_ato_ew').prop('checked', true) : $('#input_ato_ew').prop('checked', false);
								$('#input_ato_exam_date').val(reply[key].exam_date);
								$('#input_ato_remark').val(reply[key].ato_remark);

								$('#input_ato_pre_post option[value="'+reply[key].pre_post+'"]').attr('selected', 'selected');
								// $('#input_ato_recommend_level option[value="'+reply[key].recommend_level+'"]').attr('selected', 'selected');
								$('#input_ato_exam_location option[value="'+reply[key].exam_location+'"]').attr('selected', 'selected');
								$('#input_ato_exam_time option[value="'+reply[key].exam_time+'"]').attr('selected', 'selected');
								// $('#input_ato_branch option[id="ato_branch_'+reply[key].branch_id+'"]').attr('selected', 'selected');
								// $('#input_ato_op option[id="ato_user_'+reply[key].branch_op_id+'"]').attr('selected', 'selected');
			            	}
			            }
			            $("html, body").animate({ scrollTop: 0 }, "slow");
			            toastr.info("Update ato record on above form!");
			        }else{
			        	toastr.error("Fail to load ato info!");
			        }
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
<form role="form" id="ato_post_form">
	<h4>ATO信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_pre_post">*Exam Type(考试类型)</label>
			<select class="form-control" id="input_ato_pre_post">
		      <option value="NA">请选择</option>
		      <option value="PRE">PRE CAT</option>
		      <option value="POST">POST CAT</option>
		    </select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_ic">*IC Number(准证号)</label>
			<input class="form-control" id="input_ato_ic" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="student_ato_ic_check" data-toggle="modal" data-target="#student-ato-modal">Check</a>
		</div>
<!-- 		<div class="col-xs-4">
			<label for="input_ato_recommend_level">*Recommend Level(推荐等级)</label>
			<select class="form-control" id="input_ato_recommend_level">
            	<option value="NA">请选择</option>
                <option value="Waiting for the result">PRE CAT等成绩</option>
                <option value="BEGINNERS">初级</option>
                <option value="INTERMEDIATE">中级</option>
                <option value="ADVANCED">高级</option>
            </select>
		</div> -->
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_class_code">*Class Code(班级代码)</label>
			<input class="form-control" id="input_ato_class_code" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="student_ato_class_check" data-toggle="modal" data-target="#student-ato-class-modal">Check</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_attendance">Attendance(出席率)</label>
			<input class="form-control" id="input_ato_attendance">
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_post_change_date">
			    	<input type="checkbox" id="input_ato_post_change_date"> 是否改期
			    </label>
			</div>
		</div>
	</div>
	<h4>考试科目</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_el">
			    	<input type="checkbox" id="input_ato_el"> 听力EL
			    </label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		    	<label for="input_ato_er">
		    		<input type="checkbox" id="input_ato_er"> 阅读ER
		    	</label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_en">
			    	<input type="checkbox" id="input_ato_en"> 数学EN
			    </label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		    	<label for="input_ato_es">
		    		<input type="checkbox" id="input_ato_es"> 会话ES
		    	</label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_ew">
			    	<input type="checkbox" id="input_ato_ew"> 写作EW
			    </label>
			</div>
		</div>
	</div>
	<h4>考试信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_exam_location">*Exam Location(考试地点)</label>
			<select class="form-control" id="input_ato_exam_location">
				<option value="NA">请选择</option>
	      		<option value="JE">Jurong East</option>
	      		<option value="PY">Paya Lebar</option>
	      	</select>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_exam_date">*Exam Date(考试日期)</label>
			<input class="form-control" id="input_ato_exam_date" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_exam_time">*Exam Time(考试时间)</label>
			<select class="form-control" id="input_ato_exam_time">
                <option value="NA">请选择</option>
                <option value="09">上午九点</option>
                <option value="14">下午两点</option>
                <option value="19">晚上七点</option>
            </select>
		</div>
	</div>
	<div class="row">
<!-- 		<div class="col-xs-4">
			<label for="input_ato_branch">ATO Branch</label>
			<select class="form-control" id="input_ato_branch"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_op">ATO Operator</label>
			<select class="form-control" id="input_ato_op"></select>
		</div> -->
		<div class="col-xs-4">
			<label for="input_ato_remark">Remark(备注)</label>
			<textarea class="form-control" id="input_ato_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="ato_create_submit">新建</a>
	</div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="ato_update_submit">更新ATO信息</a>
	</div>
</div>
</div>

<!-- Student ATO IC Check Modal -->
<div class="modal fade" id="student-ato-modal" tabindex="-1" role="dialog" aria-labelledby="student_ato_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_ato_ic_check_modal_label">ATO Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ATO CLASS Check Modal -->
<div class="modal fade" id="student-ato-class-modal" tabindex="-1" role="dialog" aria-labelledby="student_ato_class_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_ato_class_check_modal_label">Class Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>