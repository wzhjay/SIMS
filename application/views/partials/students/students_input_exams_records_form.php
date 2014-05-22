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

			$('#student_exam_ic_check').on('click', function() {
				stundet_exam_record_check_ic();				
			});
		});


		function stundet_exam_record_check_ic() {
			var ic = $('#input_student_exam_record_ic').val();
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#student_ato_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.children().remove();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'<div class="col-xs-2" id="student_ato_ic_check_model_ic">'+ 
											'<label>IC Number</label>' +
											'<div class="form-control">' + ic + '</div>' +
										'</div>' + 
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_class_start_date">开课时间</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_class_start_date">' + reply[key].class_start_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_class_end_date">结课时间</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_class_end_date">' + reply[key].class_end_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_exam_date">考试时间</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_date">' + reply[key].exam_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_exam_type">考试类型</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_exam_type">' + reply[key].pre_post + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' + 
											'<label for="student_ato_ic_check_model_recommend_level">推荐等级</label>' + 
											'<div class="form-control" id="student_ato_ic_check_model_recommend_level">' + reply[key].recommend_level + '</div>' + 
										'</div>' +
										'<div class="col-xs-6">' +
											'<label for="student_ato_ic_check_model_remark">备注</label>' +
											'<div class="form-control" id="student_ato_ic_check_model_remark">'+ reply[key].remark + '</div>' + 
										'</div>' +
										'<div class="col-xs-4"></div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="student_ato_ic_check_modal_update_' + reply[key].id + '">Update</a>' + 
										'</div>' +
									'</div>' +
									'<hr>'
								);
					        }
				    	}
				    	$('#student-ato-modal a').on('click', function() {
							var el_id = $(this).attr('id').split('_');
							var ato_id = el_id[6];
							update_selected_id = ato_id;	// assign global var for late update submit

							load_ato_info(ato_id);
							$('#student-ato-modal').modal('hide');
						});
				    }
				    else {
				    	if(ic.trim() == "") {
				    		ic='NULL';
				    	};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="student_ato_ic_check_model_ic">'+ 
									'<label>IC Number Input</label>' +
									'<div class="form-control">' + ic + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related ATO info found!<br>Please input valid IC number.</label>' + 
							'</div>'
						);
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
				<label for="input_student_exams_ic">请输入学员IC</label>
				<input class="form-control" id="input_student_exams_ic">
			</div>
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