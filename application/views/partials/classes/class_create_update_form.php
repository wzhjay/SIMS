 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_class_start_date').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('#input_class_end_date').datepicker({
				format: 'yyyy-mm-dd'
			});

			class_load_branches();
		});

		function class_load_branches() {
			var branches = $('#input_class_branch');
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
			    				branches.append('<option id="class_new_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	alert("fail to load braches");
			        }
			    }
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
<form role="form">
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_code">Class Code</label>
			<input class="form-control" id="input_class_code" >
		</div>
		<div class="col-xs-2">
			<br>
			<a class="button glow button-rounded button-flat" id="class_class_code_check" data-toggle="modal" data-target="#class-new-modal">Check</a>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-4">
			<label for="input_class_branch">Branch</label>
			<select class="form-control" id="input_class_branch"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<label for="input_class_type">Class Type</label>
			<select class="form-control" id="input_class_type" >
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
		<div class="col-xs-3">
			<label for="input_class_level">Class Level</label>
			<select class="form-control" id="input_class_level">
		      <option value="NA">请选择</option>
		      <option value="BEGINNERS">初级</option>
		      <option value="INTERMEDIATE">中级</option>
		      <option value="ADVANCED">高级</option>
		    </select>
		</div>
		<div class="col-xs-3">
			<label for="input_class_status">Class Status</label>
			<select class="form-control" id="input_class_status" >
		      <option value="NA">请选择</option>
		      <option value="preparing">未开班</option>
		      <option value="learning">已开班</option>
		      <option value="waitexam">待考试</option>
		      <option value="finished">已结束</option>
		    </select>
		</div>
		<div class="col-xs-3">
			<label for="input_class_location">Location</label>
			<input class="form-control" id="input_class_location">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<label for="input_class_start_date">Start Date</label>
			<input class="form-control" id="input_class_start_date" >
		</div>
		<div class="col-xs-3">
			<label for="input_class_end_date">End Date</label>
			<input class="form-control" id="input_class_end_date" >
		</div>
		<div class="col-xs-3">
			<label for="input_class_start_time">Start Time (0000~2359)</label>
			<input class="form-control" id="input_class_start_time" >
		</div>
		<div class="col-xs-3">
			<label for="input_class_end_time">End Time (0000~2359)</label>
			<input class="form-control" id="input_class_end_time" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_teacher_name">Teacher's Name</label>
			<input class="form-control" id="input_class_teacher_name" >
		</div>
		<div class="col-xs-4">
			<label for="input_class_teacher_tel">Teacher's Tel</label>
			<input class="form-control" id="input_class_teacher_tel" >
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_class_remark">Remark</label>
			<textarea class="form-control" id="input_class_remark" rows="3"></textarea>
		</div>
	</div>
	<hr>
</form>
<div class="row">
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="class_new_submit">Create</a>
	</div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="class_update_submit">Update</a>
	</div>
</div>
</div>

<!-- Class code Check Modal -->
<div class="modal fade" id="class-new-modal" tabindex="-1" role="dialog" aria-labelledby="class_code_check_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="class_code_check_modal_label">Class Information</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>