<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_financial_search_from').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_financial_search_to').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
	</script>
</head>
<div class="highlight">
	<form role="form">
		<div class="row">
			<div class="col-xs-4">
				<input class="form-control" id="input_financial_search_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_financial_search_to" placeholder="To">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_financial_search_receipt_name" placeholder="收款人">
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-xs-8"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="financial_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="financial_to_excel">To Excel</a>
		</div>
	</div>
</div>