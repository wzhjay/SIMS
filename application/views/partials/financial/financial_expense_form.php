 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#financial_expense_form').parsley();
			$('#input_financial_exp_date').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#financial_exp_create').on('click', function() {
				create_new_expense_record();
			});

			$('#financial_exp_update').on('click', function() {
				update_expense_record();
			});
		});


		function create_new_expense_record() {
			var exp_type = $('#input_financial_exp_type option:selected').val();
			var exp_name = $('#input_financial_exp_name').val();
			var exp_sign_name = $('#input_financial_exp_sign_name').val();
			var exp_date = $('#input_financial_exp_date').val();
			var exp_amount = $('#input_financial_exp_amount').val();
			var exp_remark = $('#input_financial_exp_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "createExpenseRecord",
			    data:{	exp_type:exp_type, 
			    		exp_name:exp_name, 
			    		exp_sign_name:exp_sign_name, 
			    		exp_date:exp_date, 
			    		exp_amount:exp_amount, 
			    		exp_remark:exp_remark},
			    success:function(json){
			    	if(json.trim() == '1') {
					    toastr.success("Create expense record success!");
					    clear_exp_form_inputs();
					}else{
						toastr.error("Fail to insert expense record!");
					}
			    }
			});//End ajax
		}

		function update_expense_record() {
			var exp_type = $('#input_financial_exp_type option:selected').val();
			var exp_name = $('#input_financial_exp_name').val();
			var exp_sign_name = $('#input_financial_exp_sign_name').val();
			var exp_date = $('#input_financial_exp_date').val();
			var exp_amount = $('#input_financial_exp_amount').val();
			var exp_remark = $('#input_financial_exp_remark').val();

			$.ajax({
				type:"post",
			    url:window.api_url + "updateExpenseRecord",
			    data:{	exp_id:selected_expense_record_id,
			    		exp_type:exp_type, 
			    		exp_name:exp_name, 
			    		exp_sign_name:exp_sign_name, 
			    		exp_date:exp_date, 
			    		exp_amount:exp_amount, 
			    		exp_remark:exp_remark},
			    success:function(json){
			    	if(json.trim() == '2') {
					    toastr.success("Update expense record success!");
					    clear_exp_form_inputs();
					}else{
						toastr.error("Fail to insert expense record!");
					}
			    }
			});//End ajax
		}

		function clear_exp_form_inputs(exp_type) {
			$('#input_financial_exp_name').val('');
			$('#input_financial_exp_sign_name').val('');
			$('#input_financial_exp_date').val('');
			$('#input_financial_exp_amount').val('');
			$('#input_financial_exp_remark').val('');
		}
	</script>
</head>
<div class="highlight">
<form role="form" id="financial_expense_form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_exp_type">*支出类型</label>
			<select class="form-control" id="input_financial_exp_type">
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
			<label for="input_financial_exp_name">*支出人</label>
			<input class="form-control" id="input_financial_exp_name" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_exp_sign_name">*签收人</label>
			<input class="form-control" id="input_financial_exp_sign_name" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_exp_date">*支出日期</label>
			<input class="form-control" id="input_financial_exp_date" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_exp_amount">*支出金额</label>
			<input class="form-control" id="input_financial_exp_amount" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_exp_remark">Remark(备注)</label>
			<textarea class="form-control" id="input_financial_exp_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_exp_create">新建</a>
	</div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_exp_update">更新支出信息</a>
	</div>
</div>
</div>