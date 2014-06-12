 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_reg_date').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_reg_start_date').datepicker({
				format: 'yyyy-mm-dd'
			});

			reg_load_admin_users();
			reg_load_branches();

			$('#reg_new_submit').on('click', function() {
				insert_new_reg();
			});
		});


		function reg_load_admin_users() {
			var users = $('#input_reg_op');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllAdminUsers",
			    data:{},
			    success:function(json){
			    	users.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		users.append('<option id="new_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
			            	}
			            }
			        }else{
			        	toastr.error("Fail to load users!");
			        }
			    },
			});//End ajax
		}

		function reg_load_branches() {
			var branches = $('#input_reg_branch');
			var branches_stu = $('#input_reg_branch_student');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="admin_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    				branches_stu.append('<option id="admin_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load braches!");
			        }
			    },
			});//End ajax
		}

		function insert_new_reg() {
			var ic = $('#input_reg_ic').val();
			var reg_date = $('#input_reg_date').val();
			var reg_branch = $('#input_reg_branch option:selected').attr('id').split('_');
			var reg_branch_id = reg_branch[2];
			var reg_no = $('#input_reg_no').val();
			var reg_op = $('#input_reg_op option:selected').attr('id').split('_');
			var reg_op_id = reg_op[2];
			var reg_start_date = $('#input_reg_start_date').val();
			var reg_branch_stu = $('#input_reg_branch_student option:selected').attr('id').split('_');
			var reg_branch_stu_id = reg_branch_stu[2];
			var remark = $('#input_reg_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "createNewRegister",
			    data:{ic:ic, reg_date:reg_date, student_branch_id:reg_branch_stu_id, reg_branch_id:reg_branch_id, reg_op_id:reg_op_id, reg_no:reg_no, start_date_wanted:reg_start_date, remark:remark},
			    success:function(json){
			    	if(json != null) {
					    var reply = $.parseJSON(json);
					    if(reply == '1') {
					    	toastr.success("Register success!");
					    	clear_form_input_values();
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

		function clear_form_input_values() {
			$('#input_reg_ic').val('');
			$('#input_reg_date').val('');
			$('#input_reg_no').val('');
			$('#input_reg_start_date').val('');
			$('#input_reg_remark').val('');
		}
	</script>
</head>
<div class="highlight">
<form role="form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_ic">IC Number</label>
			<input class="form-control" id="input_reg_ic" >
		</div>
		<div class="col-xs-4">
			<label for="input_reg_date">Register Date</label>
			<input class="form-control" id="input_reg_date" >
		</div>
		<div class="col-xs-4">
			<label for="input_reg_branch">Register Branch</label>
			<select class="form-control" id="input_reg_branch"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_no">Register Number</label>
			<input class="form-control" id="input_reg_no" >
		</div>
		<div class="col-xs-4">
			<label for="input_reg_op">Register Operator</label>
			<select class="form-control" id="input_reg_op"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_reg_start_date">Start Date Wanted</label>
			<input class="form-control" id="input_reg_start_date" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_branch_student">Student Branch</label>
			<select class="form-control" id="input_reg_branch_student"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_remark">Remark</label>
			<textarea class="form-control" id="input_reg_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="reg_new_submit">Submit</a>
	</div>
</div>
</div>