 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_financial_exp_date').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
	</script>
</head>
<div class="highlight">
<form role="form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_exp_type">支出类型</label>
			<select class="form-control" id="input_financial_exp_type">
		        <option value="NA">请选择</option>
		        <option>退款</option>
		        <option>工资</option>
		        <option>交通费</option>
		        <option>提成</option>
		        <option>加班费</option>
		        <option>其他补贴</option>
		        <option>办公支出</option>
		        <option>校长临时支出</option>
		        <option>其他(请备注)</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_exp_name">支出人</label>
			<input class="form-control" id="input_financial_exp_name" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_exp_sign_name">签收人</label>
			<input class="form-control" id="input_financial_exp_sign_name" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_exp_date">支出日期</label>
			<input class="form-control" id="input_financial_exp_date" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_exp_amount">支出金额</label>
			<input class="form-control" id="input_financial_exp_amount" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_remark">Remark</label>
			<textarea class="form-control" id="input_financial_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_exp_submit">Submit</a>
	</div>
</div>
</div>