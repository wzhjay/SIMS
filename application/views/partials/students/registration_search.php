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
			var from = '0000-00-00';
			var to  = '2100-01-01';
			if($('#input_reg_search_from').val().trim() != "") {
				from = $('#input_reg_search_from').val();
			}
			if($('#input_reg_search_to').val().trim() != "") {
				to = $('#input_reg_search_to').val();
			}

			// class time
			var any_am = $('#input_reg_search_any_am').is(':checked') ? '1' : '0';
			var any_pm = $('#input_reg_search_any_pm').is(':checked') ? '1' : '0';
			var any_eve = $('#input_reg_search_any_eve').is(':checked') ? '1' : '0';
			var sat_am = $('#input_reg_search_sat_am').is(':checked') ? '1' : '0';
			var sat_pm = $('#input_reg_search_sat_pm').is(':checked') ? '1' : '0';
			var sat_eve = $('#input_reg_search_sat_eve').is(':checked') ? '1' : '0';
			var sun_am = $('#input_reg_search_sun_am').is(':checked') ? '1' : '0';
			var sun_pm = $('#input_reg_search_sun_pm').is(':checked') ? '1' : '0';
			var sun_eve = $('#input_reg_search_sun_eve').is(':checked') ? '1' : '0';
			var anytime = $('#input_reg_search_anytime').is(':checked') ? '1' : '0';


			var target = $('#reg_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchRegistrationInfo",
			    data:{from:from, to:to, any_am:any_am, any_pm:any_pm, any_eve:any_eve, sat_am:sat_am, sat_pm:sat_pm, sat_eve:sat_eve, sun_am:sun_am, sun_pm:sun_pm, sun_eve:sun_eve, anytime:anytime},
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
														'<div class="row">' +
															'<div class="col-xs-8">' +
																'<a data-toggle="collapse" data-parent="reg_record_collapse_'+key+'" href="#reg_record_collapse_body_'+key+'">Record ' + num + '  /  Reg Date: <b>' + reply[key].reg_date + '</b>' + '  /  IC: <b>' + reply[key].ic + '</b>' + '  /  Reg NO.: <b>' + reply[key].reg_no + '</b>' + '</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="reg_search_update_'+reply[key].reg_id+'" >Update</a>' + 
															'</div>' + 
															'<div class="col-xs-2">' +
																'<a class="button glow button-rounded button-flat" id="reg_search_delete_'+reply[key].reg_id+'" data-toggle="modal" data-target="#reg-delete-modal">Delete</a>' + 
															'</div>' + 
														'</div>' + 
													' </h4>' +
												'</div>' +
												'<div id="reg_record_collapse_body_'+key+'" class="panel-collapse collapse">' + 
													'<div class="panel-body">' + 
														'<div class="row">' + 
															'<div class="col-xs-4">'+ 
																'<div>Registered Branch: ' + reply[key].reg_branch + '</div>' +
															'</div>' + 
															'<div class="col-xs-4">' +
																'<div>Student Branch: ' + reply[key].assigned_branch + '</div>' + 
															'</div>' +
															'<div class="col-xs-4">' +
																'<div>Operator: '+ reply[key].username + '</div>' + 
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

							$('#reg_search_results .button').on('click', function() {
				 				var el_id = $(this).attr('id').split('_');
				 				var reg_record_id = el_id[3];
				 				selected_reg_id = reg_record_id;
				 				if(el_id[2] == "update") {
				 					// update reg record
				 					load_reg_record(reg_record_id);
				 				} else if(el_id[2] == "delete") {
				 					// delete reg record
				 					var modalBody = $('#reg_delete_modal_label').closest('.modal-content').find('.modal-body');
									modalBody.empty();
									modalBody.append(
										'<div class="row">' + 
											'<div class="col-xs-10">'+
												'<label>Sure you want to delete this registration record?</label><br>' +
												'<label>确定你要删除这条注册记录？</label>' +
											'</div>' +	
										'</div>'
									);
				 					$('#reg_del_confirm_btn').on('click', function() {
				 						delete_reg_by_id(reg_record_id);
				 					});
				 				}
				 			});

						} else {
							target.append('<p>No Registration Records Found</p><br>');
						}
					}else {
						toastr.info("No Registration Records Found");
					}
			    }
			});//End ajax
		}

		function load_reg_record(reg_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "getRegistrationByID",
			    data:{reg_id:reg_record_id},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				$('#input_reg_ic').val(reply[key].ic);
								$('#input_reg_date').val(reply[key].reg_date);
								$('#input_reg_branch option[id="reg_branch_'+reply[key].reg_branch_id+'"]').attr('selected', 'selected');
								$('#input_reg_no').val(reply[key].reg_no);
								$('#input_reg_branch option[id="new_user_'+reply[key].reg_op_id+'"]').attr('selected', 'selected');
								$('#input_reg_start_date').val(reply[key].start_date_wanted);
								$('#input_reg_branch_student option[id="reg_branch_stu_'+reply[key].student_branch_id+'"]').attr('selected', 'selected');
								$('#input_reg_remark').val(reply[key].reg_remark);

								(reply[key].any_am == "1") ? $('#input_reg_any_am').prop('checked', true) : $('#input_reg_any_am').prop('checked', false);
								(reply[key].any_pm == "1") ? $('#input_reg_any_pm').prop('checked', true) : $('#input_reg_any_pm').prop('checked', false);
								(reply[key].any_eve == "1") ? $('#input_reg_any_eve').prop('checked', true) : $('#input_reg_any_eve').prop('checked', false);
								(reply[key].sat_am == "1") ? $('#input_reg_sat_am').prop('checked', true) : $('#input_reg_sat_am').prop('checked', false);
								(reply[key].sat_pm == "1") ? $('#input_reg_sat_pm').prop('checked', true) : $('#input_reg_sat_pm').prop('checked', false);
								(reply[key].sat_eve == "1") ? $('#input_reg_sat_eve').prop('checked', true) : $('#input_reg_sat_eve').prop('checked', false);
								(reply[key].sun_am == "1") ? $('#input_reg_sun_am').prop('checked', true) : $('#input_reg_sun_am').prop('checked', false);
								(reply[key].sun_pm == "1") ? $('#input_reg_sun_pm').prop('checked', true) : $('#input_reg_sun_pm').prop('checked', false);
								(reply[key].sun_eve == "1") ? $('#input_reg_sun_eve').prop('checked', true) : $('#input_reg_sun_eve').prop('checked', false);
								(reply[key].anytime == "1") ? $('#input_reg_anytime').prop('checked', true) : $('#input_reg_anytime').prop('checked', false);
			            	}
			            }
			            $("html, body").animate({ scrollTop: 0 }, "slow");
			            toastr.info("Update registration record on above form!");
			        }else{
			        	toastr.error("Fail to load registration record!");
			        }
			    }
			});//End ajax
		}

		function delete_reg_by_id(reg_record_id) {
			$.ajax({
				type:"post",
			    url:window.api_url + "deleteRegistrationByID",
			    data:{reg_id:reg_record_id},
			    success:function(json){
			    	if(json.trim() == '3') {
					    toastr.success("Delete success!");
					    
					    // clear deleted element
					    $('#reg_search_delete_' + reg_record_id).closest('.panel-group').remove();
					}else{
						toastr.error("Fail to delete registration info!");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
<form action="<?php echo $this->config->base_url(); ?>index.php/api/searchRegistrationInfoDownload" method="POST" target="_blank">
	<h4>注册报名时间</h4><hr>
	<div class="row">
		<div class="input-daterange" id="reg_datepicker">
			<div class="col-xs-4">
				<input name="from" class="form-control" id="input_reg_search_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input name="to" class="form-control" id="input_reg_search_to" placeholder="To">
			</div>
		</div>
	</div>
	<h4>想要上课时间</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_any_am">
		          	<input name="any_am" type="checkbox" id="input_reg_search_any_am" value="1"> 平时早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_any_pm">
		          	<input name="any_pm" type="checkbox" id="input_reg_search_any_pm" value="1"> 平时下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_any_eve">
		          	<input name="any_eve" type="checkbox" id="input_reg_search_any_eve" value="1"> 平时晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sat_am">
		          	<input name="sat_am" type="checkbox" id="input_reg_search_sat_am" value="1"> 拜六早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sat_pm">
		          	<input name="sat_pm" type="checkbox" id="input_reg_search_sat_pm" value="1"> 拜六下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sat_eve">
		          	<input name="sat_eve" type="checkbox" id="input_reg_search_sat_eve" value="1"> 拜六晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sun_am">
		          	<input name="sun_am" type="checkbox" id="input_reg_search_sun_am" value="1"> 拜天早上
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sun_pm">
		          	<input name="sun_pm" type="checkbox" id="input_reg_search_sun_pm" value="1"> 拜天下午
		        </label>
		    </div>
		</div>
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_sun_eve">
		          	<input name="sun_eve" type="checkbox" id="input_reg_search_sun_eve" value="1"> 拜天晚上
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="checkbox">
		        <label for="input_reg_search_anytime">
		          	<input name="anytime" type="checkbox" id="input_reg_search_anytime" value="1"> 任意时间
		        </label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<input type="submit" value="To Excel" class="button glow button-rounded button-flat" id="reg_to_excel">
		</div>
	</div>
</form>
	<div id="reg_search_results"></div>
</div>

<!-- reg delete Modal -->
<div class="modal fade" id="reg-delete-modal" tabindex="-1" role="dialog" aria-labelledby="reg_delete_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="reg_delete_modal_label">Delete Registration Record?</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="reg_del_confirm_btn">Confirm</button>
      </div>
    </div>
  </div>
</div>