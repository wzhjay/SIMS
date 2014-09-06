 <head>
	<meta charset="utf-8">

	<script>
		var selected_reg_id = 0;
		$(document).ready(function($) {
			$('#student_reg_form').parsley();
			$('#input_reg_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			// reg_load_admin_users();
			reg_load_branches();

			$('#reg_new_create').on('click', function() {
				create_new_reg();
			});

			$('#reg_new_update').on('click', function() {
				update_reg();
			});

			$('#reg_new_ic_check').on('click', function() {
				reg_check_student_ic();
			});
		});


		// function reg_load_admin_users() {
		// 	var users = $('#input_reg_op');
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
		// 	            		users.append('<option id="new_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
		// 	            	}
		// 	            }
		// 	        }else{
		// 	        	toastr.error("Fail to load users!");
		// 	        }
		// 	    },
		// 	});//End ajax
		// }

		function reg_load_branches() {
			// var branches = $('#input_reg_branch');
			var branches_stu = $('#input_reg_branch_student');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches_stu.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				// branches.append('<option id="reg_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    				branches_stu.append('<option id="reg_branch_stu_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load braches!");
			        }
			    },
			});//End ajax
		}

		function create_new_reg() {
			var ic = $('#input_reg_ic').val();
			var reg_date = $('#input_reg_date').val();
			// var reg_branch = $('#input_reg_branch option:selected').attr('id').split('_');
			// var reg_branch_id = reg_branch[2];
			var reg_no = $('#input_reg_no').val();
			// var reg_op = $('#input_reg_op option:selected').attr('id').split('_');
			// var reg_op_id = reg_op[2];
			var reg_branch_stu = $('#input_reg_branch_student option:selected').attr('id').split('_');
			var reg_branch_stu_id = reg_branch_stu[3];
			var reg_remark = $('#input_reg_remark').val();

			// class time
			var any_am = $('#input_reg_any_am').is(':checked') ? '1' : '0';
			var any_pm = $('#input_reg_any_pm').is(':checked') ? '1' : '0';
			var any_eve = $('#input_reg_any_eve').is(':checked') ? '1' : '0';
			var sat_am = $('#input_reg_sat_am').is(':checked') ? '1' : '0';
			var sat_pm = $('#input_reg_sat_pm').is(':checked') ? '1' : '0';
			var sat_eve = $('#input_reg_sat_eve').is(':checked') ? '1' : '0';
			var sun_am = $('#input_reg_sun_am').is(':checked') ? '1' : '0';
			var sun_pm = $('#input_reg_sun_pm').is(':checked') ? '1' : '0';
			var sun_eve = $('#input_reg_sun_eve').is(':checked') ? '1' : '0';
			var anytime = $('#input_reg_anytime').is(':checked') ? '1' : '0';

			$.ajax({
				type:"post",
			    url:window.api_url + "createNewRegistrationInfo",
			    data:{	ic:ic,
			    		reg_date:reg_date, 
			    		student_branch_id:reg_branch_stu_id, 
			    		// reg_branch_id:reg_branch_id, 
			    		// reg_op_id:reg_op_id, 
			    		reg_no:reg_no, 
			    		reg_remark:reg_remark,
			    		any_am:any_am,
			    		any_pm:any_pm,
			    		any_eve:any_eve,
			    		sat_am:sat_am,
			    		sat_pm:sat_pm,
			    		sat_eve:sat_eve,
			    		sun_am:sun_am,
			    		sun_pm:sun_pm,
			    		sun_eve:sun_eve,
			    		anytime:anytime
			    	},
			    success:function(json){
			    	if(json != null) {
					    var reply = $.parseJSON(json);
					    if(reply == '1') {
					    	toastr.success("Register success!");
					    	reg_clear_form_input_values();
					    }else{
					    	toastr.error("Fail to insert regstration data!");
					    }
					}
					else {
						toastr.error("Fail to insert regstration api!");
					}
			    },
			});//End ajax
		}

		function update_reg() {
			var reg_id = selected_reg_id
			var ic = $('#input_reg_ic').val();
			var reg_date = $('#input_reg_date').val();
			// var reg_branch = $('#input_reg_branch option:selected').attr('id').split('_');
			// var reg_branch_id = reg_branch[2];
			var reg_no = $('#input_reg_no').val();
			// var reg_op = $('#input_reg_op option:selected').attr('id').split('_');
			// var reg_op_id = reg_op[2];
			var reg_branch_stu = $('#input_reg_branch_student option:selected').attr('id').split('_');
			var reg_branch_stu_id = reg_branch_stu[3];
			var reg_remark = $('#input_reg_remark').val();

			// class time
			var any_am = $('#input_reg_any_am').is(':checked') ? '1' : '0';
			var any_pm = $('#input_reg_any_pm').is(':checked') ? '1' : '0';
			var any_eve = $('#input_reg_any_eve').is(':checked') ? '1' : '0';
			var sat_am = $('#input_reg_sat_am').is(':checked') ? '1' : '0';
			var sat_pm = $('#input_reg_sat_pm').is(':checked') ? '1' : '0';
			var sat_eve = $('#input_reg_sat_eve').is(':checked') ? '1' : '0';
			var sun_am = $('#input_reg_sun_am').is(':checked') ? '1' : '0';
			var sun_pm = $('#input_reg_sun_pm').is(':checked') ? '1' : '0';
			var sun_eve = $('#input_reg_sun_eve').is(':checked') ? '1' : '0';
			var anytime = $('#input_reg_anytime').is(':checked') ? '1' : '0';

			$.ajax({
				type:"post",
			    url:window.api_url + "updateRegistrationInfo",
			    data:{	reg_id:reg_id,
			    		ic:ic,
			    		reg_date:reg_date, 
			    		student_branch_id:reg_branch_stu_id, 
			    		// reg_branch_id:reg_branch_id, 
			    		// reg_op_id:reg_op_id, 
			    		reg_no:reg_no, 
			    		reg_remark:reg_remark,
			    		any_am:any_am,
			    		any_pm:any_pm,
			    		any_eve:any_eve,
			    		sat_am:sat_am,
			    		sat_pm:sat_pm,
			    		sat_eve:sat_eve,
			    		sun_am:sun_am,
			    		sun_pm:sun_pm,
			    		sun_eve:sun_eve,
			    		anytime:anytime
			    	},
			    success:function(json){
			    	if(json != null) {
					    var reply = $.parseJSON(json);
					    if(reply == '2') {
					    	toastr.success("Update registartion info success!");
					    	reg_clear_form_input_values();
					    }else{
					    	toastr.error("Fail to update regstration info!");
					    }
					}
					else {
						toastr.error("Fail to insert regstration api!");
					}
			    },
			});//End ajax
		}

		function reg_clear_form_input_values() {
			$('#input_reg_ic').val('');
			$('#input_reg_date').val('');
			$('#input_reg_no').val('');
			$('#input_reg_remark').val('');
			$('#input_reg_any_am').prop('checked', false);
			$('#input_reg_any_pm').prop('checked', false);
			$('#input_reg_any_eve').prop('checked', false);
			$('#input_reg_sat_am').prop('checked', false);
			$('#input_reg_sat_pm').prop('checked', false);
			$('#input_reg_sat_eve').prop('checked', false);
			$('#input_reg_sun_am').prop('checked', false);
			$('#input_reg_sun_pm').prop('checked', false);
			$('#input_reg_sun_eve').prop('checked', false);
			$('#input_reg_anytime').prop('checked', false);
		}

		function reg_check_student_ic() {
			var ic = $('#input_reg_ic').val();
			// check if student bisic info exist, can update basic indo for this student
			$.ajax({
				type:"post",
			    url:window.api_url + "getRegistrationByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#reg_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.empty();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'Registration info existed!' + 
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-3" id="student_new_ic_check_model_ic">'+ 
											'<label>IC Number Input</label>' +
											'<div class="form-control">' + ic + '</div>' +
										'</div>' + 
										'<div class="col-xs-3">' +
											'<label>注册日期</label>' +
											'<div class="form-control">'+ reply[key].reg_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-3">' +
											'<label>注册号</label>' +
											'<div class="form-control">'+ reply[key].reg_no + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="reg_ic_check_modal_update_' + reply[key].reg_id + '">Update</a>' + 
										'</div>' +
									'</div>'
								);
					        }

					        $('#reg-ic-check-modal a').on('click', function() {
								var el_id = $(this).attr('id').split('_');
								var reg_id = el_id[5];
								selected_reg_id = reg_id;

								$('#input_reg_ic').val(reply[key].ic);
								$('#input_reg_date').val(reply[key].reg_date);
								// $('#input_reg_branch option[id="reg_branch_'+reply[key].reg_branch_id+'"]').attr('selected', 'selected');
								$('#input_reg_no').val(reply[key].reg_no);
								// $('#input_reg_branch option[id="new_user_'+reply[key].reg_op_id+'"]').attr('selected', 'selected');
								$('#input_reg_branch_student option[id="reg_branch_stu_'+reply[key].student_branch_id+'"]').attr('selected', 'selected');
								$('#input_reg_remark').val(reply[key].reg_remark);

								(reply[key].any_am == "1") ? $('#input_reg_any_am').prop('checked', true) : $('#input_reg_any_am').prop('checked', false);
								(reply[key].any_pm == "1") ? $('#input_reg_any_pm').prop('checked', true) : $('#input_reg_any_pm').prop('checked', false);
								(reply[key].any_eve == "1") ? $('#input_reg_any_eve').prop('checked', true) : $('#input_reg_any_eve').prop('checked', false);
								(reply[key].sat_am == "1") ? $('#input_reg_sat_am').prop('checked', true) : $('#input_reg_sat_am').prop('checked', false);
								(reply[key].sat_pm == "1") ? $('#input_reg_sat_pm').prop('checked', true) : $('#input_reg_sat_pm').prop('checked', false);
								(reply[key].sat_eve == "1") ? $('#input_reg_sat_eve').prop('checked', true) : $('#input_reg_sat_eve').prop('checked', false);
								(reply[key].sun_am == "1") ? $('#input_reg_sun_am').prop('checked', true) : $('#input_reg_sun_am').prop('checked', false);
								(reply[key].sun_pm == "1") ? $('#input_reg_sun_pm').prop('checked', true) : $('#input_reg_sun_pm').prop('checked', false);
								(reply[key].sun_eve == "1") ? $('#input_reg_sun_eve').prop('checked', true) : $('#input_reg_sun_eve').prop('checked', false);
								(reply[key].anytime == "1") ? $('#input_reg_anytime').prop('checked', true) : $('#input_reg_anytime').prop('checked', false);
								

								$('#reg-ic-check-modal').modal('hide');
							});
				    	}
				    }
				    else {
				    	// no result found in student and registartion table
				    	if(ic.trim() == "") {
				    		ic='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="student_new_ic_check_model_ic">'+ 
									'<label>IC Number Input</label>' +
									'<div class="form-control">' + ic + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related registration info found!<br>Please input valid IC number or register fisrt.</label>' + 
								'</div>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
<form role="form" id="student_reg_form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_ic">*IC Number(准证号码)</label>
			<input class="form-control" id="input_reg_ic" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="reg_new_ic_check" data-toggle="modal" data-target="#reg-ic-check-modal">Check</a>
		</div>
		<div class="col-xs-2">Check if this student had registered!</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_date">*Register Date(报名日期)</label>
			<input class="form-control" id="input_reg_date" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_reg_branch_student">*Student Branch(学生所在分部)</label>
			<select class="form-control" id="input_reg_branch_student" data-parsley-trigger="blur" required></select>
		</div>
		<div class="col-xs-4">
			<label for="input_reg_no">*Register Number(报名号码)</label>
			<input class="form-control" id="input_reg_no" data-parsley-trigger="blur" required>
		</div>
	</div>
<!-- 	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_op">*Register Operator(操作员)</label>
			<select class="form-control" id="input_reg_op" data-parsley-trigger="blur" required></select>
		</div>
		<div class="col-xs-4">
			<label for="input_reg_branch">*Register Branch(报名所在分部)</label>
			<select class="form-control" id="input_reg_branch" data-parsley-trigger="blur" required></select>
		</div>
	</div> -->
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_remark">Remark(备注)</label>
			<textarea class="form-control" id="input_reg_remark" rows="3"></textarea>
		</div>
	</div>
	<h4>想要上课时间</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_any_am">
		          	<input type="checkbox" id="input_reg_any_am"> 平时早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_any_pm">
		          	<input type="checkbox" id="input_reg_any_pm"> 平时下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_any_eve">
		          	<input type="checkbox" id="input_reg_any_eve"> 平时晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sat_am">
		          	<input type="checkbox" id="input_reg_sat_am"> 拜六早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sat_pm">
		          	<input type="checkbox" id="input_reg_sat_pm"> 拜六下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sat_eve">
		          	<input type="checkbox" id="input_reg_sat_eve"> 拜六晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sun_am">
		          	<input type="checkbox" id="input_reg_sun_am"> 拜天早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sun_pm">
		          	<input type="checkbox" id="input_reg_sun_pm"> 拜天下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_sun_eve">
		          	<input type="checkbox" id="input_reg_sun_eve"> 拜天晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_anytime">
		          	<input type="checkbox" id="input_reg_anytime"> 任意时间
		        </label>
		    </div>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-7"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="reg_new_create">新建</a>
	</div>
	<div class="col-xs-3">
		<a class="button glow button-rounded button-flat" id="reg_new_update">更新报名信息</a>
	</div>
</div>
</div>

<!-- Registration IC Check Modal -->
<div class="modal fade" id="reg-ic-check-modal" tabindex="-1" role="dialog" aria-labelledby="reg_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="reg_ic_check_modal_label">Registered Student Check</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>