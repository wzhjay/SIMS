 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();

			$('#class_search_type').on('change', function() {
				var target = $('#class_search_type_input');
				target.empty();
				var selected = $('#class_search_type option:selected').val();
				if(selected == 'code') {
					$(target).append('<input class="form-control" id="input_class_search_code" placeholder="Class Code">');
				}
				else if(selected == 'type') {
					$(target).append(
						'<div class="col-xs-4">'+
							'<select class="form-control" id="input_class_search_type" >' +
						        '<option value="NA">请选择</option>' +
						        '<option value="encmp">综合</option>' +
						        '<option value="encon">会话</option>' +
						        '<option value="eness">ESS</option>' +
								'<option value="encos">COS</option>' +
						        '<option value="encom">英文电脑</option>' +
						        '<option value="chcom">华文电脑</option>' +
						        '<option value="chpin">拼音</option>' +
						        '<option value="enpho">音标</option>' +
						        '<option value="engra">语法</option>' +
						        '<option value="chwri">华文作文</option>' +
						        '<option value="others">花艺</option>' +
						        '<option value="others">其他</option>' +
						    '</select>' +
					    '</div>'
						);
				}
				else if(selected == 'level') {
					$(target).append(
						'<div class="col-xs-4">'+
							'<select class="form-control" id="input_class_search_level">' +
						      	'<option value="NA">请选择</option>' +
						     	'<option value="BEGINNERS">初级</option>' +
						      	'<option value="INTERMEDIATE">中级</option>' +
						      	'<option value="ADVANCED">高级</option>' +
					    	'</select>' +
					    '</div>'
						);	
				}
				else if(selected == 'status') {
					$(target).append(
						'<div class="col-xs-4">'+
							'<select class="form-control" id="input_class_search_status" >' +
						      '<option value="NA">请选择</option>' +
						      '<option value="preparing">未开班</option>' +
						      '<option value="learning">已开班</option>' +
						      '<option value="waitexam">待考试</option>' +
						      '<option value="finished">已结束</option>' +
						    '</select>' +
						'</div>'
						);
				}
				else if(selected == 'start_date') {
					$(target).append(
						'<div class="input-daterange">'+
							'<div class="col-xs-4">' +
								'<input class="form-control" id="input_class_search_from" placeholder="From">' +
							'</div>' +
							'<div class="col-xs-4">' +
								'<input class="form-control" id="input_class_search_to" placeholder="To">' +
							'</div>' +
						'</div>'
						);
					$('#input_class_search_from').datepicker({
						format: 'yyyy-mm-dd'
					});

					$('#input_class_search_to').datepicker({
						format: 'yyyy-mm-dd'
					});
				}
				else if(selected == 'end_date') {
					$(target).append(
						'<div class="input-daterange">'+
							'<div class="col-xs-4">' +
								'<input class="form-control" id="input_class_search_from" placeholder="From">' +
							'</div>' +
							'<div class="col-xs-4">' +
								'<input class="form-control" id="input_class_search_to" placeholder="To">' +
							'</div>' +
						'</div>'
						);
					$('#input_class_search_from').datepicker({
						format: 'yyyy-mm-dd'
					});

					$('#input_class_search_to').datepicker({
						format: 'yyyy-mm-dd'
					});
				}
			});

 			$('#class_info_search_submit').on('click', function() {
 				search_class_info_by_types();
 			});
		});

 		function search_class_info_by_types() {
 			var code = "";
 			var type = "";
 			var level = "";
 			var from = '2000-01-01';
			var to  = '2100-01-01';
			var selected = $('#class_search_type option:selected').val();

			if(selected == 'code') {
				code = $('#input_class_search_code').val();
			}
			else if(selected == 'type') {
				type = $('#input_class_search_type option:selected').val();
			}
			else if(selected == 'level') {
				level = $('#input_class_search_level option:selected').val();
			}
			else if(selected == 'status') {
				status = $('#input_class_search_status option:selected').val();
			}
			else if(selected == 'start_date' || selected == 'end_date') {
				if($('#input_class_search_from').val().trim() != "") {
					from = $('#input_class_search_from').val();
				}
				if($('#input_class_search_to').val().trim() != "") {
					to = $('#input_class_search_to').val();
				}
			}

			var target = $('#class_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchClassInfo",
			    data:{code:code, type:type, level:level, status:status, from:from, to:to, indicator:selected},
			    success:function(json){
			    	target.empty();
			    	target.append('<p>No class info found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.empty();
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		target.append();
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
 		}
	</script>
</head>
<div class="highlight">
	<label>选择查询类型</label>
	<div class="row">
		<div class="col-xs-4">
			<select class="form-control" id="class_search_type">
				<option value="code">Class Code</option>
				<option value="type">Type</option>
				<option value="level">Level</option>
				<option value="status">Status</option>
				<option value="start_date">Start Date</option>
				<option value="end_date">End Date</option>
			</select>
		</div>
	</div>
	<br>
	<label>输入查询信息</label>
	<div class="row">
		<div id="class_search_type_input">
			<div class="col-xs-4">
					<input class="form-control" id="input_class_search_code" placeholder="Class Code">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="class_info_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="class_info_to_excel">To Excel</a>
		</div>
	</div>
	<div id="class_search_results"></div>
</div>