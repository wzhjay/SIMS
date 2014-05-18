<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_student_exams_time').datepicker({
				format: 'yyyy-mm-dd'
			});
		});
	</script>
</head>
<div class="highlight">
	<form role="form">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exams_ic">请输入学员IC</label>
				<input class="form-control" id="input_student_exams_ic">
			</div>
			<div class="col-xs-2">
				<br>
				<a class="button glow button-rounded button-flat" id="student_exam_ic_check" data-toggle="modal" data-target="#student-exam-modal">Check</a>
			</div>
			<div class="col-xs-2"></div>
			<div class="col-xs-4">
				<label for="input_student_exams_time">考试时间</label>
				<input class="form-control" id="input_student_exams_time">
			</div>
		</div>
		<h4>考试成绩</h4><hr>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_er">阅读ER</label>
				<select class="form-control" id="input_student_exam_er">
					<option>NA</option>
					<option>UN</option>
					<option>EXE</option>
					<option>B1</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_el">听力EL</label>
				<select class="form-control" id="input_student_exam_el">
					<option>NA</option>
					<option>UN</option>
					<option>EXE</option>
					<option>B1</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_es">会话ES</label>
				<select class="form-control" id="input_student_exam_es">
					<option>NA</option>
					<option>UN</option>
					<option>EXE</option>
					<option>B1</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_ew">写作EW</label>
				<select class="form-control" id="input_student_exam_ew">
					<option>NA</option>
					<option>UN</option>
					<option>EXE</option>
					<option>B1</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_en">数学EN</label>
				<select class="form-control" id="input_student_exam_en">
					<option>NA</option>
					<option>UN</option>
					<option>EXE</option>
					<option>B1</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
				</select>
			</div>
		</div>
		<h4>等级</h4><hr>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_level_cmp">综合CMP</label>
				<select class="form-control" id="input_student_level_cmp">
					<option>NA</option>
					<option>初级</option>
					<option>中级</option>
					<option>高级</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_level_con">回话CON</label>
				<select class="form-control" id="input_student_level_con">
					<option>NA</option>
					<option>初级</option>
					<option>中级</option>
					<option>高级</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_level_wri">写作WRI</label>
				<select class="form-control" id="input_student_level_wri">
					<option>NA</option>
					<option>初级</option>
					<option>中级</option>
					<option>高级</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_level_wpn">数学WPN</label>
				<select class="form-control" id="input_student_level_wpn">
					<option>NA</option>
					<option>初级</option>
					<option>中级</option>
					<option>高级</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_remark">Remark</label>
				<textarea class="form-control" id="input_student_exam_remark" rows="3"></textarea>
			</div>
		</div>
		<hr>
	</form>
	<div class="row">
		<div class="col-xs-10"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_exam_submit">Submit</a>
		</div>
	</div>
</div>

<!-- Student Exam IC Check Modal -->
<div class="modal fade" id="student-exam-modal" tabindex="-1" role="dialog" aria-labelledby="student_exam_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_exam_ic_check_modal_label">Student Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>