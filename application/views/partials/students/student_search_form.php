<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#student_search_submit').on('click', function() {
				search_student_info();
			});

			// enter key press event, when focus on inupt
			$(document).keypress(function(event){
				if ($("#input_student_search_ic").is(":focus")) {
				  	var keycode = (event.keyCode ? event.keyCode : event.which);
			        if(keycode == '13'){
			            search_student_info();
			        }
			        event.stopPropagation();
				}
		    });
		});

		function get_receipt_by_student_ic(key_word, target) {
			$.ajax({
				type:"post",
				url:window.api_url + "getStudentRecepitsByIC",
				data:{ic:key_word},
				success:function(json){
					if(json != null) {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.append('<h4>Sutdent Class Information (学生收费信息)</h4><hr>');
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="student_search_receipt_info_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="student_search_receipt_info_collapse_'+key+'" href="#student_search_receipt_info_collapse_body_'+key+'">Receipt No.: <b>' + reply[key].receipt_no + '</b>  /  Receipt Date: <b>' + reply[key].receipt_date + '</b>  /  Amount: <b>' + reply[key].receipt_amount + '</b>  /  Type: <b>' + reply[key].receipt_type + '</b></a>' + 
													' </h4>' +
												'</div>' +
												'<div id="student_search_receipt_info_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-6">'+ 
																'<div>Receipt No.(收据号): ' + reply[key].receipt_no + '</div>' +
															'</div>' + 
															'<div class="col-xs-6">'+ 
																'<div>Receipt Date(收款日期):' + reply[key].receipt_date + '</div>' +
															'</div>' + 
														'</div>' +
														'<hr>' +  
														'<div class="row">' + 
															'<div class="col-xs-4">'+ 
																'<div>Receipt Type(收据类型): ' + reply[key].receipt_type + '</div>' +
															'</div>' + 
															'<div class="col-xs-4">' +
																'<div>Amount(收款额): ' + reply[key].receipt_amount + '</div>' + 
															'</div>' +
															'<div class="col-xs-4">' +
																'<div>Payee Name(付款人): '+ reply[key].payee_name + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-4">' +
																'<div>Make Up(是否补交): '+ reply[key].make_up + '</div>' + 
															'</div>' +
															'<div class="col-xs-4">'+ 
																'<div>Student Before(是否老学员): ' + reply[key].student_before + '</div>' +
															'</div>' + 
															'<div class="col-xs-4">' +
																"<div>Course(收款相关课程): " + reply[key].course_type +'</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}
							}
							target.append('<br>');
						} else {
							target.append('<p>No Class Records found</p><br>');
						}
					}else {
						toastr.error("fail to call search api");
					}
				}
			});//End ajax
		}

		function get_class_by_student_ic(key_word, target) {
			$.ajax({
				type:"post",
				url:window.api_url + "getStudentClassesInfoByIC",
				data:{ic:key_word},
				success:function(json){
					if(json != null) {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.append('<h4>Sutdent Class Information (所在班级信息)</h4><hr>');
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="student_search_class_info_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="student_search_class_info_collapse_'+key+'" href="#student_search_class_info_collapse_body_'+key+'">Class Name: <b>' + reply[key].class_name + '</b>  /  Class Code: <b>' + reply[key].code + '</b>  /  Course Type: <b>' + reply[key].type + '</b>  /  Class Status: <b>' + reply[key].status + '</b></a>' + 
													' </h4>' +
												'</div>' +
												'<div id="student_search_class_info_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-6">'+ 
																'<div>Class Start Date: ' + reply[key].start_date + '</div>' +
															'</div>' + 
															'<div class="col-xs-6">'+ 
																'<div>Class End Date: ' + reply[key].end_date + '</div>' +
															'</div>' + 
														'</div>' +
														'<hr>' +  
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Course Type: ' + reply[key].type + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Level: ' + reply[key].level + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Start Time: '+ reply[key].start_time + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>End Time: '+ reply[key].end_time + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Teacher: ' + reply[key].teacher_name + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																"<div>Teacher's Tel: " + reply[key].teacher_tel +'</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Branch: '+ reply[key].name + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Location: '+ reply[key].location + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Created: ' + reply[key].created + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Modified: ' + reply[key].modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Remark: '+ reply[key].remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}
							}
							target.append('<br>');
						} else {
							target.append('<p>No Class Records found</p><br>');
						}
					}else {
						toastr.error("fail to call search api");
					}
				}
			});//End ajax
		}

		function search_get_student_record_by_ic(key_word, target) {
			$.ajax({
				type:"post",
				url:window.api_url + "getStudentRecordsByIC",
				data:{ic:key_word},
				success:function(json){
					if(json != null) {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.append('<h4>Sutdent Exam Records (考试记录)</h4><hr>');
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="exam_record_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="exam_record_collapse_'+key+'" href="#exam_record_collapse_body_'+key+'">Exam Record ' + num + '  /  Exam Date: <b>' + reply[key].exam_date + '</b></a>' + 
													' </h4>' +
												'</div>' +
												'<div id="exam_record_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-2">'+ 
																'<div>EL Best: ' + reply[key].el_best + '</div>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<div>ER Best: ' + reply[key].er_best + '</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>ES Best: '+ reply[key].es_best + '</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>EW Best: '+ reply[key].ew_best + '</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>EN Best: '+ reply[key].en_best + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>CMP: ' + reply[key].cmp + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>CON: ' + reply[key].con +'</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>WRI: '+ reply[key].wri + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>WPN: '+ reply[key].wpn + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Created: ' + reply[key].created + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Modified: ' + reply[key].modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Remark: '+ reply[key].remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}
							}
							target.append('<br>');
						} else {
							target.append('<p>No Exam Records found</p><br>');
						}
					}else {
						toastr.error("fail to call search api");
					}
				}
			});//End ajax
		}

		function search_get_student_ato_by_ic(key_word, target) {
			$.ajax({
				type:"post",
				url:window.api_url + "getStudentATOInfoByIC",
				data:{ic:key_word},
				success:function(json){
					if(json != null) {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.append('<h4>Sutdent ATO Information（ATO信息）</h4><hr>');
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									target.append(
										'<div class="panel-group" id="ato_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="ato_collapse_'+key+'" href="#ato_collapse_body_'+key+'">ATO ' + num + '  /  Exam Type: <b>' + reply[key].pre_post + '</b>  /  Exam Date&Time: <b>' + reply[key].exam_date + ' ' + reply[key].exam_time + '</b></a>' + 
													' </h4>' +
												'</div>' +
												'<div id="ato_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Exam Type: ' + reply[key].pre_post + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Class Code: '+ reply[key].class_code + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">'+ 
																'<div>Attendance: ' + reply[key].attendance + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">'+ 
																'<div>Change Day: ' + reply[key].post_change_day + '</div>' +
															'</div>' + 
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-6">' +
																'<div>Exam Date / Time: '+ reply[key].exam_date + ' / ' + reply[key].exam_time + '</div>' + 
															'</div>' +
															'<div class="col-xs-6">' +
																'<div>Exam Location: '+ reply[key].exam_location + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-2">'+ 
																'<div>EL: ' + reply[key].el + '</div>' +
															'</div>' + 
															'<div class="col-xs-2">' +
																'<div>ER: ' + reply[key].er +'</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>EN: '+ reply[key].en + '</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>ES: '+ reply[key].es + '</div>' + 
															'</div>' +
															'<div class="col-xs-2">' +
																'<div>EW: '+ reply[key].ew + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Created: ' + reply[key].ato_created + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Modified: ' + reply[key].ato_modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Remark: '+ reply[key].ato_remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}
							}
							target.append('<br>');
						} else {
							target.append('<p>No ATO Information found</p><br>');
						}
					}else {
						toastr.error("fail to call search api");
					}
				}
			});//End ajax
		}

		function search_student_info() {
			var key_word = $('#input_student_search_ic').val();
			var target = $('#student_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchStudentInfo",
			    data:{ic:key_word},
			    success:function(json){
			    	target.empty();
			        target.append('<p>No student found</p>');
			        if(json != null) {
			        	var reply = $.parseJSON(json);
			            if(reply.length > 0 ) {
			            	target.empty();
			            	target.append(
					            '<h4>Sutdent Basic Information (基本信息，工作，联系方式)</h4><hr>');
				            for (var key in reply) {
					    		if (reply.hasOwnProperty(key)) {
					            	target.append(
					            		'<div class="panel-group" id="student_basic_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="student_basic_collapse_'+key+'" href="#student_basic_collapse_body_'+key+'">Student Basic Info' + '</a>' + 
													' </h4>' +
												'</div>' +
												'<div id="student_basic_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
									            		'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>IC Number: ' + reply[key].ic + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Name: ' + reply[key].firstname + ' ' + reply[key].lastname + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Register Date: '+ reply[key].reg_date + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Register Number: '+ reply[key].reg_no + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>IC Type: ' + reply[key].ic_type + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Nationality: ' + reply[key].nationality + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Gender: '+ reply[key].gender + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Birthday: '+ reply[key].birthday + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Age: ' + reply[key].age + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Citizenship: ' + reply[key].citizenship + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Race: '+ reply[key].race + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">' +
																'<div>Language: '+ reply[key].lang + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Chinese Level: ' + reply[key].cn_level + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Edu level: '+ reply[key].edu_level + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Start Date Wanted: '+ reply[key].start_date_wanted + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' +
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Source: ' + reply[key].source + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Created: ' + reply[key].created + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Modified: '+ reply[key].modified + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">'+ 
																'<div>Government Letter: ' + reply[key].gov_letter + '</div>' +
															'</div>' + 
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Employment Status: ' + reply[key].emp_status + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Company Name: ' + reply[key].company_name + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Company Type: '+ reply[key].company_type + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">'+ 
																'<div>Company Reg No.: ' + reply[key].company_reg_no + '</div>' +
															'</div>' + 
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Industry: ' + reply[key].industry + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Designation: ' + reply[key].designation + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Salary Range: '+ reply[key].salary_range + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Tel: ' + reply[key].tel + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Home Tel: ' + reply[key].tel_home + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Street: '+ reply[key].street + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Block: '+ reply[key].block + '</div>' + 
															'</div>' +
														'</div>' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>#Floor-Unit: ' + reply[key].floor_unit_no + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Building Name: ' + reply[key].building + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Postcode: '+ reply[key].postcode + '</div>' + 
															'</div>' +
														'</div>' +
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
					            }
					        }
					        target.append('<br>');

					        search_get_student_ato_by_ic(key_word, target);
					        search_get_student_record_by_ic(key_word, target);
					        get_class_by_student_ic(key_word, target);
					        get_receipt_by_student_ic(key_word, target);
						}
			        }else {
			        	toastr.error("fail to call search api");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchStudentInfoDownload" method="POST" target="_blank">
		<div class="row">
			<div id="student_search">
				<div class="col-xs-2">
					<label for="input_student_search_ic">请输入学员IC：</label>
				</div>
				<div class="col-xs-4">
					<input name="keyword" class="form-control" id="input_student_search_ic">
				</div>
				<div class="col-xs-4"></div>
			</div>
			<div class="col-xs-2">
				<a class="button glow button-rounded button-flat" id="student_search_submit">Search</a>
			</div>
<!-- 			<div class="col-xs-2">
				<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="student_to_excel">
			</div> -->
		</div>
	</form>
	<div id="student_search_results"></div>
</div>