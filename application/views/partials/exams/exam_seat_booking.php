 <head>
	<meta charset="utf-8">

	<script>
		var pre_next = -0;
		$(document).ready(function($) {
			build_exam_booking_calender(pre_next)
			if(pre_next == 0) {
				$('.cal_today').css('background', '#ECDDDD');
			}
		});

		function build_exam_booking_calender(_pre_next) {
			var t_date = new Date();
	        var day = t_date.getDate();
	        if((t_date.getMonth() + _pre_next) > 12) {
	        	var month = (t_date.getMonth() + _pre_next) % 12;
	        	var year = t_date.getYear() + Math.floor((t_date.getMonth() + _pre_next)/12);
	        }
	        else if((t_date.getMonth() + _pre_next) < 1) {
	        	var month = 12 - ((t_date.getMonth() + _pre_next)*(-1))%12 ;
	        	var year = t_date.getYear() - Math.floor(((t_date.getMonth() + _pre_next) * (-1))/12) - 1;
	        } else {
	        	var month = t_date.getMonth() + _pre_next;
	        	var year = t_date.getYear();
	        }
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
                html += '<td class="cal_days_bef_aft" id="exam_seat_booking_date_' + (days_in_month[month-1]-beg_j+i) +'"><div class="exam_seat_booking_content_each_date">'+(days_in_month[month-1]-beg_j+i)+'</div></td>';
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
                        html += '<td class="cal_today" id="exam_seat_booking_date_' + i +'"><div class="exam_seat_booking_content_each_date">'+i+'</div></td>';
                }
                else
                {
                        html += '<td id="exam_seat_booking_date_' + i +'"><div class="exam_seat_booking_content_each_date">'+i+'</div></td>';
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
                html += '<td class="cal_days_bef_aft" id="exam_seat_booking_date_' + i +'"><div class="exam_seat_booking_content_each_date">'+i+'</div></td>';
                week++;
                if(week==7)
                {
                        html += '</tr>';
                        week=0;
                }
	        }
	        date_table.append($.parseHTML(html));
		}
	</script>
</head>
<div class="highlight" id="exam_seat_booking_calendar_section_highlight">
	<div class="row">
		<div class="col-xs-12" id="exam_seat_booking_calendar_section">
			<div id='exam_seat_booking_calendar'>
				<div class="row">
					<div class="col-xs-5"></div>
					<div class="col-xs-4"><h1><span class="label label-info">输入座位数目</span></h1></div>
					<div class="col-xs-3"></div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<ul class="pager">
						  <li class="previous"><a href="#">&larr; Prebious</a></li>
						  <li class="next"><a href="#">Next &rarr;</a></li>
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
					    <tbody id='exam_booking_calender_date_table'>
					        <!-- <tr>
					          <td>
					          	<div class="exam_seat_booking_content_each_date">
						          	<div id='exam_seat_booking_date_1'>1</div>
						          	<table class="table table-bordered">
										<tbody>
											<tr>
												<td></td>
									          	<td>JE</td>
									          	<td>UN</td>
											</tr>
											<tr>
												<td>09:00</td>
									          	<td><input type="text" class="form-control" value="12"></td>
									          	<td><input type="text" class="form-control" value="0"></td>
											</tr>
											<tr>
												<td>14:00</td>
									          	<td><input type="text" class="form-control" value="12"></td>
									          	<td><input type="text" class="form-control" value="0"></td>
											</tr>
											<tr>
												<td>19:00</td>
									          	<td><input type="text" class="form-control" value="12"></td>
									          	<td><input type="text" class="form-control" value="0"></td>
											</tr>
										</tbody>	
									</table>
								</div>
					          </td>
					          <td>2</td>
					          <td>3</td>
					          <td>4</td>
					          <td>5</td>
					          <td>6</td>
					          <td>7</td>
					        </tr>
					        <tr>
					          <td>8</td>
					          <td>9</td>
					          <td>10</td>
					          <td>11</td>
					          <td>12</td>
					          <td>13</td>
					          <td>14</td>
					        </tr>
					        <tr>
					          <td>15</td>
					          <td>16</td>
					          <td>17</td>
					          <td>18</td>
					          <td>19</td>
					          <td>20</td>
					          <td>21</td>
					        </tr>
					        <tr>
					          <td>22</td>
					          <td>23</td>
					          <td>24</td>
					          <td>25</td>
					          <td>26</td>
					          <td>27</td>
					          <td>28</td>
					        </tr>
					        <tr>
					          <td>29</td>
					          <td>30</td>
					          <td>31</td>
					        </tr> -->
					      </tbody>
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