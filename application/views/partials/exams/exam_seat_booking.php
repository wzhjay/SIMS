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
										          	'<td><input type="text" class="form-control" value="' + reply[key].je_09 + '"></td>' +
										          	'<td><input type="text" class="form-control" value="' + reply[key].pi_09 + '"></td>' +
												'</tr>' +
												'<tr>' +
													'<td>14:00</td>' +
										          	'<td><input type="text" class="form-control" value="' + reply[key].je_14 + '"></td>' +
										          	'<td><input type="text" class="form-control" value="' + reply[key].pi_14 + '"></td>' +
												'</tr>' +
												'<tr>' +
													'<td>19:00</td>' +
										          	'<td><input type="text" class="form-control" value="' + reply[key].je_19 + '"></td>' +
										          	'<td><input type="text" class="form-control" value="' + reply[key].pi_19 + '"></td>' +
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
								          	'<td><input type="text" class="form-control" value="0"></td>' +
								          	'<td><input type="text" class="form-control" value="0"></td>' +
										'</tr>' +
										'<tr>' +
											'<td>14:00</td>' +
								          	'<td><input type="text" class="form-control" value="0"></td>' +
								          	'<td><input type="text" class="form-control" value="0"></td>' +
										'</tr>' +
										'<tr>' +
											'<td>19:00</td>' +
								          	'<td><input type="text" class="form-control" value="0"></td>' +
								          	'<td><input type="text" class="form-control" value="0"></td>' +
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

		function afterLoadEachDateContent() {
			$.each($('.booking_date_this_month'), function() {
				if($(this).find('.exam_seat_booking_on_off').val() == 'off') {
					$(this).find('table').css('background','rgb(228, 228, 228)');
					$(this).find('table input').prop('disabled', true);
					$(this).find('table input').css('background','rgb(204, 204, 204)');
				} else {
					$(this).find('table').css('background','');
					$(this).find('table input').prop('disabled', false);
					$.each($(this).closest('.booking_date_this_month').find('input'), function() {
						if($(this).val() != '0') {
							$(this).css('background', 'rgb(0, 255, 0)');
						} else {
							$(this).css('background', 'rgb(255, 255, 0)');
						}
					});
				}
			});

			$('.booking_date_this_month input').on('change', function() {
				if($(this).val() != '0') {
					$(this).css('background', 'rgb(0, 255, 0)');
				} else {
					$(this).css('background', 'rgb(255, 255, 0)');
				}
			});

			$('.exam_seat_booking_on_off').on('change', function() {
				var el = $(this).closest('.booking_date_this_month');
				if($(this).val() == 'off') {
					update_seat_booking_info_on_off(el);
					el.find('table').css('background','rgb(228, 228, 228)');
					el.find('table input').prop('disabled', true);
					el.find('table input').css('background','rgb(204, 204, 204)');
				} else {
					el.find('table').css('background','');
					el.find('table input').prop('disabled', false);
					$.each(el.find('input'), function() {
						if($(this).val() != '0') {
							$(this).css('background', 'rgb(0, 255, 0)');
						} else {
							$(this).css('background', 'rgb(255, 255, 0)');
						}
					});
				}
			});
		}

		function create_update_seat_booking_info() {
			$.each($('.booking_date_this_month'), function() {
				var on_off = $(this).find('.exam_seat_booking_on_off').val();
				if(on_off == 'on') {
					var day = $(this).find('.exam_seat_booking_content_each_date').text();

					var je_09 = $(this).find('tbody').find('tr:nth-child(2)').find('td:nth-child(2) input').val();
					var pi_09 = $(this).find('tbody').find('tr:nth-child(2)').find('td:nth-child(3) input').val();

					var je_14 = $(this).find('tbody').find('tr:nth-child(3)').find('td:nth-child(2) input').val();
					var pi_14 = $(this).find('tbody').find('tr:nth-child(3)').find('td:nth-child(3) input').val();

					var je_19 = $(this).find('tbody').find('tr:nth-child(4)').find('td:nth-child(2) input').val();
					var pi_19 = $(this).find('tbody').find('tr:nth-child(4)').find('td:nth-child(3) input').val();

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

			var je_09 = me.find('tbody').find('tr:nth-child(2)').find('td:nth-child(2) input').val();
			var pi_09 = me.find('tbody').find('tr:nth-child(2)').find('td:nth-child(3) input').val();

			var je_14 = me.find('tbody').find('tr:nth-child(3)').find('td:nth-child(2) input').val();
			var pi_14 = me.find('tbody').find('tr:nth-child(3)').find('td:nth-child(3) input').val();

			var je_19 = me.find('tbody').find('tr:nth-child(4)').find('td:nth-child(2) input').val();
			var pi_19 = me.find('tbody').find('tr:nth-child(4)').find('td:nth-child(3) input').val();

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
	<div class="row">
		<div class="col-xs-10"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="exam_seat_booking_submit">Submit</a>
		</div>
	</div>
</div>