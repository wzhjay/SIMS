 <head>
	<meta charset="utf-8">

	<script>
		var selected_expense_record_id = 0;
		$(document).ready(function($) {
			$('#input_search_financial_exp_date_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#input_search_financial_exp_date_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#financial_exp_search_submit').on('click', function() {
				search_expense_records_by_types();
			});
		});

		function search_expense_records_by_types() {
			var exp_type = $('#input_search_financial_exp_type option:selected').val();
			var exp_name = $('#input_search_financial_exp_name').val();
			var exp_sign_name = $('#input_search_financial_exp_sign_name').val();

			var exp_date_from = '0000-00-00';
			var exp_date_to  = '2100-01-01';

			if($('#input_search_financial_exp_date_from').val().trim() != "") {
				exp_date_from = $('#input_search_financial_exp_date_from').val();
			}

			if($('#input_search_financial_exp_date_to').val().trim() != "") {
				exp_date_to = $('#input_search_financial_exp_date_to').val();
			}

			var target = $('#expense_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchExpenseRecords",
			    data:{exp_type:exp_type, exp_name:exp_name, exp_sign_name:exp_sign_name, exp_date_from:exp_date_from, exp_date_to:exp_date_to},
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
										'<div class="panel-group" id="expense_search_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="expense_search_collapse_'+key+'" href="#expense_search_collapse_body_'+key+'">Exp Date: <b>' + reply[key].exp_date + '</b>  /  Exp Amount: <b>' + reply[key].exp_amount + '</b>  /  Exp Type: <b>' + reply[key].exp_type + '</b></a>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="expense_search_update_'+reply[key].exp_id+'" >Update</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="expense_search_delete_'+reply[key].exp_id+'" data-toggle="modal" data-target="#expense-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													'</h4>' +
												'</div>' +
												'<div id="expense_search_collapse_body_'+key+'" class="panel-collapse collapse">' + 
												'<div class="panel-body">' + 
													'<div class="row">' + 
														'<div class="col-xs-3">'+ 
															'<div>类型: ' + reply[key].exp_type + '</div>' +
														'</div>' + 
														'<div class="col-xs-3">' +
															'<div>支出人: ' + reply[key].exp_name + '</div>' + 
														'</div>' +
														'<div class="col-xs-3">' +
															'<div>签收人: ' + reply[key].exp_sign_name + '</div>' + 
														'</div>' +
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-4">' +
															'<div>支出日期: '+ reply[key].exp_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<div>支出金额: '+ reply[key].exp_amount + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">'+ 
															'<div>备注: ' + reply[key].exp_remark + '</div>' +
														'</div>' + 
													'</div>' + 
													'<hr>' + 
													'<div class="row">' + 
														'<div class="col-xs-6">'+ 
															'<div>Created: ' + reply[key].created + '</div>' +
														'</div>' + 
														'<div class="col-xs-6">' +
															'<div>Modified: ' + reply[key].modified + '</div>' + 
														'</div>' +
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
				            	}
				            }

				            $('#expense_search_results .button').on('click', function() {
				 				var el_id = $(this).attr('id').split('_');
				 				var expense_record_id = el_id[3];
				 				selected_expense_record_id = expense_record_id;
				 				if(el_id[2] == "update") {
				 					// update expense record
				 					load_expense_record(expense_record_id);
				 				} else if(el_id[2] == "delete") {
				 					// delete expense record
				 					get_expense_by_id(expense_record_id);

				 					$('#expense_delete_modal_confirm').on('click', function() {
										delete_expense_by_id(expense_record_id);
									});
				 				}
				 			});
			        	}
			        }
			    },
			});//End ajax
		}

 		// click delete button
 		function get_expense_by_id(expense_record_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "getExpenseRecordByID",
			    data:{exp_id:expense_record_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				var modalBody = $('#expense_delete_modal_label').closest('.modal-content').find('.modal-body');
			 					modalBody.empty();
			 					modalBody.append(
			 						'<div class="row">'+
							      		'<div class="col-xs-8">' +
							      			'<div class="highlight">'+
								      			'<div class="row">' + 
													'<div class="col-xs-4">'+ 
														'<div>类型: ' + reply[key].exp_type + '</div>' +
													'</div>' + 
													'<div class="col-xs-4">' +
														'<div>支出人: ' + reply[key].exp_name + '</div>' + 
													'</div>' +
													'<div class="col-xs-4">' +
														'<div>签收人: ' + reply[key].exp_sign_name + '</div>' + 
													'</div>' +
												'</div>' +
								      			'<div class="row">' + 
													'<div class="col-xs-4">'+ 
														'<div>支出日期: ' + reply[key].exp_date + '</div>' +
													'</div>' + 
													'<div class="col-xs-4">' +
														'<div>支出金额: ' + reply[key].exp_amount + '</div>' + 
													'</div>' +
													'<div class="col-xs-4">' +
														'<div>备注: ' + reply[key].exp_remark + '</div>' + 
													'</div>' +
												'</div>' +
											'</div>' +
							      		'</div>' +
							      		'<div class="col-xs-4">' +
							      			'<H4>Sure you want to delete this expense record?</h4>' +
							      		'</div>' +
							      	'</div>'
							    );
			            	}
			            }
			        }else{
			        	toastr.error("fail to load expense record");
			        }
			    }
			});//End ajax	
 		}

 		// click update button
 		function load_expense_record(expense_record_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "getExpenseRecordByID",
			    data:{exp_id:expense_record_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				$('#input_financial_exp_type option[value="'+reply[key].exp_type+'"]').attr('selected', 'selected');
			            		$('#input_financial_exp_name').val(reply[key].exp_name);
								$('#input_financial_exp_sign_name').val(reply[key].exp_sign_name);
								$('#input_financial_exp_date').val(reply[key].exp_date);
								$('#input_financial_exp_amount').val(reply[key].exp_amount);
								$('#input_financial_exp_remark').val(reply[key].exp_remark);
			            	}
			            }
			            $("html, body").animate({ scrollTop: 0 }, "slow");
			            toastr.info("Update expense record on above form!");
			        }else{
			        	toastr.error("fail to load expense record");
			        }
			    }
			});//End ajax
 		}

 		function delete_expense_by_id(expense_record_id) {
 			$.ajax({
				type:"post",
			    url:window.api_url + "deleteExpenseInfoByID",
			    data:{expense_id:expense_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    // clear deleted element
					    $('#expense_search_delete_' + expense_record_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to delete student expense info!");
					}
			    }
			});//End ajax
 		}

	</script>
</head>
<div class="highlight">
<form role="form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_search_financial_exp_type">支出类型</label>
			<select class="form-control" id="input_search_financial_exp_type">
		        <option value="NA">请选择</option>
		        <option value="refund">退款</option>
		        <option value="salary">工资</option>
		        <option value="transport">交通费</option>
		        <option value="commission">提成</option>
		        <option value="overtime pay">加班费</option>
		        <option value="subsidy">其他补贴</option>
		        <option value="offfice expense">办公支出</option>
		        <option value="headmaster temp expense">校长临时支出</option>
		        <option value="others">其他(请备注)</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_search_financial_exp_name">支出人</label>
			<input class="form-control" id="input_search_financial_exp_name" >
		</div>
		<div class="col-xs-4">
			<label for="input_search_financial_exp_sign_name">签收人</label>
			<input class="form-control" id="input_search_financial_exp_sign_name" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_search_financial_exp_date_from">支出日期 From</label>
			<input class="form-control" id="input_search_financial_exp_date_from" placeholder="From">
		</div>
		<div class="col-xs-4">
			<label for="input_search_financial_exp_date_to">支出日期 To</label>
			<input class="form-control" id="input_search_financial_exp_date_to" placeholder="To">
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_exp_search_submit">Search</a>
	</div>
</div>
<br>
<div id="expense_search_results"></div>
</div>


<!-- expense delete Modal -->
<div class="modal fade" id="expense-delete-modal" tabindex="-1" role="dialog" aria-labelledby="expense_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="expense_delete_modal_label">Delete Expense Record</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="expense_delete_modal_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>