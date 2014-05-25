 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();

			$('#input_class_search_start_from').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_class_search_start_to').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_class_search_end_from').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_class_search_end_to').datepicker({
				format: 'yyyy-mm-dd'
			});

 			$('#class_info_search_submit').on('click', function() {
 				search_class_info_by_types();
 			});

 			class_search_load_branches();
		});

		function class_search_load_branches() {
			var branches = $('#input_class_search_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	branches.append('<option value="class_search_branch_ALL">ALL</option>');
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="class_search_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	alert("fail to load braches");
			        }
			    }
			});//End ajax
		}

 		function search_class_info_by_types() {
 			var code = $('#input_class_search_code').val();;
 			var type = $('#input_class_search_type option:selected').val();
 			var level = $('#input_class_search_level option:selected').val();
 			var status = $('#input_class_search_status option:selected').val();
 			var branch = $('#input_class_search_branch option:selected').attr('id').split('_');
 			var branch_id = branch[3];

 			var start_from = '2000-01-01';
			var start_to  = '2100-01-01';
			var end_from = '2000-01-01';
			var end_to  = '2100-01-01';
			
			if($('#input_class_search_start_from').val().trim() != "") {
				start_from = $('#input_class_search_start_from').val();
			}

			if($('#input_class_search_start_to').val().trim() != "") {
				start_to = $('#input_class_search_start_to').val();
			}

			if($('#input_class_search_end_from').val().trim() != "") {
				end_from = $('#input_class_search_end_from').val();
			}

			if($('#input_class_search_end_to').val().trim() != "") {
				end_to = $('#input_class_search_end_to').val();
			}

			var target = $('#class_search_results');
			target.empty();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchClassInfo",
			    data:{code:code, type:type, level:level, status:status, branch_id:branch_id, start_from:start_from, start_to:start_to, end_from:end_from, end_to:end_to},
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
	<h4>输入查询信息</h4>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_search_code">Class Code</label>
			<input class="form-control" id="input_class_search_code">
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_type">Class Type</label>
			<select class="form-control" id="input_class_search_type" >
				<option value="NA">请选择</option>
				<option value="encmp">综合</option>
				<option value="encon">会话</option>
				<option value="eness">ESS</option>
				<option value="encos">COS</option>
				<option value="encom">英文电脑</option>
				<option value="chcom">华文电脑</option>
				<option value="chpin">拼音</option>
				<option value="enpho">音标</option>
				<option value="engra">语法</option>
				<option value="chwri">华文作文</option>
				<option value="others">花艺</option>
				<option value="others">其他</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_type">Class Level</label>
			<select class="form-control" id="input_class_search_level">
		      	<option value="NA">请选择</option>
		     	<option value="BEGINNERS">初级</option>
		      	<option value="INTERMEDIATE">中级</option>
		      	<option value="ADVANCED">高级</option>
	    	</select>
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-4">
			<label for="input_class_search_status">Status</label>
			<select class="form-control" id="input_class_search_status" >
		      <option value="NA">请选择</option>
		      <option value="preparing">未开班</option>
		      <option value="learning">已开班</option>
		      <option value="waitexam">待考试</option>
		      <option value="finished">已结束</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_class_search_branch">Branch</label>
			<select class="form-control" id="input_class_search_branch" ></select>
		</div>
	</div>
	<label>Start Date</label>
	<div class="row">
		<div class="input-daterange">
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_start_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_start_to" placeholder="To">
			</div>
		</div>
	</div>
	<label>End Date</label>
	<div class="row">
		<div class="input-daterange">
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_end_from" placeholder="From">
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="input_class_search_end_to" placeholder="To">
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