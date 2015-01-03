 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#financial_receipt_form').parsley();
			$('#input_financial_receipt_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			receipt_load_course_type();
			// receipt_load_admin_users();
			// receipt_load_branches();

			$('#financial_receipt_create').on('click', function() {
				create_new_receipt_record();
			});

			$('#financial_receipt_update').on('click', function() {
				update_receipt_record();
			});
			
			$('#financial_receipt_student_ic_check').on('click', function() {
				check_receipt_student_ic();
			});

			$('#financial_receipt_num_check').on('click', function() {
				check_receipt_num();
			});
		});

		// function receipt_load_admin_users() {
		// 	var users = $('#input_financial_receipt_op');
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
		// 	            		users.append('<option id="receipt_op_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
		// 	            	}
		// 	            }
		// 	        }else{
		// 	        	toastr.error("Fail to load users!");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }

		// function receipt_load_branches() {
		// 	var branches = $('#input_financial_receipt_branch');
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
		// 	    				branches.append('<option id="receipt_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
		// 	    			}
		// 	    		}
		// 	        }else{
		// 	        	toastr.error("Fail to load braches!");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }

		function receipt_load_course_type() {
			var types = $('#input_financial_receipt_course_type');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllCourses",
			    data:{},
			    success:function(json){
			    	types.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		types.append('<option value="NA">请选择</option>');
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				types.append('<option id="receipt_course_type_'+ reply[key].id +'" + value="'+ reply[key].code +'">' + reply[key].type + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("Fail to load courses!");
			        }
			    },
			});//End ajax
		}

		function create_new_receipt_record() {
			var student_ic = $('#input_financial_receipt_student_ic').val();
			var receipt_type = $('#input_financial_receipt_type option:selected').val();
			var receipt_no = $('#input_financial_receipt_num').val();
			var payee_name = $('#input_financial_receipt_payee').val();
			var receipt_date = $('#input_financial_receipt_date').val();
			var receipt_amount = $('#input_financial_receipt_amount').val();
			var makeup = $('#input_financial_receipt_makeup').is(':checked') ? 'YES' : 'NO';
			var student_before = $('#input_financial_receipt_student_before').is(':checked') ? 'YES' : 'NO';
			var course_type = $('#input_financial_receipt_course_type option:selected').val();
			var letter_type = $('#input_financial_receipt_letter_type option:selected').val();
			var reg_no = $('#input_financial_receipt_reg_num').val();
			// var related_receipt = $('#input_financial_receipt_related_receipt').val();
			// var related_receipt_amount = $('#input_financial_receipt_related_receipt_amount').val();
			// var receipt_branch = $('#input_financial_receipt_branch option:selected').attr('id').split('_');
			// var receipt_branch_id = receipt_branch[2];
			// var receipt_op = $('#input_financial_receipt_op option:selected').attr('id').split('_');
			// var receipt_op_id = receipt_op[2];
			var receipt_remark = $('#input_financial_receipt_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "createNewReceiptRecord",
			    data:{	student_ic:student_ic,
			    		receipt_type:receipt_type,
			    		receipt_no:receipt_no, 
			    		payee_name:payee_name, 
			    		receipt_date:receipt_date, 
			    		receipt_amount:receipt_amount, 
			    		makeup:makeup, 
			    		student_before:student_before,
			    		course_type:course_type,
			    		reg_no:reg_no,
			    		// related_receipt:related_receipt,
			    		// related_receipt_amount:related_receipt_amount,
			    		// receipt_branch_id:receipt_branch_id,
			    		// receipt_op_id:receipt_op_id,
			    		receipt_remark:receipt_remark},
			    success:function(json){
			    	if(json.trim() == '1') {
					    toastr.success("Create new receipt record success!");
					    clear_receipt_from_inputs();
					}else{
						toastr.error("Fail to create receipt record!");
					}
			    }
			});//End ajax
		}

		function update_receipt_record() {
			var student_ic = $('#input_financial_receipt_student_ic').val();
			var receipt_type = $('#input_financial_receipt_type option:selected').val();
			var receipt_no = $('#input_financial_receipt_num').val();
			var payee_name = $('#input_financial_receipt_payee').val();
			var receipt_date = $('#input_financial_receipt_date').val();
			var receipt_amount = $('#input_financial_receipt_amount').val();
			var makeup = $('#input_financial_receipt_makeup').is(':checked') ? 'YES' : 'NO';
			var student_before = $('#input_financial_receipt_student_before').is(':checked') ? 'YES' : 'NO';
			var course_type = $('#input_financial_receipt_course_type option:selected').val();
			var letter_type = $('#input_financial_receipt_letter_type option:selected').val();
			var reg_no = $('#input_financial_receipt_reg_num').val();
			// var related_receipt = $('#input_financial_receipt_related_receipt').val();
			// var related_receipt_amount = $('#input_financial_receipt_related_receipt_amount').val();
			// var receipt_branch = $('#input_financial_receipt_branch option:selected').attr('id').split('_');
			// var receipt_branch_id = receipt_branch[2];
			// var receipt_op = $('#input_financial_receipt_op option:selected').attr('id').split('_');
			// var receipt_op_id = receipt_op[2];
			var receipt_remark = $('#input_financial_receipt_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "updateReceiptRecord",
			    data:{	receipt_id:selected_receipt_record_id,
			    		student_ic:student_ic,
			    		receipt_type:receipt_type,
			    		receipt_no:receipt_no, 
			    		payee_name:payee_name, 
			    		receipt_date:receipt_date, 
			    		receipt_amount:receipt_amount, 
			    		makeup:makeup, 
			    		student_before:student_before,
			    		course_type:course_type,
			    		letter_type:letter_type,
			    		reg_no:reg_no,
			    		// related_receipt:related_receipt,
			    		// related_receipt_amount:related_receipt_amount,
			    		// receipt_branch_id:receipt_branch_id,
			    		// receipt_op_id:receipt_op_id,
			    		receipt_remark:receipt_remark},
			    success:function(json){
			    	if(json.trim() == '2') {
					    toastr.success("Update receipt record success!");
					    clear_receipt_from_inputs();
					}else{
						toastr.error("Fail to update receipt record!");
					}
			    }
			});//End ajax
		}

		function clear_receipt_from_inputs() {
			$('#input_financial_receipt_student_ic').val('');
			$('#input_financial_receipt_num').val('');
			$('#input_financial_receipt_payee').val('');
			$('#input_financial_receipt_date').val('');
			$('#input_financial_receipt_amount').val('');
			$('#input_financial_receipt_makeup').prop('checked', false);
			$('#input_financial_receipt_student_before').prop('checked', false);
			$('#input_financial_receipt_course_type option[value="NA"]').attr('selected', 'selected');
			$('#input_financial_receipt_letter_type option[value="NA"]').attr('selected', 'selected');
			$('#input_financial_receipt_reg_num').val('');
			// $('#input_financial_receipt_related_receipt').val('');
			// $('#input_financial_receipt_related_receipt_amount').val('');
			$('#input_financial_receipt_remark').val('');
		}

		function check_receipt_student_ic() {
			var ic = $('#input_financial_receipt_student_ic').val();
			// check if student bisic info exist, can update basic indo for this student
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#receipt_student_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.empty();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'Stundet info existed!' + 
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-4" id="receipt_student_ic_check_model_ic">'+ 
											'<label>IC Number</label>' +
											'<div class="form-control">' + ic + '</div>' +
										'</div>' + 
										'<div class="col-xs-4">' + 
											'<label for="receipt_student_ic_check_model_student_name">Name</label>' + 
											'<div class="form-control" id="receipt_student_ic_check_model_student_name">' + reply[key].firstname + ' ' + reply[key].lastname + '</div>' + 
										'</div>' +
										'<div class="col-xs-4">' +
											'<label for="receipt_student_ic_check_model_student_tel">Tel</label>' +
											'<div class="form-control" id="receipt_student_ic_check_model_student_tel">'+ reply[key].tel + '</div>' + 
										'</div>' +
									'</div>'
								);
					        }
				    	}
				    }
				    else {
				    	// no result found in student table
				    	if(ic.trim() == "") {
				    		ic='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="receipt_student_ic_check_model_ic">'+ 
									'<label>IC Number</label>' +
									'<div class="form-control">' + ic + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related student info found!<br>Please input valid IC number.</label>' + 
								'</div>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function check_receipt_num() {
			var receipt_no = $('#input_financial_receipt_num').val();
			// check if student bisic info exist, can update basic indo for this student
			$.ajax({
				type:"post",
			    url:window.api_url + "getReceiptByNo",
			    data:{receipt_no:receipt_no},
			    success:function(json){
			    	var modalBody = $('#receipt_num_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.empty();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'Receipt record existed!' + 
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-2">'+ 
											'<label>Receipt No.</label>' +
											'<div class="form-control">' + receipt_no + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">' + 
											'<label>Stundet IC</label>' + 
											'<div class="form-control">' + reply[key].student_ic + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label>Date</label>' +
											'<div class="form-control">'+ reply[key].receipt_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label>Amount</label>' +
											'<div class="form-control">'+ reply[key].receipt_amount + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label>Payee</label>' +
											'<div class="form-control">'+ reply[key].payee_name + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="receipt_num_check_modal_update_' + reply[key].receipt_id + '">Update</a>' + 
										'</div>' +
									'</div>'
								);
					        }
				    	}

				    	$('#financial-receipt-num-modal .button').on('click', function() {
				    		var receipt_record_id = $(this).attr('id').split('_')[5];
				    		selected_receipt_record_id = receipt_record_id;
				    		load_receipt_record(receipt_record_id);
				    		$('#financial-receipt-num-modal').modal('hide');
				    	});
				    }
				    else {
				    	// no result found in student table
				    	if(receipt_no.trim() == "") {
				    		receipt_no='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4">'+ 
									'<label>Receipt Number</label>' +
									'<div class="form-control">' + receipt_no + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related receipt record found!<br>Please input valid receipt number.</label>' + 
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
<form role="form" id="financial_receipt_form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_student_ic">*Student IC(准证号码)</label>
			<input class="form-control" id="input_financial_receipt_student_ic" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="financial_receipt_student_ic_check" data-toggle="modal" data-target="#financial-receipt-student-modal">Check</a>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_type">*收据类型</label>
			<select class="form-control" id="input_financial_receipt_type">
            	<option value="SSA">SSA</option>
	            <option value="Link1" selected="selected">A2I</option>
    	        <option value="Changchun">Changchun</option>
          	</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_num">*Receipt Number(收据号码)</label>
			<input class="form-control" id="input_financial_receipt_num" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="financial_receipt_num_check" data-toggle="modal" data-target="#financial-receipt-num-modal">Check</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_payee">*Payee's Name(收款人)</label>
			<input class="form-control" id="input_financial_receipt_payee" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_date">*Receipt Date(收款日)</label>
			<input class="form-control" id="input_financial_receipt_date" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_amount">*Receipt Amount(收款金额)</label>
			<input class="form-control" id="input_financial_receipt_amount" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_financial_receipt_makeup">
		          	<input type="checkbox" id="input_financial_receipt_makeup"> 是否补交学费
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_financial_receipt_student_before">
		          	<input type="checkbox" id="input_financial_receipt_student_before"> 是否老学员
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_course_type">*Course Type(课程类型)</label>
			<select class="form-control" id="input_financial_receipt_course_type"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_letter_type">*Letter Type(政府信类型)</label>
			<select class="form-control" id="input_financial_receipt_letter_type">
		        <option value="NA">NA</option>
		        <option value="wts1">wts1</option>
		        <option value="wts2">wts2</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_reg_num">*报名表号码(报名表号码)</label>
			<input class="form-control" id="input_financial_receipt_reg_num" data-parsley-trigger="blur" required>
		</div>
	</div>
	<!-- <div class="row"> -->
<!-- 		<div class="col-xs-4">
			<label for="input_financial_receipt_related_receipt">相关收据</label>
			<input class="form-control" id="input_financial_receipt_related_receipt" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_related_receipt_amount">对应金额</label>
			<input class="form-control" id="input_financial_receipt_related_receipt_amount" >
		</div> -->
	<!-- </div> -->
	<div class="row">
<!-- 		<div class="col-xs-4">
			<label for="input_financial_receipt_branch">Branch</label>
			<select class="form-control" id="input_financial_receipt_branch"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_op">Operator</label>
			<select class="form-control" id="input_financial_receipt_op"></select>
		</div> -->
		<div class="col-xs-4">
			<label for="input_financial_receipt_remark">Remark(备注)</label>
			<textarea class="form-control" id="input_financial_receipt_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_receipt_create">新建</a>
	</div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_receipt_update">更新收据信息</a>
	</div>
</div>
</div>

<!-- Receipt Student IC Check Modal -->
<div class="modal fade" id="financial-receipt-student-modal" tabindex="-1" role="dialog" aria-labelledby="receipt_student_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="receipt_student_ic_check_modal_label">Student Recepits Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Receipt Number Check Modal -->
<div class="modal fade" id="financial-receipt-num-modal" tabindex="-1" role="dialog" aria-labelledby="receipt_num_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="receipt_num_check_modal_label">Receipt Infomation</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>