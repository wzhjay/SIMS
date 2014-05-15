 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_financial_receipt_date').datepicker({
				format: 'dd/mm/yyyy'
			});

			load_course_type();
		});

		function load_course_type() {
			var branches = $('#input_financial_course_type');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllCourses",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="course_type_'+ reply[key].id +'" + value="'+ reply[key].code +'">' + reply[key].type + '</option>');
			    			}
			    		}
			        }else{
			        	alert("fail to load courses");
			        }
			    },
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
<form role="form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_student">Student</label>
			<select class="form-control" id="input_financial_student"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_num">Receipt Number</label>
			<input class="form-control" id="input_financial_receipt_num" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_payee">Payee's Name</label>
			<input class="form-control" id="input_financial_payee" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_date">Receipt Date</label>
			<input class="form-control" id="input_financial_receipt_date" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_amount">Receipt Amount</label>
			<input class="form-control" id="input_financial_amount" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_financial_makeup">
		          	<input type="checkbox" id="input_financial_makeup"> 是否补交学费
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_financial_student_before">
		          	<input type="checkbox" id="input_financial_student_before"> 是否老学员
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_course_type">Course Type</label>
			<select class="form-control" id="input_financial_course_type"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_letter_type">Letter Type</label>
			<select class="form-control" id="input_financial_letter_type">
		        <option value="NA">NA</option>
		        <option value="wts1">wts1</option>
		        <option value="wts2">wts2</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_course_code">Course Code</label>
			<input class="form-control" id="input_financial_course_code" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_reg_num">报名表号码</label>
			<input class="form-control" id="input_financial_reg_num" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_related_receipt">相关收据</label>
			<input class="form-control" id="input_financial_related_receipt" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_related_receipt_amount">对应金额</label>
			<input class="form-control" id="input_financial_related_receipt_amount" >
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
		<a class="button glow button-rounded button-flat" id="financial_income_submit">Submit</a>
	</div>
</div>
</div>