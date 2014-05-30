 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_financial_receipt_date').datepicker({
				format: 'yyyy-mm-dd'
			});

			load_course_type();
		});

		function load_course_type() {
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
			<label for="input_financial_receipt_student_ic">Student IC</label>
			<input class="form-control" id="input_financial_receipt_student_ic">
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="financial_receipt_student_ic_check" data-toggle="modal" data-target="#financial-receipt-student-modal">Check</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_num">Receipt Number</label>
			<input class="form-control" id="input_financial_receipt_num" >
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="financial_receipt_num_check" data-toggle="modal" data-target="#financial-receipt-num-modal">Check</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_payee">Payee's Name</label>
			<input class="form-control" id="input_financial_receipt_payee" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_date">Receipt Date</label>
			<input class="form-control" id="input_financial_receipt_date" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_amount">Receipt Amount</label>
			<input class="form-control" id="input_financial_receipt_amount" >
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
			<label for="input_financial_receipt_course_type">Course Type</label>
			<select class="form-control" id="input_financial_receipt_course_type"></select>
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_letter_type">Letter Type</label>
			<select class="form-control" id="input_financial_receipt_letter_type">
		        <option value="NA">NA</option>
		        <option value="wts1">wts1</option>
		        <option value="wts2">wts2</option>
		    </select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_reg_num">报名表号码</label>
			<input class="form-control" id="input_financial_receipt_reg_num" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_related_receipt">相关收据</label>
			<input class="form-control" id="input_financial_receipt_related_receipt" >
		</div>
		<div class="col-xs-4">
			<label for="input_financial_receipt_related_receipt_amount">对应金额</label>
			<input class="form-control" id="input_financial_receipt_related_receipt_amount" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_financial_receipt_remark">Remark</label>
			<textarea class="form-control" id="input_financial_receipt_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_receipt_create">Create</a>
	</div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="financial_receipt_update">Update</a>
	</div>
</div>
</div>

<!-- Receipt Student IC Check Modal -->
<div class="modal fade" id="financial-receipt-student-modal" tabindex="-1" role="dialog" aria-labelledby="receipt_student_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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