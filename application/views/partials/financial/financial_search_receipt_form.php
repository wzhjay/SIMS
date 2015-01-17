<head>
	<meta charset="utf-8">

	<script>
		var selected_receipt_record_id = 0;
		$(document).ready(function($) {
			$('#input_financial_search_receipt_date_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_financial_search_receipt_date_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#financial_receipt_search_submit').on('click', function() {
				search_receipt_records_by_types();
			});

			receipt_search_load_branches();
			receipt_search_course_type();
		});

		function receipt_search_load_branches() {
			var branches = $('#input_financial_search_receipt_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		branches.append('<option id="receipt_search_branch_ALL">ALL</option>');
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="receipt_search_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("fail to load braches");
			        }
			    }
			});//End ajax
		}

		function receipt_search_course_type() {
			var types = $('#input_financial_search_receipt_course_type');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllCourses",
			    data:{},
			    success:function(json){
			    	types.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		types.append('<option value="ALL">ALL</option>');
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				types.append('<option id="receipt_search_course_type_'+ reply[key].id +'" + value="'+ reply[key].code +'">' + reply[key].type + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("fail to load courses");
			        }
			    },
			});//End ajax
		}

		function search_receipt_records_by_types() {
			var student_ic = $('#input_financial_search_receipt_student_ic').val();
			var receipt_no = $('#input_financial_search_receipt_num').val();
			var receipt_branch = $('#input_financial_search_receipt_branch option:selected').attr('id').split('_')[3];
			var course_type = $('#input_financial_search_receipt_course_type option:selected').val();
			var receipt_date_from = '0000-00-00';
			var receipt_date_to  = '2100-01-01';

			if($('#input_financial_search_receipt_date_from').val().trim() != "") {
				receipt_date_from = $('#input_financial_search_receipt_date_from').val();
			}

			if($('#input_financial_search_receipt_date_to').val().trim() != "") {
				receipt_date_to = $('#input_financial_search_receipt_date_to').val();
			}

			var target = $('#receipt_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchReceiptRecords",
			    data:{student_ic:student_ic, receipt_no:receipt_no, receipt_branch:receipt_branch, course_type:course_type, receipt_date_from:receipt_date_from, receipt_date_to:receipt_date_to},
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
										'<div class="panel-group" id="receipt_search_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="receipt_search_collapse_'+key+'" href="#receipt_search_collapse_body_'+key+'">Receipt Date: <b>' + reply[key].receipt_date + '</b>  /  Receipt Amount: <b>' + reply[key].receipt_amount + '</b>  /  IC: <b>' + reply[key].student_ic + '</b>  /  Course Type: <b>' + reply[key].course_type + '</b></a>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="receipt_search_update_'+reply[key].receipt_id+'" >Update</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="receipt_search_delete_'+reply[key].receipt_id+'" data-toggle="modal" data-target="#receipt-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													'</h4>' +
												'</div>' +
												'<div id="receipt_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>Student IC: ' + reply[key].student_ic + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Receipt No.: ' + reply[key].receipt_no + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>Date: ' + reply[key].receipt_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>Amount: ' + reply[key].receipt_amount + '</div>' + 
														'</div>' +
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-3">' +
															"<div>Payee's Name: "+ reply[key].payee_name + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>是否补交: '+ reply[key].makeup + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>是否老学员: '+ reply[key].student_before + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>收据类型: '+ reply[key].receipt_type + '</div>' + 
														'</div>' +
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>所在分部: ' + reply[key].name + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">'+ 
															'<div>Created: ' + reply[key].created + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>Modified: ' + reply[key].modified + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">'+ 
															'<div>备注: ' + reply[key].receipt_remark + '</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
				            	}
				            }

				            $('#receipt_search_results .button').on('click', function() {
				 				var el_id = $(this).attr('id').split('_');
				 				var receipt_record_id = el_id[3];
				 				selected_receipt_record_id = receipt_record_id;
				 				if(el_id[2] == "update") {
				 					// update receipt record
				 					load_receipt_record(receipt_record_id);
				 				} else if(el_id[2] == "delete") {
				 					// delete receipt record
				 					var modalBody = $('#receipt_delete_modal_label').closest('.modal-content').find('.modal-body');
									modalBody.empty();
									modalBody.append(
										'<div class="row">' + 
											'<div class="col-xs-10">'+
												'<label>Sure you want to delete this student receipt record?</label><br>' +
												'<label>确定你要删除这条学生收据记录？</label>' +
											'</div>' +	
										'</div>'
									); 
				 					$('#receipt_delete_modal_confirm').on('click', function() {
										delete_receipt_by_id(receipt_record_id);
									});
				 				}
				 			});
			        	}
			        }
			    },
			});//End ajax
		}

		function load_receipt_record(receipt_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "getReceiptRecordByID",
			    data:{receipt_id:receipt_record_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				$('#input_financial_receipt_student_ic').val(reply[key].student_ic);
			    				$('#input_financial_receipt_type option[value="'+reply[key].receipt_type+'"]').attr('selected', 'selected');
								$('#input_financial_receipt_num').val(reply[key].receipt_no);
								$('#input_financial_receipt_payee').val(reply[key].payee_name);
								$('#input_financial_receipt_date').val(reply[key].receipt_date);
								$('#input_financial_receipt_amount').val(reply[key].receipt_amount);
								(reply[key].makeup == "YES") ? $('#input_financial_receipt_makeup').prop('checked', true) : $('#input_financial_receipt_makeup').prop('checked', false);
								(reply[key].student_before == "YES") ? $('#input_financial_receipt_student_before').prop('checked', true) : $('#input_financial_receipt_student_before').prop('checked', false);
								
								$('#input_financial_receipt_course_type option[value="'+reply[key].course_type+'"]').attr('selected', 'selected');
								$('#input_financial_receipt_letter_type option[value="'+reply[key].letter_type+'"]').attr('selected', 'selected');

								$('#input_financial_receipt_reg_num').val(reply[key].reg_no);
								$('#input_financial_receipt_related_receipt').val(reply[key].related_receipt);
								$('#input_financial_receipt_related_receipt_amount').val(reply[key].related_receipt_amount);
								
								$('#input_financial_receipt_branch option[id="receipt_branch_'+reply[key].receipt_branch_id+'"]').attr('selected', 'selected');
								$('#input_financial_receipt_op option[id="receipt_op_'+reply[key].receipt_op_id+'"]').attr('selected', 'selected');

								$('#input_financial_receipt_remark').val(reply[key].receipt_remark);
			            	}
			            }
			            $("html, body").animate({ scrollTop: 0 }, "slow");
			            toastr.info("Update receipt record on above form!");
			        }else{
			        	toastr.error("Fail to load receipt record");
			        }
			    }
			});//End ajax
		}

		function delete_receipt_by_id(receipt_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteReceiptInfoByID",
			    data:{receipt_id:receipt_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    // clear deleted element
					    $('#receipt_search_delete_' + receipt_record_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to delete student receipt info!");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchReceiptRecordsDownload" method="POST" target="_blank">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_student_ic">Student IC</label>
				<input name="student_ic" class="form-control" id="input_financial_search_receipt_student_ic">
			</div>
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_num">Receipt Number</label>
				<input name="receipt_no" class="form-control" id="input_financial_search_receipt_num" >
			</div>
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_branch">Branch</label>
				<select name="receipt_branch" class="form-control" id="input_financial_search_receipt_branch"></select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_date_from">Receipt Date From</label>
				<input name="receipt_date_from" class="form-control" id="input_financial_search_receipt_date_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_date_to">Receipt Date To</label>
				<input name="receipt_date_to" class="form-control" id="input_financial_search_receipt_date_to" placeholder="To">
			</div>
			<div class="col-xs-4">
				<label for="input_financial_search_receipt_course_type">Course Type</label>
				<select name="course_type" class="form-control" id="input_financial_search_receipt_course_type"></select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-8"></div>
			<div class="col-xs-2">
				<a class="button glow button-rounded button-flat" id="financial_receipt_search_submit">Search</a>
			</div>
			<div class="col-xs-2">
				<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="financial_receipt_search_to_excel">
			</div>
		</div>
	</form>
	<br>
	<div id="receipt_search_results"></div>
</div>

<!-- receipt delete Modal -->
<div class="modal fade" id="receipt-delete-modal" tabindex="-1" role="dialog" aria-labelledby="receipt_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="receipt_delete_modal_label">Delete Receipt Record</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="receipt_delete_modal_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>