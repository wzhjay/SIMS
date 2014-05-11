<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 08.05.2014 
 -->
 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_reg_search_from').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_reg_search_to').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="reg_search">
				<div class="input-daterange" id="reg_datepicker">
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_from" placeholder="From">
					</div>
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_to" placeholder="To">
					</div>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_to_excel">To Excel</a>
		</div>
	</div>
</div>