<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		var selected_record_id = 0;
		$(document).ready(function($) {
			$('#student_record_form').parsley();
			$('#input_student_exam_record_time').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			// student_exam_record_load_admin_users();
			// student_exam_record_load_branches();

			$('#student_exam_record_create').on('click', function() {
				create_student_exam_record();
			});

			$('#student_exam_record_update').on('click', function() {
				update_student_exam_record(selected_record_id);
			});

			$('#student_exam_record_delete_confirm').on('click', function() {
				delete_student_exam_record(selected_record_id);
			})

			$('#student_exam_ic_check').on('click', function() {
				student_exam_record_check_student_by_ic();
			});
		});

		function create_student_exam_record() {
			var ic = $('#input_student_exam_record_ic').val();
			var exam_date = $('#input_student_exam_record_time').val();
			var er = $('#input_student_exam_record_er').val().toString();
			var el = $('#input_student_exam_record_el').val().toString();
			var es = $('#input_student_exam_record_es').val().toString();
			var ew = $('#input_student_exam_record_ew').val().toString();
			var en = $('#input_student_exam_record_en').val().toString();
			var cmp = "";
			var con = "";
			var wri = "";
			var wpn = "";
			// var branch = $('#input_student_exam_record_branch option:selected').attr('id').split('_');
			// var branch_id = branch[2];
			// var branch_op = $('#input_student_exam_record_op option:selected').attr('id').split('_');
			// var branch_op_id = branch_op[2];
			var remark = $('#input_student_exam_record_remark').val();

			// level calculation
			var er_pt = 0;
			var el_pt = 0;
			var es_pt = 0;
			var ew_pt = 0;
			var en_pt = 0;
			
			if(er == "UN" || er == "EXE" || er == "B1" || er == "PENDING" || er == "N/A") {	er_pt = 0;	} else {	er_pt = parseInt(er);	}
			if(el == "UN" || el == "EXE" || el == "B1" || el == "PENDING" || el == "N/A") {	el_pt = 0;	} else {	el_pt = parseInt(el);	}
			if(es == "UN" || es == "EXE" || es == "B1" || es == "PENDING" || es == "N/A") {	es_pt = 0;	} else {	es_pt = parseInt(es);	}
			if(ew == "UN" || ew == "EXE" || ew == "B1" || ew == "PENDING" || ew == "N/A") {	ew_pt = 0;	} else {	ew_pt = parseInt(ew);	}
			if(en == "UN" || en == "EXE" || en == "B1" || en == "PENDING" || en == "N/A") {	en_pt = 0;	} else {	en_pt = parseInt(en);	}
			var cmp_pt = er_pt + el_pt + es_pt + ew_pt;
			if(er == "N/A" || el == "N/A" || es == "N/A" || ew == "N/A") { cmp = "N/A" } else if(er == "PENDING" || el == "PENDING" || es == "PENDING" || ew == "PENDING") { cmp = "PENDING" } else { if(cmp_pt<12) {	cmp = "BEGINNERS";	} else if (cmp_pt<20) {	cmp = "INTERMEDIATE";	} else { cmp = "ADVANCED";	} }
			if(es == "N/A") { con = "N/A" } else if(es == "PENDING") { con = "PENDING" } else { if(es_pt<3) {	con = "BEGINNERS";	} else if (es_pt<5) {	con = "INTERMEDIATE";	} else { con = "ADVANCED";	} }
			if(ew == "N/A") { wri = "N/A" } else if(ew == "PENDING") { wri = "PENDING" } else { if(ew_pt<3) {	wri = "BEGINNERS";	} else if (ew_pt<5) {	wri = "INTERMEDIATE";	} else { wri = "ADVANCED";	} }
			if(en == "N/A") { wpn = "N/A" } else if(en == "PENDING") { wpn = "PENDING" } else { if(en_pt<3) {	wpn = "BEGINNERS";	} else if (en_pt<5) {	wpn = "INTERMEDIATE";	} else { wpn = "ADVANCED";	} }


			$.ajax({
				type:"post",
			    url:window.api_url + "createStudentExamRecord",
			    data:{	ic:ic,
			    		exam_date:exam_date, 
			    		er:er, 
			    		el:el, 
			    		es:es, 
			    		ew:ew, 
			    		en:en,
			    		cmp:cmp,
			    		con:con,
			    		wri:wri,
			    		wpn:wpn,
			    		// branch_id:branch_id,
			    		// branch_op_id:branch_op_id,
			    		remark:remark},
			    success:function(json){
			    	if(json.trim() == '1') {
					    toastr.success("Insert record success!");
					    clear_student_exam_form();
					}else{
						toastr.error("fail to insert record");
					}
			    }
			});//End ajax
		}

		function delete_student_exam_record(selected_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteExamRecordByID",
			    data:{id:selected_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					}else{
						toastr.error("Fail to delete exam record!");
					}
			    }
			});//End ajax	
		}

		function update_student_exam_record(record_id) {
			var exam_date = $('#input_student_exam_record_time').val();
			var er = $('#input_student_exam_record_er').val().toString();
			var el = $('#input_student_exam_record_el').val().toString();
			var es = $('#input_student_exam_record_es').val().toString();
			var ew = $('#input_student_exam_record_ew').val().toString();
			var en = $('#input_student_exam_record_en').val().toString();
			var cmp = "";
			var con = "";
			var wri = "";
			var wpn = "";
			// var branch = $('#input_student_exam_record_branch option:selected').attr('id').split('_');
			// var branch_id = branch[2];
			// var branch_op = $('#input_student_exam_record_op option:selected').attr('id').split('_');
			// var branch_op_id = branch_op[2];
			var remark = $('#input_student_exam_record_remark').val();

			// level calculation
			var er_pt = 0;
			var el_pt = 0;
			var es_pt = 0;
			var ew_pt = 0;
			var en_pt = 0;
			
			if(er == "UN" || er == "EXE" || er == "B1" || er == "PENDING" || er == "N/A") {	er_pt = 0;	} else {	er_pt = parseInt(er);	}
			if(el == "UN" || el == "EXE" || el == "B1" || el == "PENDING" || el == "N/A") {	el_pt = 0;	} else {	el_pt = parseInt(el);	}
			if(es == "UN" || es == "EXE" || es == "B1" || es == "PENDING" || es == "N/A") {	es_pt = 0;	} else {	es_pt = parseInt(es);	}
			if(ew == "UN" || ew == "EXE" || ew == "B1" || ew == "PENDING" || ew == "N/A") {	ew_pt = 0;	} else {	ew_pt = parseInt(ew);	}
			if(en == "UN" || en == "EXE" || en == "B1" || en == "PENDING" || en == "N/A") {	en_pt = 0;	} else {	en_pt = parseInt(en);	}

			var cmp_pt = er_pt + el_pt + es_pt + ew_pt;
			if(er == "N/A" || el == "N/A" || es == "N/A" || ew == "N/A") { cmp = "N/A" } else if(er == "PENDING" || el == "PENDING" || es == "PENDING" || ew == "PENDING") { cmp = "PENDING" } else { if(cmp_pt<12) {	cmp = "BEGINNERS";	} else if (cmp_pt<20) {	cmp = "INTERMEDIATE";	} else { cmp = "ADVANCED";	} }
			if(es == "N/A") { con = "N/A" } else if(es == "PENDING") { con = "PENDING" } else { if(es_pt<3) {	con = "BEGINNERS";	} else if (es_pt<5) {	con = "INTERMEDIATE";	} else { con = "ADVANCED";	} }
			if(ew == "N/A") { wri = "N/A" } else if(ew == "PENDING") { wri = "PENDING" } else { if(ew_pt<3) {	wri = "BEGINNERS";	} else if (ew_pt<5) {	wri = "INTERMEDIATE";	} else { wri = "ADVANCED";	} }
			if(en == "N/A") { wpn = "N/A" } else if(en == "PENDING") { wpn = "PENDING" } else { if(en_pt<3) {	wpn = "BEGINNERS";	} else if (en_pt<5) {	wpn = "INTERMEDIATE";	} else { wpn = "ADVANCED";	} }


			$.ajax({
				type:"post",
			    url:window.api_url + "updateStudentExamRecord",
			    data:{	id:record_id,
			    		exam_date:exam_date, 
			    		er:er, 
			    		el:el, 
			    		es:es, 
			    		ew:ew, 
			    		en:en,
			    		cmp:cmp,
			    		con:con,
			    		wri:wri,
			    		wpn:wpn,
			    		// branch_id:branch_id,
			    		// branch_op_id:branch_op_id,
			    		remark:remark},
			    success:function(json){
			    	if(json.trim() == '2') {
					    toastr.success("Update record success!");
					    clear_student_exam_form();
					}else{
						toastr.error("fail to update record");
					}
			    }
			});//End ajax
		}

		function clear_student_exam_form() {
			var ic = $('#input_student_exam_record_ic').val('');
			var exam_date = $('#input_student_exam_record_time').val('');
			var remark = $('#input_student_exam_record_remark').val('');
			$('#input_student_exam_record_er option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_exam_record_el option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_exam_record_es option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_exam_record_ew option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_exam_record_en option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_level_cmp option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_level_con option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_level_wri option[value="N/A"]').attr('selected', 'selected');
			$('#input_student_level_wpn option[value="N/A"]').attr('selected', 'selected');
		}

		function student_exam_record_check_student_by_ic() {
			// check if student bisic info exist
			var ic = $('#input_student_exam_record_ic').val().trim(" ");
			$.ajax({
				type:"post",
			    url:window.api_url + "getRegistrationByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#student_exam_record_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.children().remove();
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'Stundet info existed!' + 
									'</div>' +
									'<div class="row">' + 
										'<div class="col-xs-3" id="student_record_ic_check_model_ic">'+ 
											'<label>IC Number Input</label>' +
											'<div class="form-control">' + ic + '</div>' +
										'</div>' + 
										'<div class="col-xs-3">' + 
											'<label for="student_record_ic_check_model_reg_date">Name</label>' + 
											'<div class="form-control" id="student_record_ic_check_model_reg_date">' + reply[key].reg_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-3">' +
											'<label for="student_record_ic_check_model_reg_no">Tel</label>' +
											'<div class="form-control" id="student_record_ic_check_model_reg_no">'+ reply[key].reg_no + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
										'</div>' +
									'</div>'
								);
					        }
				    	}
				    	student_exam_record_get_student_record_by_ic(ic);
				    }
				    else {
				    	// no result found in student and registartion table
						if(ic.trim() == "") {
							ic='NULL';
						};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-4" id="student_record_ic_check_model_ic">'+ 
									'<label>IC Number Input</label>' +
									'<div class="form-control">' + ic + '</div>' +
								'</div>' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no related registration info found!<br>Please input valid IC number or register fisrt.</label>' + 
								'</div>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function student_exam_record_get_student_record_by_ic(ic) {
			// get student records by student ic
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentRecordsByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#student_exam_record_ic_check_modal_label').closest('.modal-content').find('.modal-body');
			    	modalBody.append(
			    		'<div class="row">' + 
							'Stundet records:' + 
						'</div>'
						);
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								modalBody.append(
									'<div class="row">' + 
										'<div class="col-xs-2">' + 
											'<label for="student_record_ic_check_model_exam_date">Exam Date</label>' + 
											'<div class="form-control" id="student_record_ic_check_model_exam_date">' + reply[key].exam_date + '</div>' + 
										'</div>' +
										'<div class="col-xs-1">' +
											'<label for="student_record_ic_check_el">EL</label>' +
											'<div class="form-control" id="student_record_ic_check_el">'+ reply[key].el_best + '</div>' + 
										'</div>' +
										'<div class="col-xs-1">' +
											'<label for="student_record_ic_check_er">ER</label>' +
											'<div class="form-control" id="student_record_ic_check_er">'+ reply[key].er_best + '</div>' + 
										'</div>' +
										'<div class="col-xs-1">' +
											'<label for="student_record_ic_check_en">EN</label>' +
											'<div class="form-control" id="student_record_ic_check_en">'+ reply[key].en_best + '</div>' + 
										'</div>' +
										'<div class="col-xs-1">' +
											'<label for="student_record_ic_check_es">ES</label>' +
											'<div class="form-control" id="student_record_ic_check_es">'+ reply[key].es_best + '</div>' + 
										'</div>' +
										'<div class="col-xs-1">' +
											'<label for="student_record_ic_check_ew">EW</label>' +
											'<div class="form-control" id="student_record_ic_check_ew">'+ reply[key].ew_best + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label for="student_record_ic_check_cmp">综合CMP</label>' +
											'<div class="form-control" id="student_record_ic_check_cmp">'+ reply[key].cmp + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label for="student_record_ic_check_con">会话CON</label>' +
											'<div class="form-control" id="student_record_ic_check_con">'+ reply[key].con + '</div>' + 
										'</div>' +
									'</div>' + 
									'<div class="row">' + 
										'<div class="col-xs-2">' +
											'<label for="student_record_ic_check_wri">写作WRI</label>' +
											'<div class="form-control" id="student_record_ic_check_wri">'+ reply[key].wri + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<label for="student_record_ic_check_wpn">数学WPN</label>' +
											'<div class="form-control" id="student_record_ic_check_wpn">'+ reply[key].wpn + '</div>' + 
										'</div>' +
										'<div class="col-xs-4">' +
											'<label for="student_record_ic_check_exam_remark">Remark</label>' +
											'<div class="form-control" id="student_record_ic_check_exam_remark">'+ reply[key].exam_remark + '</div>' + 
										'</div>' +
										'<div class="col-xs-2">' +
										'<br>' +
											'<a class="button glow button-rounded button-flat" id="student_record_ic_check_modal_delete_' + reply[key].id + '">Delete</a>' + 
										'</div>' +
										'<div class="col-xs-2">' +
											'<br>' +
											'<a class="button glow button-rounded button-flat" id="student_record_ic_check_modal_update_' + reply[key].id + '">Update</a>' + 
										'</div>' +
									'</div>' +
									'<hr>'
								);
					        }

					        $('#student-exam-record-modal a').on('click', function() {
								var el_id = $(this).attr('id').split('_');
								var record_id = el_id[6];
								selected_record_id = record_id;	// assign global var for late update submit
								if(el_id[5] == 'update') {
									load_exam_record(record_id);
								} else if(el_id[5] == 'delete') {
									$('#student-exam-record-delete-modal').modal('show');
								}

								$('#student-exam-record-modal').modal('hide');
							});
				    	}
				    }
				    else {
				    	// no student records found
						if(ic.trim() == "") {
							ic='NULL';
						};
						modalBody.append(
							'<div class="row">' + 
								'<div class="col-xs-8">' + 
									'<label>Sorry, no exam records found for this student!</label>' + 
								'</div>' + 
							'</div>'
						);
					}
			    }
			});//End ajax
		}

		function load_exam_record(record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentRecordID",
			    data:{id:record_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		$('#input_student_exam_record_ic').val(reply[key].student_ic);
								$('#input_student_exam_record_time').val(reply[key].exam_date);

								$('#input_student_exam_record_er option[value="'+reply[key].er_best+'"]').attr('selected', 'selected');
								$('#input_student_exam_record_el option[value="'+reply[key].el_best+'"]').attr('selected', 'selected');
								$('#input_student_exam_record_es option[value="'+reply[key].es_best+'"]').attr('selected', 'selected');
								$('#input_student_exam_record_ew option[value="'+reply[key].ew_best+'"]').attr('selected', 'selected');
								$('#input_student_exam_record_en option[value="'+reply[key].en_best+'"]').attr('selected', 'selected');

								$('#input_student_level_cmp option[value="'+reply[key].cmp+'"]').attr('selected', 'selected');
								$('#input_student_level_con option[value="'+reply[key].con+'"]').attr('selected', 'selected');
								$('#input_student_level_wri option[value="'+reply[key].wri+'"]').attr('selected', 'selected');
								$('#input_student_level_wpn option[value="'+reply[key].wpn+'"]').attr('selected', 'selected');

								// $('#input_student_exam_record_branch option[id="record_branch_'+reply[key].branch_id+'"]').attr('selected', 'selected');
								// $('#input_student_exam_record_op option[id="record_user_'+reply[key].branch_op_id+'"]').attr('selected', 'selected');
								$('#input_student_exam_record_remark').val(reply[key].remark);
			            	}
			            }
			            $("html, body").animate({ scrollTop: 0 }, "slow");
			            toastr.info("Update exam record on above form!");
			        }else{
			        	toastr.error("fail to load student record");
			        }
			    }
			});//End ajax
		}

		// function student_exam_record_load_admin_users() {
		// 	var users = $('#input_student_exam_record_op');
		// 	$.ajax({
		// 		type:"post",
		// 	    url:window.api_url + "getAllAdminUsers",
		// 	    data:{},
		// 	    success:function(json){
		// 	    	users.children().remove();
		// 	    	if(json != null) {
		// 	    		var reply = $.parseJSON(json);
		// 	    		for (var key in reply) {
		// 	    			if (reply.hasOwnProperty(key)) {
		// 	            		users.append('<option id="record_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
		// 	            	}
		// 	            }
		// 	        }else{
		// 	        	toastr.error("fail to load users");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }

		// function student_exam_record_load_branches() {
		// 	var branches = $('#input_student_exam_record_branch');
		// 	$.ajax({
		// 		type:"post",
		// 	    url:window.api_url + "getAllBranches",
		// 	    data:{},
		// 	    success:function(json){
		// 	    	branches.children().remove();
		// 	    	if(json != null) {
		// 	    		var reply = $.parseJSON(json);
		// 	    		for (var key in reply) {
		// 	    			if (reply.hasOwnProperty(key)) {
		// 	    				branches.append('<option id="record_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
		// 	    			}
		// 	    		}
		// 	        }else{
		// 	        	toastr.error("fail to load braches");
		// 	        }
		// 	    }
		// 	});//End ajax
		// }
	</script>
</head>
<div class="highlight">
	<form role="form" id="student_record_form">
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_record_ic">*学员IC</label>
				<input class="form-control" id="input_student_exam_record_ic" data-parsley-trigger="blur" required>
			</div>
			<div class="col-xs-2">
				<br>
				<a class="button glow button-rounded button-flat" id="student_exam_ic_check" data-toggle="modal" data-target="#student-exam-record-modal">Check</a>
			</div>
			<div class="col-xs-2"></div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_time">*考试日期</label>
				<input class="form-control" id="input_student_exam_record_time" data-parsley-trigger="blur" required>
			</div>
		</div>
		<h4>考试成绩</h4><hr>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_record_er">*阅读ER</label>
				<select class="form-control" id="input_student_exam_record_er">
					<option value="N/A">N/A</option>
					<option value="PENDING">PENDING</option>
					<option value="UN">UN</option>
					<option value="EXE">EXE</option>
					<option value="B1">B1</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_el">*听力EL</label>
				<select class="form-control" id="input_student_exam_record_el">
					<option value="N/A">N/A</option>
					<option value="PENDING">PENDING</option>
					<option value="UN">UN</option>
					<option value="EXE">EXE</option>
					<option value="B1">B1</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_es">*会话ES</label>
				<select class="form-control" id="input_student_exam_record_es">
					<option value="N/A">N/A</option>
					<option value="PENDING">PENDING</option>
					<option value="UN">UN</option>
					<option value="EXE">EXE</option>
					<option value="B1">B1</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<label for="input_student_exam_record_ew">*写作EW</label>
				<select class="form-control" id="input_student_exam_record_ew">
					<option value="N/A">N/A</option>
					<option value="PENDING">PENDING</option>
					<option value="UN">UN</option>
					<option value="EXE">EXE</option>
					<option value="B1">B1</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_en">*数学EN</label>
				<select class="form-control" id="input_student_exam_record_en">
					<option value="N/A">N/A</option>
					<option value="PENDING">PENDING</option>
					<option value="UN">UN</option>
					<option value="EXE">EXE</option>
					<option value="B1">B1</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</div>
		</div>
		<div class="row">
<!-- 			<div class="col-xs-4">
				<label for="input_student_exam_record_branch">*Exam Record Branch(操作员分部)</label>
				<select class="form-control" id="input_student_exam_record_branch"></select>
			</div>
			<div class="col-xs-4">
				<label for="input_student_exam_record_op">*Exam Record Operator(操作员)</label>
				<select class="form-control" id="input_student_exam_record_op"></select>
			</div> -->
			<div class="col-xs-4">
				<label for="input_student_exam_record_remark">Remark</label>
				<textarea class="form-control" id="input_student_exam_record_remark" rows="3"></textarea>
			</div>
		</div>
		<hr>
	</form>
	<div class="row">
		<div class="col-xs-7"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_exam_record_create">新建</a>
		</div>
		<div class="col-xs-3">
			<a class="button glow button-rounded button-flat" id="student_exam_record_update">更新学生信息</a>
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

<!-- Student Exam delete Modal -->
<div class="modal fade" id="student-exam-record-delete-modal" tabindex="-1" role="dialog" aria-labelledby="student_exam_record_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_exam_record_delete_modal_label">Delete Exam Records</h4>
      </div>
      <div class="modal-body">
	      <div class='row'>
	      	<div class="col-xs-12">Sure to delete this exam record? (确定删除这条考试记录？)</div>
	      </div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" data-dismiss="modal" id='student_exam_record_delete_confirm'>确定</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>