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
					            '<h4>Sutdent Basic Information</h4><hr>');
				            for (var key in reply) {
					    		if (reply.hasOwnProperty(key)) {
					            	target.append(
					            		JSON.stringify(reply[key]) + 
					            		'<br>');
					            }
					        }
					        target.append('<br>');

					        $.ajax({
								type:"post",
							    url:window.api_url + "getStudentATOInfoByIC",
							    data:{ic:key_word},
							    success:function(json){
							        if(json != null) {
							        	var reply = $.parseJSON(json);
							            if(reply.length > 0 ) {
							            	target.append('<h4>Sutdent ATO Information</h4><hr>');
								            for (var key in reply) {
									    		if (reply.hasOwnProperty(key)) {
									            	target.append(
									            		JSON.stringify(reply[key]) + 
									            		'<br>');
									            }
									        }
									        target.append('<br>');

									        $.ajax({
												type:"post",
											    url:window.api_url + "getStudentRecordsByIC",
											    data:{ic:key_word},
											    success:function(json){
											        if(json != null) {
											        	var reply = $.parseJSON(json);
											            if(reply.length > 0 ) {
											            	target.append('<h4>Sutdent Exam Records</h4><hr>');
												            for (var key in reply) {
													    		if (reply.hasOwnProperty(key)) {
													            	target.append(
													            		JSON.stringify(reply[key]) + 
													            		'<br>');
													            }
													        }
													        target.append('<br>');
														} else {
															target.append('<p>No Exam Records found</p><br>');
														}
											        }else {
											        	alert("fail to call search api");
													}
											    }
											});//End ajax
										} else {
											target.append('<p>No ATO Information found</p><br>');
										}
							        }else {
							        	alert("fail to call search api");
									}
							    }
							});//End ajax
						}
			        }else {
			        	alert("fail to call search api");
					}
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<div class="row">
		<div id="student_search">
			<div class="col-xs-2">
				<label for="input_student_search_ic">请输入学员IC：</label>
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_student_search_ic" placeholder="IC Number">
			</div>
			<div class="col-xs-2"></div>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="student_to_excel">To Excel</a>
		</div>
	</div>
	<div id="student_search_results"></div>
</div>