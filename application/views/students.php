<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 02.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#input_reg_search_from').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_reg_search_to').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_reg_date').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_student_bd').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#my_tab a').click(function (e) {
			  $(this).tab('show')
			});
			$('#student_info_form').parsley();
		});
	</script>
</head>
<div class="sims-docs-header" id="sims-students-header">
	<div class="container">
    	<h1>Students</h1>
    	<p>Global CSS settings, fundamental HTML elements styled and enhanced with extensible classes, and an advanced grid system.</p>
    </div>
</div>
<div class="container" id="sims-students-tabs">
	<div class="container tab_content">
		<ul class="nav nav-tabs" id="my_tab">
		  <li class="active"><a href="#tab-1" data-toggle="tab">基本信息</a></li>
		  <li><a href="#tab-2" data-toggle="tab">报名信息</a></li>
		  <li><a href="#tab-3" data-toggle="tab">收入支出</a></li>
		  <li><a href="#tab-4" data-toggle="tab">ATO信息</a></li>
		  <li><a href="#tab-5" data-toggle="tab">检索学员</a></li>
		  <li><a href="#tab-6" data-toggle="tab">输入成绩</a></li>
		</ul>

		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="tab-1">
		  		<h3 id="new-student-info">输入学员基本信息</h3><hr>
				<?php $this->load->view('partials/student_info_form') ?>
			</div>
		  	<div class="tab-pane fade" id="tab-2">
		  		<h3 id="new-reg-info">输入新的注册信息</h3><hr>
				<?php $this->load->view('partials/registration_form') ?>
				<br><br>
				<h3 id="new-reg-info">查询所有注册信息</h3><hr>
				<?php $this->load->view('partials/registration_search') ?>
		  	</div>
		  <div class="tab-pane fade" id="tab-3">
		  	
		  </div>
		  <div class="tab-pane fade" id="tab-4">
		  	
		  </div>
		  <div class="tab-pane fade" id="tab-5">
		  	
		  </div>
		  <div class="tab-pane fade" id="tab-6">
		  	
		  </div>
		</div>
	</div>
</div>