 <head>
	<meta charset="utf-8">

	<script>
		var pre_next = 0;
		var month_selected = 0;
		var year_selected = 0;
		$(document).ready(function($) {
			build_exam_booking_calender(pre_next);

			$('#exam_seat_booking_pre_month').on('click', function() {
				pre_next -= 1;
				build_exam_booking_calender(pre_next);
			});
			
			$('#exam_seat_booking_next_month').on('click', function() {
				pre_next += 1;
				build_exam_booking_calender(pre_next);
			});

			$('#exam_seat_booking_submit').on('click', function() {
				create_update_seat_booking_info();
			});

			ato_load_admin_users($('#input_ato_op'));
			ato_load_branches($('#input_ato_branch'));
			student_info_load_admin_users($('#input_student_new_op'));
			student_info_load_branches($('#input_student_new_branch'));
		});

		function build_exam_booking_calender(_pre_next) {
			var t_date = new Date();
	        var day = t_date.getDate();
	        if((t_date.getMonth() + _pre_next) > 11) {
	        	var month = (t_date.getMonth() + _pre_next) % 12;
	        	var year = t_date.getYear() + Math.floor((t_date.getMonth() + _pre_next)/12);
	        }
	        else if((t_date.getMonth() + _pre_next) < 0) {
	        	if(((t_date.getMonth() + _pre_next)*(-1))%12 == 0) {
	        		var month = 0;
	        		var year = t_date.getYear() - Math.floor(((t_date.getMonth() + _pre_next) * (-1))/12);
	        	} else {
	        		var month = 12 - ((t_date.getMonth() + _pre_next)*(-1))%12 ;
	        		var year = t_date.getYear() - Math.floor(((t_date.getMonth() + _pre_next) * (-1))/12) - 1;
	        	}
	        } else {
	        	var month = t_date.getMonth() + _pre_next;
	        	var year = t_date.getYear();
	        }
	        month_selected = month + 1;
	        year_selected = year;
	        if(year<=200)
	        {
	            year += 1900;
	        }
	        var date = new Date(year, month);

			months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
	        days_in_month = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	        if(year%4 == 0 && year!=1900)
	        {
	                days_in_month[1]=29;
	        }
	        total = days_in_month[month];
	        var date_today = months[month]+' '+year;	// diaplay date mon year inforamtion

	        $('#exam_seat_booking_date').empty();
			$('#exam_seat_booking_date').append(date_today);

	        beg_j = date;
	        beg_j.setDate(1);
	        if(beg_j.getDate()==2)
	        {
	                beg_j=setDate(0);
	        }
	        beg_j = beg_j.getDay();

	        week = 0;
	        var date_table = $('#exam_booking_calender_date_table');
            date_table.empty();
            var html = "";
            html += '<tr>';
	        for(i=1;i<=beg_j;i++)
	        {
	        	if(month == 0) {
	        		html += '<td class="cal_days_bef_aft"><div class="exam_seat_booking_content_each_date">'+(days_in_month[11]-beg_j+i)+'</div></td>';
	        	} else {
	        		html += '<td class="cal_days_bef_aft"><div class="exam_seat_booking_content_each_date">'+(days_in_month[month-1]-beg_j+i)+'</div></td>';
	        	}
                week++;
	        }
	        for(i=1;i<=total;i++)
	        {
                if(week==0)
                {
                        html += '<tr>';
                }
                if(day==i)
                {
                        html += '<td class="cal_today booking_date_this_month" id="exam_seat_booking_date_' + i +'"><div class="row"><div class="col-xs-6"><div class="exam_seat_booking_content_each_date">'+i+'</div></div><div class="col-xs-6"><select class="form-control exam_seat_booking_on_off"><option value="off">off</option><option value="on">on</option></select></div></div></td>';
                }
                else
                {
                        html += '<td class="booking_date_this_month" id="exam_seat_booking_date_' + i +'"><div class="row"><div class="col-xs-6"><div class="exam_seat_booking_content_each_date">'+i+'</div></div><div class="col-xs-6"><select class="form-control exam_seat_booking_on_off"><option value="off">off</option><option value="on">on</option></select></div></div></td>';
                }
                week++;
                if(week==7)
                {
                        html += '</tr>';
                        week=0;
                }
	        }
	        for(i=1;week!=0;i++)
	        {
                html += '<td class="cal_days_bef_aft"><div class="exam_seat_booking_content_each_date">'+i+'</div></td>';
                week++;
                if(week==7)
                {
                        html += '</tr>';
                        week=0;
                }
	        }
	        date_table.append($.parseHTML(html));
	        $(document).ready(function() {
	        	load_each_date_content();
	        });
		}

		function load_each_date_content() {
			$.each($('.booking_date_this_month'), function() {
				var day = $(this).find('.exam_seat_booking_content_each_date').text();
				var me = $(this);
				$.ajax({
					type:"post",
				    url:window.api_url + "getSeatBookingInfoByYearMonthDay",
				    data:{year:year_selected,
				    		month:month_selected,
				    		day:day},
				    success:function(json){
				    	if(json.trim() != "") {
				    		var reply = $.parseJSON(json);
					    	for (var key in reply) {
						    	if (reply.hasOwnProperty(key)) {
						    		me.append(
						    			'<table class="table table-bordered">' +
											'<tbody>' +
												'<tr>' +
													'<td></td>' +
										          	'<td>JE</td>' +
										          	'<td>PY</td>' +
												'</tr>' +
												'<tr>' +
													'<td>09:00</td>' +
										          	'<td><span class="form-control">'+reply[key].je_09+'<span></td>' +
										          	'<td><span class="form-control">'+reply[key].pi_09+'</td>' +
												'</tr>' +
												'<tr>' +
													'<td>14:00</td>' +
										          	'<td><span class="form-control">'+reply[key].je_14+'</td>' +
										          	'<td><span class="form-control">'+reply[key].pi_14+'</td>' +
												'</tr>' +
												'<tr>' +
													'<td>19:00</td>' +
										          	'<td><span class="form-control">'+reply[key].je_19+'</td>' +
										          	'<td><span class="form-control">'+reply[key].pi_19+'</td>' +
												'</tr>' +
											'</tbody>' +
										'</table>'
						    		);
 									// if status is on, update on_off select option
 									if(reply[key].on_off == 'on') {
 										me.find('.exam_seat_booking_on_off option[value="'+reply[key].on_off+'"]').attr('selected', 'selected');
 									}
						        }
					    	}
					    }
					    else {
					    	// not in db, load the default table
					    	me.append(
					    		'<table class="table table-bordered">' +
									'<tbody>' +
										'<tr>' +
											'<td></td>' +
								          	'<td>JE</td>' +
								          	'<td>PY</td>' +
										'</tr>' +
										'<tr>' +

											'<td>09:00</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
										'</tr>' +
										'<tr>' +
											'<td>14:00</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
										'</tr>' +
										'<tr>' +
											'<td>19:00</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
								          	'<td><span type="text" class="form-control">0</td>' +
										'</tr>' +
									'</tbody>' +
								'</table>'
					    	);
						}
				    },
				    complete:function(){
				    }
				});//End ajax
			});
 			$(document).ajaxStop(function() {
			  afterLoadEachDateContent();
			  if(pre_next == 0) {
					$('.cal_today').css('background', '#ECDDDD');
				}
			});
			$('#exam_booking_calender_date_table tr td .form-control').css('background','#ccc');
		}

		function ato_load_admin_users(users) {
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
			        	toastr.error("fail to load users");
			        }
			    }
			});//End ajax
		}

		function ato_load_branches(branches) {
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
			        	toastr.error("fail to load braches");
			        }
			    }
			});//End ajax
		}

		function student_info_load_admin_users(users) {
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
			            		users.append('<option id="student_new_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
			            	}
			            }
			        }else{
			        	toastr.error("fail to load users");
			        }
			    }
			});//End ajax
		}

		function student_info_load_branches(branches) {
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
			    				branches.append('<option id="student_new_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("fail to load braches");
			        }
			    }
			});//End ajax
		}

		function clear_ato_inputs() {
			$('#input_ato_ic').val('');
			$('#input_ato_class_code').val('');
			$('#input_ato_el').prop('checked', false);
			$('#input_ato_er').prop('checked', false);
			$('#input_ato_en').prop('checked', false);
			$('#input_ato_es').prop('checked', false);
			$('#input_ato_ew').prop('checked', false);
			$('#input_ato_exam_date').val('');
			$('#input_ato_remark').val('');
		}

		function clear_student_new_form_inputs() {
			$('#input_student_new_gov_letter').prop('checked', false);
			$('#input_student_new_ic').val('');
			$('#input_student_new_ic_type option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_fn').val('');
			$('#input_student_new_ln').val('');
			$('#input_student_new_on').val('');
			$('#input_student_new_tel').val('');
			$('#input_student_new_tel_home').val('');
			$('#input_student_new_gender option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_sal option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_bd').val('');
			$('#input_student_new_age').val('');
			$('#input_student_new_citizenship option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_nationality option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_race option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_cnlevel option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_edulevel option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_lang option[value="NA"]').attr('selected', 'selected');

			// address
			$('#input_student_new_blk').val('');
			$('#input_student_new_street').val('');
			$('#input_student_new_floor_unit').val('');
			$('#input_student_new_building').val('');
			$('#input_student_new_postcode').val('');

			// employment
			$('#input_student_new_empstatus option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_comn').val('');
			$('#input_student_new_com_type option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_com_reg_no').val('');
			$('#input_student_new_industry option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_designation option[value="NA"]').attr('selected', 'selected');
			$('#input_student_new_sal_range option[value="NA"]').attr('selected', 'selected');

			// extra
			$('#input_student_new_remark').val('');
		}

		function afterLoadEachDateContent() {
			$.each($('.booking_date_this_month'), function() {
				$(this).find('.exam_seat_booking_on_off').prop('disabled', true);
				if($(this).find('.exam_seat_booking_on_off').val() == 'off') {
					$(this).find('table').css('background','rgb(228, 228, 228)');
					$(this).find('table span').prop('disabled', true);
					$(this).find('table span').css('background','rgb(204, 204, 204)');
				} else {
					$(this).find('table').css('background','');
					$(this).find('table span').prop('disabled', false);
					$.each($(this).closest('.booking_date_this_month').find('span'), function() {
						if($(this).text() != '0') {
							$(this).css({'background':'rgb(0, 255, 0)', 'cursor':'pointer'});
						} else {
							$(this).css({'background':'rgb(255, 255, 0)', 'cursor':'pointer'});
						}

						// event listened to modal
						$(this).on('click', function() {
							$('#seat-booking-modal').modal('show');
							clear_ato_inputs();
							$('#input_ato_exam_date').datepicker({
								format: 'yyyy-mm-dd',
								todayHighlight: true
							});

							$('#exam_seat_booking_next_button').on('click', function() {
								var ic = $('#input_ato_ic').val();
								var pre_post = $('#input_ato_pre_post').val();
								var recommend_level = $('#input_ato_recommend_level').val();
								var class_code = -1;
								var attendance = 0;
								var post_change_date = 'NO';
								var el = $('#input_ato_el').is(':checked') ? 'YES' : 'NO';
								var er = $('#input_ato_er').is(':checked') ? 'YES' : 'NO';
								var en = $('#input_ato_en').is(':checked') ? 'YES' : 'NO';
								var es = $('#input_ato_es').is(':checked') ? 'YES' : 'NO';
								var ew = $('#input_ato_ew').is(':checked') ? 'YES' : 'NO';
								var exam_location = $('#input_ato_exam_location').val();
								var exam_date = $('#input_ato_exam_date').val();
								var exam_time = $('#input_ato_exam_time').val();
								var ato_branch = $('#input_ato_branch option:selected').attr('id').split('_');
								var ato_branch_id = ato_branch[2];
								var ato_op = $('#input_ato_op option:selected').attr('id').split('_');
								var ato_op_id = ato_op[2];
								var remark  = $('#input_ato_remark').val();

								// loading student info checking/modifying/adding modal
								loading_student_basic_info();
							});
						});
					});
				}
			});

 			function loading_student_basic_info() {
 				var ic = $('#input_ato_ic').val();
 				$.ajax({
					type:"post",
				    url:window.api_url + "getStudentByIC",
				    data:{ic:ic},
				    success:function(json){
				    	var modalBody = $('#seat_booking_student_info_modal_label').closest('.modal-content').find('.modal-body');
				    	if(json.trim() != "") {
				    		$('#seat-booking-student-info-modal').modal('show');
				    		var reply = $.parseJSON(json);
					    	for (var key in reply) {
						    	if (reply.hasOwnProperty(key)) {

									$('#input_student_new_source').val(reply[key].source);
									(reply[key].gov_letter == "YES") ? $('#input_student_new_gov_letter').prop('checked', true) : $('#input_student_new_gov_letter').prop('checked', false);
									$('#input_student_new_ic').val(reply[key].ic);
									$('#input_student_new_ic_type option[value="'+reply[key].ic_type+'"]').attr('selected', 'selected');

									$('#input_student_new_fn').val(reply[key].firstname);
									$('#input_student_new_ln').val(reply[key].lastname);
									$('#input_student_new_on').val(reply[key].othername);
									$('#input_student_new_tel').val(reply[key].tel);
									$('#input_student_new_tel_home').val(reply[key].tel_home);
									$('#input_student_new_gender').val(reply[key].gender);
									$('#input_student_new_sal option[value="'+reply[key].salutation+'"]').attr('selected', 'selected');
									$('#input_student_new_bd').val(reply[key].birthday);
									$('#input_student_new_age').val(reply[key].age);
									$('#input_student_new_citizenship option[value="'+reply[key].citizenship+'"]').attr('selected', 'selected');
									$('#input_student_new_nationality option[value="'+reply[key].nationality+'"]').attr('selected', 'selected');
									$('#input_student_new_race option[value="'+reply[key].race+'"]').attr('selected', 'selected');
									$('#input_student_new_cnlevel option[value="'+reply[key].cn_level+'"]').attr('selected', 'selected');
									$('#input_student_new_edulevel option[value="'+reply[key].edu_level+'"]').attr('selected', 'selected');
									$('#input_student_new_lang option[value="'+reply[key].lang+'"]').attr('selected', 'selected');

									// address
									$('#input_student_new_blk').val(reply[key].block);
									$('#input_student_new_street').val(reply[key].street);
									$('#input_student_new_floor_unit').val(reply[key].floor_unit_no);
									$('#input_student_new_building').val(reply[key].building);
									$('#input_student_new_postcode').val(reply[key].postcode);

									// employment
									$('#input_student_new_empstatus option[value="'+reply[key].emp_status+'"]').attr('selected', 'selected');
									$('#input_student_new_comn').val(reply[key].company_name);
									$('#input_student_new_com_type option[value="'+reply[key].company_type+'"]').attr('selected', 'selected');
									$('#input_student_new_com_reg_no').val(reply[key].company_reg_no);
									$('#input_student_new_industry option[value="'+reply[key].industry+'"]').attr('selected', 'selected');
									$('#input_student_new_designation option[value="'+reply[key].designation+'"]').attr('selected', 'selected');
									$('#input_student_new_sal_range option[value="'+reply[key].salary_range+'"]').attr('selected', 'selected');

									// extra
									$('#input_student_new_branch option[id="student_new_branch_'+reply[key].student_branch_id+'"]').attr('selected', 'selected');
									$('#input_student_new_op option[id="student_new_user_'+reply[key].student_op_id+'"]').attr('selected', 'selected');
									$('#input_student_new_remark').val(reply[key].student_remark);
								}
					    	}
					    }
					    else {
					    	// check from registration table, insert bisic info for this new student
					    	$.ajax({
								type:"post",
							    url:window.api_url + "getRegistrationByIC",
							    data:{ic:ic},
							    success:function(json){
							    	$('#seat-booking-student-info-fail-modal').modal('show');
							    	var modalBody = $('#seat_booking_student_info_fail_modal_label').closest('.modal-content').find('.modal-body');
							    	modalBody.empty();
							    	if(json.trim() != "") {
							    		var reply = $.parseJSON(json);
								    	for (var key in reply) {
									    	if (reply.hasOwnProperty(key)) {
												modalBody.append(
													'<div class="row">' + 
														'Stundet had registered, please insert basic info!' + 
													'</div>' +
													'<div class="row">' + 
														'<div class="col-xs-4" id="student_new_ic_check_model_ic">'+ 
															'<label>IC Number Input</label>' +
															'<div class="form-control">' + ic + '</div>' +
														'</div>' + 
														'<div class="col-xs-4">' + 
															'<label for="student_new_ic_check_model_reg_date">注册日期</label>' + 
															'<div class="form-control" id="student_new_ic_check_model_reg_date">' + reply[key].reg_date + '</div>' + 
														'</div>' +
														'<div class="col-xs-4">' +
															'<label for="student_new_ic_check_model_reg_no">注册表号码</label>' +
															'<div class="form-control" id="student_new_ic_check_model_reg_no">'+ reply[key].reg_no + '</div>' + 
														'</div>' +
													'</div>' +
													'<div class="row">' +
														'<div class="col-xs-10"></div>' +
														'<div class="col-xs-2">' +
															'<a class="button glow button-rounded button-flat" id="seat_booking_new_student_info_btn">Add</a>' +
														'</div>' +
													'</div>'
												);
									        }
								    	}
								    	$('#seat_booking_new_student_info_btn').on('click', function() {
								    		$('#seat-booking-student-info-fail-modal').modal('hide');
								    		$('#seat-booking-student-info-modal').modal('show');
								    		clear_student_new_form_inputs();
								    		$('#input_student_new_ic').val(ic);
								    	})
								    }
								    else {
								    	// no result found in student and registartion table
								    	if(ic.trim() == "") {
								    		ic='NULL';
								    	};
										modalBody.append(
											'<div class="row">' + 
												'<div class="col-xs-4" id="student_new_ic_check_model_ic">'+ 
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
				    }
				});//End ajax
 			}

			$('.booking_date_this_month span').on('change', function() {
				if($(this).text() != '0') {
					$(this).css('background', 'rgb(0, 255, 0)');
				} else {
					$(this).css('background', 'rgb(255, 255, 0)');
				}
			});

			// $('.exam_seat_booking_on_off').on('change', function() {
			// 	var el = $(this).closest('.booking_date_this_month');
			// 	if($(this).val() == 'off') {
			// 		update_seat_booking_info_on_off(el);
			// 		el.find('table').css('background','rgb(228, 228, 228)');
			// 		el.find('table span').prop('disabled', true);
			// 		el.find('table span').css('background','rgb(204, 204, 204)');
			// 	} else {
			// 		el.find('table').css('background','');
			// 		el.find('table span').prop('disabled', false);
			// 		$.each(el.find('span'), function() {
			// 			if($(this).text() != '0') {
			// 				$(this).css('background', 'rgb(0, 255, 0)');
			// 			} else {
			// 				$(this).css('background', 'rgb(255, 255, 0)');
			// 			}
			// 		});
			// 	}
			// });
		}

		function create_update_seat_booking_info() {
			$.each($('.booking_date_this_month'), function() {
				var on_off = $(this).find('.exam_seat_booking_on_off').val();
				if(on_off == 'on') {
					var day = $(this).find('.exam_seat_booking_content_each_date').text();

					var je_09 = $(this).find('tbody').find('tr:nth-child(2)').find('td:nth-child(2) span').text().trim();
					var pi_09 = $(this).find('tbody').find('tr:nth-child(2)').find('td:nth-child(3) span').text().trim();

					var je_14 = $(this).find('tbody').find('tr:nth-child(3)').find('td:nth-child(2) span').text().trim();
					var pi_14 = $(this).find('tbody').find('tr:nth-child(3)').find('td:nth-child(3) span').text().trim();

					var je_19 = $(this).find('tbody').find('tr:nth-child(4)').find('td:nth-child(2) span').text().trim();
					var pi_19 = $(this).find('tbody').find('tr:nth-child(4)').find('td:nth-child(3) span').text().trim();

					// update or create seat booking records
					$.ajax({
						type:"post",
					    url:window.api_url + "createOrUpdateSeatBookingInfo",
					    data:{	on_off:on_off,
					    		je_09:je_09, 
					    		pi_09:pi_09, 
					    		je_14:je_14,
					    		pi_14:pi_14,
					    		je_19:je_19,
					    		pi_19:pi_19,
					    		year:year_selected,
					    		month:month_selected,
					    		day:day},
					    success:function(json){
					    	if(json.trim() == '1') {
							    toastr.success("Insert/Update success!");
							} else{
								toastr.error("Fail to insert/update seat booking info!");
							}

					    }
					});//End ajax
				}
			});
		}

		function update_seat_booking_info_on_off(me) {
			var on_off = me.find('.exam_seat_booking_on_off').val();
			var day = me.find('.exam_seat_booking_content_each_date').text();

			var je_09 = me.find('tbody').find('tr:nth-child(2)').find('td:nth-child(2) span').text().trim();
			var pi_09 = me.find('tbody').find('tr:nth-child(2)').find('td:nth-child(3) span').text().trim();

			var je_14 = me.find('tbody').find('tr:nth-child(3)').find('td:nth-child(2) span').text().trim();
			var pi_14 = me.find('tbody').find('tr:nth-child(3)').find('td:nth-child(3) span').text().trim();

			var je_19 = me.find('tbody').find('tr:nth-child(4)').find('td:nth-child(2) span').text().trim();
			var pi_19 = me.find('tbody').find('tr:nth-child(4)').find('td:nth-child(3) span').text().trim();

			// update or create seat booking records
			$.ajax({
				type:"post",
			    url:window.api_url + "updateSeatBookingInfo",
			    data:{	on_off:on_off,
			    		je_09:je_09, 
			    		pi_09:pi_09, 
			    		je_14:je_14,
			    		pi_14:pi_14,
			    		je_19:je_19,
			    		pi_19:pi_19,
			    		year:year_selected,
			    		month:month_selected,
			    		day:day},
			    success:function(json){
			    	if(json.trim() == '2') {
					    toastr.success("Update success!");
					}else{
						toastr.error("Fail to update seat booking info!");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight" id="exam_seat_booking_calendar_section_highlight">
	<div class="row">
		<div class="col-xs-12" id="exam_seat_booking_calendar_section">
			<div id='exam_seat_booking_calendar'>
				<div class="row">
					<div class="col-xs-5"></div>
					<div class="col-xs-4"><h1><span class="label label-warning">输入座位数目</span></h1></div>
					<div class="col-xs-3"></div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<ul class="pager">
						  <li class="previous" id="exam_seat_booking_pre_month"><a>&larr; Prebious</a></li>
						  <li class="next" id="exam_seat_booking_next_month"><a>Next &rarr;</a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5"></div>
					<div class="col-xs-4"><h3><span class="label label-warning" id="exam_seat_booking_date">July 2014</span></h3></div>
					<div class="col-xs-3"></div>
				</div>
				<div id="exam_booking_calender">
					<table class="table table-bordered">
	  					<thead>
					        <tr>
					          <th>Sun</th>
					          <th>Mon</th>
					          <th>Tue</th>
					          <th>Wed</th>
					          <th>Thu</th>
					          <th>Fri</th>
					          <th>Sat</th>
					        </tr>
					    </thead>
					    <tbody id='exam_booking_calender_date_table'></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- seat booking Modal -->
<div class="modal fade" id="seat-booking-modal" tabindex="-1" role="dialog" aria-labelledby="seat_booking_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="seat_booking_modal_label">Seat Booking</h4>
      </div>
      <div class="modal-body">
      	<div class="highlight">
			<form role="form">
				<h4>ATO信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_ato_pre_post">Exam Type</label>
						<select class="form-control" id="input_ato_pre_post">
					      <!-- <option value="NA">请选择</option> -->
					      <option value="PRE">PRE CAT</option>
					      <!-- <option value="POST">POST CAT</option> -->
					    </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_ato_ic">IC Number</label>
						<input class="form-control" id="input_ato_ic" >
					</div>
<!-- 					<div class="col-xs-2">
						<br>
						<a class="button glow button-rounded button-flat" id="student_ato_ic_check" data-toggle="modal" data-target="#student-ato-modal">Check</a>
					</div> -->
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
				</div>
<!-- 				<div class="row">
					<div class="col-xs-4">
						<label for="input_ato_class_code">Class Code</label>
						<input class="form-control" id="input_ato_class_code">
					</div>
					<div class="col-xs-2">
						<br>
						<a class="button glow button-rounded button-flat" id="student_ato_class_check" data-toggle="modal" data-target="#student-ato-class-modal">Check</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_ato_attendance">Attendance</label>
						<input class="form-control" id="input_ato_attendance">
					</div>
					<div class="col-xs-2"></div>
					<div class="col-xs-4">
						<div class="checkbox">
						    <label for="input_ato_post_change_date">
						    	<input type="checkbox" id="input_ato_post_change_date"> 是否改期
						    </label>
						</div>
					</div>
				</div> -->
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
						<label for="input_ato_branch">ATO Branch</label>
						<select class="form-control" id="input_ato_branch"></select>
					</div>
					<div class="col-xs-4">
						<label for="input_ato_op">ATO Operator</label>
						<select class="form-control" id="input_ato_op"></select>
					</div>
					<div class="col-xs-4">
						<label for="input_ato_remark">Remark</label>
						<textarea class="form-control" id="input_ato_remark" rows="3"></textarea>
					</div>
				</div>
				<hr>
			</form>
<!-- 			<div class="row">
				<div class="col-xs-8"></div>
				<div class="col-xs-2">
					<a class="button glow button-rounded button-flat" id="ato_create_submit">Create</a>
				</div>
				<div class="col-xs-2">
					<a class="button glow button-rounded button-flat" id="ato_update_submit">Update</a>
				</div>
			</div> -->
			</div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" id="exam_seat_booking_next_button">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- Class delete Modal -->
<div class="modal fade" id="seat-booking-student-info-modal" tabindex="-1" role="dialog" aria-labelledby="seat_booking_student_info_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="seat_booking_student_info_modal_label">Check Student Basic Information</h4>
      </div>
      <div class="modal-body">
      	<div class="highlight">
			<form role="form" id="student_new_info_form">
				<h4>基本信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_source">学生来源</label>
						<select class="form-control" id="input_student_new_source">
			            	<option value="SSA">SSA</option>
				            <option value="Link1" selected="selected">Link1</option>
			    	        <option value="Changchun">Changchun</option>
			          	</select>
					</div>
					<div class="col-xs-4">
						<br>
						<div class="checkbox">
					    	<label for="input_student_new_gov_letter">
					    		<input type="checkbox" id="input_student_new_gov_letter"> 是否有政府信
					    	</label>
						</div>
					</div>
				</div><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_ic">IC Number</label>
						<input class="form-control" id="input_student_new_ic" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_ic_type">IC Type</label>
					    <select class="form-control" id="input_student_new_ic_type">
					      <option value="0">请选择</option>
					      <option value="1">NRIC</option>
					      <option value="2">FIN</option>
					      <option value="3">Passport</option>
					      <option value="4">Workpermit</option>
					    </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_fn">First Name</label>
						<input class="form-control" id="input_student_new_fn" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_ln">Last Name</label>
						<input class="form-control" id="input_student_new_ln" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_on">Other Name</label>
						<input class="form-control" id="input_student_new_on">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_tel">Tel</label>
						<input class="form-control" id="input_student_new_tel">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_tel_home">Tel Home</label>
						<input class="form-control" id="input_student_new_tel_home">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_gender">Gender</label>
						<select class="form-control" id="input_student_new_gender">
					      <option value="NA">请选择</option>
					      <option value="M">Male（男）</option>
					      <option value="F">Female（女）</option>
					    </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_sal">Salutation</label>
						<select class="form-control" id="input_student_new_sal">
					      <option value="NA">请选择</option>
					      <option value="0">先生</option>
					      <option value="1">太太</option>
					      <option value="2">女士</option>
					      <option value="3">夫人</option>
					      <option value="4">博士</option>
					      <option value="5">教授</option>
					    </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_bd">Birthday</label>
						<input class="form-control" id="input_student_new_bd">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_age">Age</label>
						<input class="form-control" id="input_student_new_age">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_citizenship">Citizenship</label>
						<select class="form-control" id="input_student_new_citizenship">
							<option value="NA">请选择</option>
			                <option value="SG">新加坡公民</option>
			                <option value="PR">新加坡PR</option>
			                <option value="EP">Employment pass</option>
			                <option value="WP">Work permit</option>
			                <option value="SP">Student pass</option>
			                <option value="XX">其他</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_nationality">Nationality</label>
						<select class="form-control" id="input_student_new_nationality">
				            <option value="NA">请选择</option>
				            <option value="SG">Singapore Citizen </option>
				            <option value="CN">Chinese </option>
				            <option value="MY">Malaysian </option>
				            <option value="IN">Indian </option>
				            <option value="ID">Indonesian </option>
				            <option value="AF">Afghan </option>
				            <option value="AL">Albanian </option>
				            <option value="DZ">Algerian </option>
				            <option value="US">American </option>
				            <option value="AS">American Samoa </option>
				            <option value="AD">Andorran </option>
				            <option value="AO">Angolan  </option>
				            <option value="AG">Antigua </option>
				            <option value="AR">Argentinian </option>
				            <option value="AM">Armenian </option>
				            <option value="AU">Australian  </option>
				            <option value="AT">Austrian </option>
				            <option value="AZ">Azerbaijani </option>
				            <option value="BS">Bahamas </option>
				            <option value="BH">Bahraini  </option>
				            <option value="BD">Bangladeshi </option>
				            <option value="BB">Barbados </option>
				            <option value="BL">Belarussian </option>
				            <option value="BE">Belgian  </option>
				            <option value="BZ">Belize </option>
				            <option value="BJ">Benin </option>
				            <option value="BT">Bhutan </option>
				            <option value="BO">Bolivian </option>
				            <option value="BA">Bosnian  </option>
				            <option value="BW">Botswana </option>
				            <option value="GC">Br Dep Ter Citizen </option>
				            <option value="GG">Br Nat. Overseas </option>
				            <option value="GE">Br Overseas Cit.  </option>
				            <option value="GJ">Br Protected Pers. </option>
				            <option value="BR">Brazilian </option>
				            <option value="GB">British </option>
				            <option value="UK">British Subject  </option>
				            <option value="BN">Bruneian </option>
				            <option value="BG">Bulgarian </option>
				            <option value="BF">Burkina Faso </option>
				            <option value="BI">Burundi </option>
				            <option value="CF">C`Tral African Rep </option>
				            <option value="KA">Cambodian </option>
				            <option value="CM">Cameroon </option>
				            <option value="CA">Canadian </option>
				            <option value="CV">Cape Verde  </option>
				            <option value="TD">Chadian </option>
				            <option value="CL">Chilean </option>
				            <option value="CO">Colombian  </option>
				            <option value="KM">Comoros </option>
				            <option value="CG">Congo </option>
				            <option value="CK">Cook Islands </option>
				            <option value="CR">Costa Rican  </option>
				            <option value="CB">Croatian </option>
				            <option value="CU">Cuban </option>
				            <option value="CY">Cypriot </option>
				            <option value="CZ">Czech  </option>
				            <option value="CS">Czechoslovak </option>
				            <option value="DK">Danish </option>
				            <option value="DJ">Djibouti </option>
				            <option value="DM">Dominica </option>
				            <option value="DO">Dominican Republic </option>
				            <option value="NL">Dutch </option>
				            <option value="TP">East Timorese </option>
				            <option value="EC">Ecuadorian </option>
				            <option value="EG">Egyptian  </option>
				            <option value="GQ">Equatorial Guinea </option>
				            <option value="ER">Eritrean </option>
				            <option value="EN">Estonian </option>
				            <option value="ET">Ethiopian  </option>
				            <option value="FJ">Fijian </option>
				            <option value="PH">Filipino </option>
				            <option value="FI">Finnish </option>
				            <option value="FR">French </option>
				            <option value="GF">French Guiana  </option>
				            <option value="PF">French Polynesia </option>
				            <option value="GA">Gabon </option>
				            <option value="GM">Gambian </option>
				            <option value="GO">Georgian  </option>
				            <option value="DG">German </option>
				            <option value="DD">German, East </option>
				            <option value="DE">German, West </option>
				            <option value="GH">Ghanaian  </option>
				            <option value="GD">Grenadian </option>
				            <option value="GP">Guadeloupe </option>
				            <option value="GU">Guam </option>
				            <option value="GT">Guatemala  </option>
				            <option value="GN">Guinea </option>
				            <option value="GW">Guinea-Bissau </option>
				            <option value="GY">Guyana </option>
				            <option value="HN">Honduran </option>
				            <option value="HK">Hong Kong </option>
				            <option value="IS">Iceland </option>
				            <option value="IR">Iranian  </option>
				            <option value="IQ">Iraqi </option>
				            <option value="IE">Irish </option>
				            <option value="IL">Israeli </option>
				            <option value="IT">Italian </option>
				            <option value="CI">Ivory Coast  </option>
				            <option value="JM">Jamaican </option>
				            <option value="JP">Japanese </option>
				            <option value="JO">Jordanian </option>
				            <option value="KH">Kampuchean  </option>
				            <option value="KZ">Kazakh </option>
				            <option value="KE">Kenyan </option>
				            <option value="KG">Kirghiz </option>
				            <option value="KI">Kiribati </option>
				            <option value="KP">Korean, North  </option>
				            <option value="KR">Korean, South </option>
				            <option value="KW">Kuwaiti </option>
				            <option value="KS">Kyrghis </option>
				            <option value="KY">Kyrgyzstan  </option>
				            <option value="LA">Laotian </option>
				            <option value="LV">Latvian </option>
				            <option value="LB">Lebanese </option>
				            <option value="LS">Lesotho </option>
				            <option value="LR">Liberian  </option>
				            <option value="LY">Libyan </option>
				            <option value="LI">Liechtenstein </option>
				            <option value="LH">Lithuanian </option>
				            <option value="LU">Luxembourg  </option>
				            <option value="MO">Macao </option>
				            <option value="MB">Macedonia </option>
				            <option value="MG">Madagascar </option>
				            <option value="MW">Malawi  </option>
				            <option value="MV">Maldivian </option>
				            <option value="ML">Mali </option>
				            <option value="MT">Maltese  </option>
				            <option value="MH">Marshallese </option>
				            <option value="MQ">Martinique </option>
				            <option value="MR">Mauritanean </option>
				            <option value="MU">Mauritian  </option>
				            <option value="MX">Mexican </option>
				            <option value="MF">Micronesian </option>
				            <option value="MD">Moldavian </option>
				            <option value="MC">Monaco  </option>
				            <option value="MN">Mongolian </option>
				            <option value="MA">Moroccan </option>
				            <option value="MZ">Mozambique </option>
				            <option value="BU">Myanmar  </option>
				            <option value="NA">Namibia </option>
				            <option value="NR">Nauruan </option>
				            <option value="NP">Nepalese </option>
				            <option value="NT">Netherlands </option>
				            <option value="AN">Netherlands Antil. </option>
				            <option value="NC">New Caledonia </option>
				            <option value="NZ">New Zealander </option>
				            <option value="NI">Nicaraguan </option>
				            <option value="NE">Niger  </option>
				            <option value="NG">Nigerian </option>
				            <option value="NU">Niue Island </option>
				            <option value="NS">Non-S`Pore Citizen </option>
				            <option value="NO">Norwegian  </option>
				            <option value="OM">Oman </option>
				            <option value="PC">Pacific Is Trust T </option>
				            <option value="PK">Pakistani </option>
				            <option value="PW">Palauan  </option>
				            <option value="PN">Palestinian </option>
				            <option value="PA">Panamanian </option>
				            <option value="PG">Papua New Guinea </option>
				            <option value="PY">Paraguay  </option>
				            <option value="PE">Peruvian </option>
				            <option value="PI">Pitcairn </option>
				            <option value="PL">Polish </option>
				            <option value="PT">Portuguese </option>
				            <option value="PR">Puerto Rican </option>
				            <option value="QA">Qatar </option>
				            <option value="RE">Reunion </option>
				            <option value="RO">Romanian </option>
				            <option value="SU">Russian  </option>
				            <option value="RF">Russian </option>
				            <option value="RW">Rwanda </option>
				            <option value="SV">Salvadoran </option>
				            <option value="WS">Samoan </option>
				            <option value="ST">Sao Tome &amp; Princi. </option>
				            <option value="SA">Saudi Arabian </option>
				            <option value="SN">Senegalese </option>
				            <option value="SC">Seychelles </option>
				            <option value="SL">Sierra Leone </option>
				            <option value="SK">Slovak </option>
				            <option value="SI">Slovenian </option>
				            <option value="SB">Solomon Islands </option>
				            <option value="SO">Somali </option>
				            <option value="ZA">South African </option>
				            <option value="ES">Spanish </option>
				            <option value="LK">Sri Lankan  </option>
				            <option value="SW">St Kitts &amp; Nevis </option>
				            <option value="LC">St. Lucia </option>
				            <option value="VC">St. Vincent </option>
				            <option value="SD">Sudanese  </option>
				            <option value="SR">Suriname </option>
				            <option value="SZ">Swazi </option>
				            <option value="SE">Swedish </option>
				            <option value="CH">Swiss </option>
				            <option value="SY">Syrian  </option>
				            <option value="TJ">Tadzhik </option>
				            <option value="TW">Taiwanese </option>
				            <option value="TI">Tajikistani </option>
				            <option value="TZ">Tanzanian  </option>
				            <option value="TH">Thai </option>
				            <option value="TE">Timorense </option>
				            <option value="TG">Togo </option>
				            <option value="TK">Tokelau Islands  </option>
				            <option value="TO">Tonga </option>
				            <option value="TT">Trinidad &amp; Tobago </option>
				            <option value="TN">Tunisia</option>
				            <option value="TR">Turk  </option>
				            <option value="TM">Turkmen </option>
				            <option value="TV">Tuvalu </option>
				            <option value="UG">Ugandian </option>
				            <option value="UR">Ukrainian </option>
				            <option value="AE">United Arab Em. </option>
				            <option value="UN">Unknown </option>
				            <option value="HV">Upper Volta </option>
				            <option value="UY">Uruguay </option>
				            <option value="UZ">Uzbek  </option>
				            <option value="VU">Vanuatu </option>
				            <option value="VE">Venezuelan </option>
				            <option value="VN">Vietnamese </option>
				            <option value="WF">Wallis And Futuna  </option>
				            <option value="EH">Western Sahara </option>
				            <option value="YE">Yemen Arab Rep </option>
				            <option value="YD">Yemen, South </option>
				            <option value="YM">Yemeni  </option>
				            <option value="YU">Yugoslav </option>
				            <option value="ZR">Zairan </option>
				            <option value="ZM">Zambian </option>
				            <option value="ZW">Zimbabwean </option>
				            <option value="XX">Other </option>
						</select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_race">Race</label>
						<select class="form-control" id="input_student_new_race">
			            	<option value="NA">请选择</option>
				            <option value="CN">Chinese(华人)</option>
				            <option value="MY">Malay(马来)</option>
				            <option value="IN">Indian(印度)</option>
				            <option value="EU">Eurasian(欧洲)</option>
				            <option value="Other">Other(其他)</option>
						</select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_cnlevel">华文学历</label>
			            <select class="form-control" id="input_student_new_cnlevel">
				            <option value="NA">请选择</option>
				            <option value="01">No Formal Qualification &amp; Lowe</option>
				            <option value="11">Primary PSLE</option>
				            <option value="20">Lower Secondary</option>
				            <option value="31">'N' Level or equivalent</option>
				            <option value="32">'O' Level or equivalent</option>
				            <option value="41">'A' Level or equivalent</option>
				            <option value="70">Professional Qualification &amp; O</option>
				            <option value="80">University First Degree</option>
				            <option value="90">University Post-graduate Diplo</option>
				            <option value="XX">Not Reported</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_edulevel">教育水平</label>
							<select class="form-control" id="input_student_new_edulevel">
					            <option value="NA">请选择</option>
					            <option value="01">No Formal Qualification &amp; Lower Primary </option>
					            <option value="11">Primary PSLE</option>
					            <option value="20">Lower Secondary</option>
					            <option value="35">ITE Skills Certification (ISC)</option>
					            <option value="31">'N' Level or equivalent</option>
					            <option value="32">'O' Level or equivalent</option>
					            <option value="41">'A' Level or equivalent</option>
					            <option value="51">NITEC/Post Nitec</option>
					            <option value="54">WSQ Certificate</option>
					            <option value="52">Higher NITEC</option>
					            <option value="55">WSQ Higher Certificate</option>
					            <option value="53">Master NITEC</option>
					            <option value="61">Polytechnic Diploma</option>
					            <option value="73">WSQ Advance Certificate</option>
					            <option value="74">WSQ Diploma</option>
					            <option value="75">WSQ Specialist Diploma</option>
					            <option value="70">Professional Qualification &amp; Other Diploma</option>
					            <option value="80">University First Degree</option>
					            <option value="92">WSQ Graduate Certificate</option>
					            <option value="93">WSQ Graduate Diploma</option>
					            <option value="90">University Post-graduate Diploma &amp; Degree/Master/Doctorate</option>
					            <option value="XX">Not Reported</option>
				            </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_lang">使用语言</label>
						<select class="form-control" id="input_student_new_lang">
				            <option value="NA">请选择</option>
				            <option value="Chinese">Chinese(中文)</option>
				            <option value="English">English(英语)</option>
				            <option value="Malay">Malay(马来语)</option>
				            <option value="Tamil">Tamil(泰米尔语)</option>
				            <option value="Others">Others(其他)</option>
			            </select>
					</div>
				</div>
				<h4>住址信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_blk">BLK</label>
						<input class="form-control" id="input_student_new_blk">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_street">Street</label>
						<input class="form-control" id="input_student_new_street">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_floor_unit">#Floor-Unit No.</label>
						<input class="form-control" id="input_student_new_floor_unit">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_building">Building Name</label>
						<input class="form-control" id="input_student_new_building">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_postcode">Postcode</label>
						<input class="form-control" id="input_student_new_postcode">
					</div>
				</div>
				<h4>工作信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_empstatus">工作状态</label>
				          <select class="form-control" id="input_student_new_empstatus">
				            <option value="NA">请选择</option>
				            <option value="EMP001">Employed</option>
				            <option value="EMP002">Unemployed</option>
				          </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_comn">公司名称</label>
						<input class="form-control" id="input_student_new_comn" value="NA">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_com_type">公司注册类型</label>
						<select class="form-control" id="input_student_new_com_type">
			                <option value="NA">请选择</option>
			                <option value="ROC">Registry of Company</option>
			                <option value="ROB">Registry of Business</option>
			                <option value="UENO">Other Unique Establishments (UENO)</option>
			                <option value="OTHERS">Others - None of the Above</option>
				          </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_com_reg_no">公司注册号</label>
						<input class="form-control" id="input_student_new_com_reg_no" value="NA">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_industry">行业</label>
			            <select class="form-control" id="input_student_new_industry">
			                <option value="NA">请选择</option>
			                <option value="1" selected="selected">Others</option>
			                <option value="2">Aerospace</option>
			                <option value="3">Bio-Medical Sciences</option>
			                <option value="4">Business Process Outsourcing</option>
			                <option value="5">Chemicals</option>
			                <option value="6">Creative</option>
			                <option value="7">Construction</option>
			                <option value="8">Electronics</option>
			                <option value="9">Environment</option>
			                <option value="10">Finance</option>
			                <option value="11">Food Mfg &amp; Processing</option>
			                <option value="12">Government / Public Services</option>
			                <option value="13">Healthcare</option>
			                <option value="14">Horticulture</option>
			                <option value="15">Hospitality</option>
			                <option value="16">Infocomm Technology</option>
			                <option value="17">Logistics and Transportation</option>
			                <option value="18">Marine</option>
			                <option value="19">Maritime</option>
			                <option value="20">Precision ?Engineering</option>
			                <option value="21">Printing</option>
			                <option value="22">Professional Services</option>
			                <option value="23">Process</option>
			                <option value="24">Repair and Servicing</option>
			                <option value="25">Retail</option>
			                <option value="26">Security</option>
			                <option value="27">Social &amp; Community Services</option>
			                <option value="28">Sports and Recreation</option>
			                <option value="29">Textile</option>
			            </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_designation">职称</label>
			            <select class="form-control" id="input_student_new_designation">
			                <option value="NA">请选择</option>
			                <option value="01">Legislators, Senior Officials and Mangers</option>
			                <option value="02">Professionals</option>
			                <option value="03">Associate Professionals and Technicians</option>
			                <option value="04">Clerical Workers</option>
			                <option value="05">Service Works and Shop and Market Sales Workers</option>
			                <option value="06">Agricultural and Fishery Workers</option>
			                <option value="07">Production Craftsmen &amp; Related Workers</option>
			                <option value="08">Plan and Machine Operators and Assemblers</option>
			                <option value="09">Cleaners, Laborers and Related Workers</option>
			                <option value="10" selected="selected">Workers not classified by Occupation</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_sal_range">薪水范围</label>
			            <select class="form-control" id="input_student_new_sal_range">
			                <option value="NA">请选择</option>
			                <option value="00" selected="selected">Unemployed</option>
			                <option value="01">Below $1,000</option>
			                <option value="02">$1,000 - $1,400</option>
			                <option value="03a">$1,401 - $1,700</option>
			                <option value="03b">$1,701 - $2,000</option>
			                <option value="04">$2,000 - $2,499</option>
			                <option value="05">$2,500 - $2,999</option>
			                <option value="06">$3,000 - $3,499</option>
			                <option value="07">$3,500 and above</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_branch">Operator Branch</label>
						<select class="form-control" id="input_student_new_branch"></select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_op">Operator</label>
						<select class="form-control" id="input_student_new_op"></select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_remark">Remark</label>
						<textarea class="form-control" id="input_student_new_remark" rows="3"></textarea>
					</div>
				</div>
			</form>
			<hr>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="seat_booking_student_info_modal_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Student no info Modal -->
<div class="modal fade" id="seat-booking-student-info-fail-modal" tabindex="-1" role="dialog" aria-labelledby="seat_booking_student_info_fail_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="seat_booking_student_info_fail_modal_label">Check Student Basic Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>