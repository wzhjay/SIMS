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
<?php $this->load->view('partials/atos/ato_banner') ?>
<div class="container" id="sims-atos-tabs">
	<div class="container tab_content">
		<ul class="nav nav-tabs" id="my_tab">
		  <li class="active"><a href="#tab-1" data-toggle="tab">ATO更新与查询</a></li>
		  <li><a href="#tab-2" data-toggle="tab">班级ATO生成</a></li>
		</ul>

		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="tab-1">
				<h3>输入或更新学员ATO信息</h3><hr>
				<?php $this->load->view('partials/atos/ato_post_form') ?>
				<br><br>
				<h3>信息不完整(姓名/电话/postcode/年龄/国籍)学生IC</h3><hr>
				<?php $this->load->view('partials/atos/ato_student_info_warning_form') ?>
				<br><br>
		  		<h3>查询并生成ATO信息</h3><hr>
		  		<?php $this->load->view('partials/atos/ato_search_form') ?>
			</div>
		  	<div class="tab-pane fade" id="tab-2">
		  		<h3>生成班级ATO</h3><hr>
				<?php $this->load->view('partials/atos/ato_class_post') ?>
				<br><br>
		  	</div>
		</div>
	</div>
</div>