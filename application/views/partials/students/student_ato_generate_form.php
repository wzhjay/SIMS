<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_student_ato_search_data').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});
		});
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="student_ato_search">
				<div class="input-daterange" id="student_ato_datepicker">
					<div class="col-xs-2">
						<label for="input_student_ato_search_data">请选择考试时间</label>
					</div>
					<div class="col-xs-4">
						<input class="form-control" id="input_student_ato_search_data" placeholder="Exam Date">
					</div>
					<div class="col-xs-2"></div>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_ato_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_ato_to_excel">To Excel</a>
		</div>
	</div>
</div>