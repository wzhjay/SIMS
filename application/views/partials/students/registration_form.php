<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 08.05.2014 
 -->
 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_reg_date').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
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
			<input class="form-control" id="input_reg_branch" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_no">Register Number</label>
			<input class="form-control" id="input_reg_no" >
		</div>
		<div class="col-xs-4">
			<label for="input_reg_op">Register Operator</label>
			<input class="form-control" id="input_reg_op" >
		</div>
		<div class="col-xs-4">
			<label for="input_reg_start_date">Start Date Wanted</label>
			<input class="form-control" id="input_reg_start_date" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_reg_status">Status</label>
			<input class="form-control" id="input_reg_status" >
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