 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			$('#input_reg_search_from').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});
			$('#input_reg_search_to').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			$('#reg_search_submit').on('click', function() {
				search_reg_info();
			});
		});


		function search_reg_info() {
			var from = '2000-01-01';
			var to  = '2100-01-01';
			if($('#input_reg_search_from').val().trim() != "") {
				from = $('#input_reg_search_from').val();
			}
			if($('#input_reg_search_to').val().trim() != "") {
				to = $('#input_reg_search_to').val();
			}
			var target = $('#reg_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchRegistrationInfo",
			    data:{from:from, to:to},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No registration info found</p>');
			        if(json.trim() != "") {
						var reply = $.parseJSON(json);
						if(reply.length > 0 ) {
							target.empty();
							target.append('<h4>Sutdent Registration Records (报名记录)</h4><hr>');
							for (var key in reply) {
								var num = parseInt(key) + 1;
								if (reply.hasOwnProperty(key)) {
									var any_am = (reply[key].any_am == "1") ? "平时上午" : "";
									var any_pm = (reply[key].any_pm == "1") ? "平时下午" : "";
									var any_eve = (reply[key].any_eve == "1") ? "平时晚上" : "";
									var sat_am = (reply[key].sat_am == "1") ? "拜六上午" : "";
									var sat_pm = (reply[key].sat_pm == "1") ? "拜六下午" : "";
									var sat_eve = (reply[key].sat_eve == "1") ? "拜六晚上" : "";
									var sun_am = (reply[key].sun_am == "1") ? "拜天上午" : "";
									var sun_pm = (reply[key].sun_pm == "1") ? "拜天下午" : "";
									var sun_eve = (reply[key].sun_eve == "1") ? "拜天晚上" : "";
									var anytime = (reply[key].anytime == "1") ? "任意时间" : "";
									var class_time = any_am + " " + any_pm + " " + any_eve + " " + sat_am + " " + sat_pm + " " + sat_eve + " " + sun_am + " " + sun_pm + " " + sun_eve + " " + anytime;
									target.append(
										'<div class="panel-group" id="reg_record_collapse_'+key+'">' +
											'<div class="panel panel-default">' + 
												'<div class="panel-heading">' +
													'<h4 class="panel-title">' +
														'<a data-toggle="collapse" data-parent="reg_record_collapse_'+key+'" href="#reg_record_collapse_body_'+key+'">Reg Record ' + num + '  /  Reg Date: <b>' + reply[key].reg_date + '</b>' + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Reg Number: <b>' + reply[key].reg_no + '</b>' + '</a>' + 
													' </h4>' +
												'</div>' +
												'<div id="reg_record_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-3">'+ 
																'<div>Registered Branch: ' + reply[key].reg_branch + '</div>' +
															'</div>' + 
															'<div class="col-xs-3">' +
																'<div>Student Branch: ' + reply[key].assigned_branch + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Operator: '+ reply[key].username + '</div>' + 
															'</div>' +
															'<div class="col-xs-3">' +
																'<div>Intend To Start: '+ reply[key].start_date_wanted + '</div>' + 
															'</div>' +
														'</div>' + 
														'<hr>' + 
														'<div class="row">' + 
															'<div class="col-xs-12">'+ 
																'<div>上课时间: ' + class_time + '</div>' +
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
																'<div>Remark: '+ reply[key].reg_remark + '</div>' + 
															'</div>' +
														'</div>' + 
													'</div>' + 
												'</div>' + 
											'</div>' +
										'</div>'
									);
								}
							}
						} else {
							target.append('<p>No Registration Records Found</p><br>');
						}
					}else {
						toastr.info("No Registration Records Found");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="reg_search">
				<div class="input-daterange" id="reg_datepicker">
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_from" placeholder="From">
					</div>
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_to" placeholder="To">
					</div>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_to_excel">To Excel</a>
		</div>
	</div>
	<div id="reg_search_results"></div>
</div>