<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 02.05.2014 
 -->
<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			$('#my_tab a').click(function (e) {
			  $(this).tab('show')
			});
		});
	</script>
</head>
<?php $this->load->view('partials/students/student_banner') ?>
<div class="container" id="sims-students-tabs">
	<div class="container tab_content">
		<ul class="nav nav-tabs" id="my_tab">
		  <li class="active"><a href="#tab-1" data-toggle="tab">报名信息</a></li>
		  <li><a href="#tab-2" data-toggle="tab">基本信息</a></li>
		  <li><a href="#tab-3" data-toggle="tab">查看学员信息</a></li>
		  <li><a href="#tab-4" data-toggle="tab">全部学员管理</a></li>
		  <li><a href="#tab-5" data-toggle="tab">学生成绩管理</a></li>
		</ul>

		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="tab-1">
		  		<h3>添加或更新注册信息</h3><hr>
		  		<?php
					if($this->apis->check_user_role() == 'admin') {
						$this->load->view('partials/students/registration_form');
					} else if($this->apis->check_user_role() == 'operator'){
						$this->load->view('partials/students/registration_form_operator');
					}
				?>
				<br><br>
				<h3>查询所有注册信息</h3><hr>
				<?php $this->load->view('partials/students/registration_search') ?>
			</div>
		  	<div class="tab-pane fade" id="tab-2">
				<h3>输入或更新学员基本信息</h3><hr>
				<?php $this->load->view('partials/students/student_info_form') ?>
				<br><br>
				<h3>上传学生信息</h3><hr>
				<?php
					if($this->apis->check_user_role() == 'admin') {
						$this->load->view('partials/students/student_info_upload'); 
					}
				?>
		  	</div>
		  	<div class="tab-pane fade" id="tab-3">
		  		<h3>查询学员信息</h3><hr>
				<?php $this->load->view('partials/students/student_search_form') ?>
		  	</div>
		  	<div class="tab-pane fade" id="tab-4">
		  		<h3>全部学员</h3><hr>
				<?php $this->load->view('partials/students/student_all_students') ?>
		  	</div>
		  	<div class="tab-pane fade" id="tab-5">
		  		<h3>输入学生成绩信息</h3><hr>
				<?php $this->load->view('partials/students/student_input_exams_records_form') ?>
				<br><br>
				<h3>学生成绩信息查询</h3><hr>
				<?php $this->load->view('partials/students/student_exams_search') ?>
				<br><br>
				<h3>导入学生成绩信息</h3><hr>
				<?php $this->load->view('partials/students/student_upload_exams_records_form') ?>
		  	</div>
		</div>
	</div>
</div>