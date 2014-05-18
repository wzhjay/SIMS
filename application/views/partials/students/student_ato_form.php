<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_ato_class_start_date').datepicker({
				format: 'yyyy-mm-dd'
			});
			$('#input_ato_class_end_date').datepicker({
				format: 'yyyy-mm-dd'
			});
			$('#input_ato_exam_date').datepicker({
				format: 'yyyy-mm-dd'
			});
		});

	</script>
</head>
<div class="highlight">
<form role="form">
	<h4>ATO信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_ic">IC Number</label>
			<input class="form-control" id="input_ato_ic" >
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="student_ato_ic_check" data-toggle="modal" data-target="#student-ato-modal">Check</a>
		</div>
		<div class="col-xs-2"></div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_pre_post">Exam Type</label>
			<select class="form-control" id="input_ato_pre_post">
		      <option value="NA">请选择</option>
		      <option value="PRE">PRE CAT</option>
		      <option value="POST">POST CAT</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_recommend_level">Recommend Level</label>
			<select class="form-control" id="input_ato_recommend_level">
            	<option value="NA">请选择</option>
                <option value="Waiting for the result">PRE CAT等成绩</option>
                <option value="BEGINNERS">初级</option>
                <option value="INTERMEDIATE">中级</option>
                <option value="ADVANCED">高级</option>
            </select>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_class_start_date">Class Strat Date</label>
			<input class="form-control" id="input_ato_class_start_date" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_class_end_date">Class End Date</label>
			<input class="form-control" id="input_ato_class_end_date">
		</div>
		<div class="col-xs-4">
			<label for="input_ato_class_code">Class Code</label>
			<input class="form-control" id="input_ato_class_code">
		</div>
		<div class="col-xs-4">
			<label for="input_ato_attendance">Attendance</label>
			<input class="form-control" id="input_ato_attendance">
		</div>
	</div>
	<h4>考试科目</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_el">
			    	<input type="checkbox" id="input_ato_el"> 听力EL
			    </label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		    	<label for="input_ato_er">
		    		<input type="checkbox" id="input_ato_er"> 阅读ER
		    	</label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_en">
			    	<input type="checkbox" id="input_ato_en"> 数学EN
			    </label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		    	<label for="input_ato_es">
		    		<input type="checkbox" id="input_ato_es"> 会话ES
		    	</label>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
			    <label for="input_ato_ew">
			    	<input type="checkbox" id="input_ato_ew"> 写作EW
			    </label>
			</div>
		</div>
	</div>
	<h4>考试信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_ato_exam_location">Exam Location</label>
			<select class="form-control" id="input_ato_exam_location">
				<option value="NA">请选择</option>
	      		<option value="JE">Jurong East</option>
	      		<option value="UN">EUNOS</option>
	      	</select>
		</div>
		<div class="col-xs-4">
			<label for="input_ato_exam_date">Exam Date</label>
			<input class="form-control" id="input_ato_exam_date">
		</div>
		<div class="col-xs-4">
			<label for="input_ato_exam_time">Exam Time</label>
			<select class="form-control" id="input_ato_exam_time">
                <option value="NA">请选择</option>
                <option value="09">上午九点</option>
                <option value="14">下午两点</option>
                <option value="19">晚上七点</option>
            </select>
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

<!-- Student ATO IC Check Modal -->
<div class="modal fade" id="student-ato-modal" tabindex="-1" role="dialog" aria-labelledby="student_ato_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_ato_ic_check_modal_label">ATO Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>