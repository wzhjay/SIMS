<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_student_exam_record_time').datepicker({
				format: 'yyyy-mm-dd'
			});

			student_exam_record_load_admin_users();
			student_exam_record_load_branches();
		});

		function create_student_exam_record() {
			var ic = $('#input_student_exam_record_ic').val();
			var exam_time = $('#input_student_exam_record_time').val();
			var er = $('#input_student_exam_record_er').val();
			var el = $('#input_student_exam_record_el').val();
			var es = $('#input_student_exam_record_es').val();
			var ew = $('#input_student_exam_record_ew').val();
			var en = $('#input_student_exam_record_en').val();
			var cmp = $('#input_student_level_cmp').val();
			var con = $('#input_student_level_con').val();
			var con = $('#input_student_level_con').val();
			var wri = $('#input_student_level_wri').val();
			var wpn = $('#input_student_level_wpn').val();
			var remark = $('#input_student_exam_record_remark').val();

		}

		function update_student_exam_record() {

		}

		function get_student_id_by_ic() {

		}

		function get_student_exam_records_by_ic() {

		}

		function student_exam_record_load_admin_users() {
			var users = $('#input_student_exam_record_op');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllAdminUsers",
			    data:{},
			    success:function(json){
			    	users.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		users.append('<option id="ato_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
			            	}
			            }
			        }else{
			        	alert("fail to load users");
			        }
			    }
			});//End ajax
		}

		function student_exam_record_load_branches() {
			var branches = $('#input_student_exam_record_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="ato_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	alert("fail to load braches");
			        }
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<form role="form">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_record_ic">请输入学员IC</label>
				<input class="form-control" id="input_student_exam_record_ic">
			</div>
			<div class="col-xs-2">
				<br>
				<a class="button glow button-rounded button-flat" id="student_exam_ic_check" data-toggle="modal" data-target="#student-exam-record-modal">Check</a>
			</div>
			<div class="col-xs-2"></div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_time">考试时间</label>
				<input class="form-control" id="input_student_exam_record_time">
			</div>
		</div>
		<h4>考试成绩</h4><hr>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_record_er">阅读ER</label>
				<select class="form-control" id="input_student_exam_record_er">
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
				<label for="input_student_exam_record_el">听力EL</label>
				<select class="form-control" id="input_student_exam_record_el">
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
				<label for="input_student_exam_record_es">会话ES</label>
				<select class="form-control" id="input_student_exam_record_es">
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
				<label for="input_student_exam_record_ew">写作EW</label>
				<select class="form-control" id="input_student_exam_record_ew">
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
				<label for="input_student_exam_record_en">数学EN</label>
				<select class="form-control" id="input_student_exam_record_en">
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
				<label for="input_student_exam_record_branch">Exam Record Branch</label>
				<select class="form-control" id="input_student_exam_record_branch"></select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_op">Exam Record Operator</label>
				<select class="form-control" id="input_student_exam_record_op"></select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_remark">Remark</label>
				<textarea class="form-control" id="input_student_exam_record_remark" rows="3"></textarea>
			</div>
		</div>
		<hr>
	</form>
	<div class="row">
		<div class="col-xs-8"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_exam_record_create">Create</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_exam_record_update">Update</a>
		</div>
	</div>
</div>

<!-- Student Exam IC Check Modal -->
<div class="modal fade" id="student-exam-record-modal" tabindex="-1" role="dialog" aria-labelledby="student_exam_record_ic_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_exam_record_ic_check_modal_label">Student Exam Records</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>