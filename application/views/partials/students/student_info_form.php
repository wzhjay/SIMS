<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 09.05.2014 
 -->
 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			$('#student_info_form').parsley();
			$('#input_student_bd').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
	</script>
</head>
<div class="highlight">
<form role="form" id="student_info_form">
	<h4>基本信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_ic">IC Number</label>
			<input class="form-control" id="input_student_ic" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_student_fn">First Name</label>
			<input class="form-control" id="input_student_fn" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_student_ln">Last Name</label>
			<input class="form-control" id="input_student_ln" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_on">Other Name</label>
			<input class="form-control" id="input_student_on">
		</div>
		<div class="col-xs-4">
			<label for="input_student_tel">Tel</label>
			<input class="form-control" id="input_student_tel">
		</div>
		<div class="col-xs-4">
			<label for="input_student_tel_home">Tel Home</label>
			<input class="form-control" id="input_student_tel_home">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_gender">Gender</label>
			<select class="form-control" id="input_student_gender">
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_sal">Salutation</label>
			<select class="form-control" id="input_student_sal">
				<option>Mr</option>
				<option>Mrs</option>
				<option>Ms</option>
				<option>Miss</option>
				<option>Dr</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_bd">Birthday</label>
			<input class="form-control" id="input_student_bd">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_age">Age</label>
			<input class="form-control" id="input_student_age">
		</div>
		<div class="col-xs-4">
			<label for="input_student_ic_type">IC Type</label>
			<select class="form-control" id="input_student_ic_type">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_citizenship">Citizenship</label>
			<select class="form-control" id="input_student_citizenship">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_nationality">Nationality</label>
			<select class="form-control" id="input_student_nationality">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_race">Race</label>
			<select class="form-control" id="input_student_race">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_cnlevel">华文学历</label>
			<input class="form-control" id="input_student_cnlevel">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_edulevel">教育水平</label>
			<input class="form-control" id="input_student_edulevel">
		</div>
	</div>
	<h4>工作信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_empstatus">工作状态</label>
			<input class="form-control" id="input_student_empstatus">
		</div>
		<div class="col-xs-4">
			<label for="input_student_comn">公司名称</label>
			<input class="form-control" id="input_student_comn">
		</div>
		<div class="col-xs-4">
			<label for="input_student_com_status">公司状态</label>
			<input class="form-control" id="input_student_com_status">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_com_reg_no">公司注册号</label>
			<input class="form-control" id="input_student_com_reg_no">
		</div>
		<div class="col-xs-4">
			<label for="input_student_industry">行业</label>
			<select class="form-control" id="input_student_industry">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_designation">职称</label>
			<input class="form-control" id="input_student_designation">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_sal_range">薪水范围</label>
			<select class="form-control" id="input_student_sal_range">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_lang">使用语言</label>
			<input class="form-control" id="input_student_lang">
		</div>
	</div>
</form>
<hr>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="student_new_submit">Submit</a>
	</div>
</div>
</div>