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
			  $(this).tab('show');
			});
		});
	</script>
</head>
<body>
    <?php $this->load->view('partials/classes/class_banner') ?>
    <div class="container" id="sims-classes-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">所有班级和查询</a></li>
			  <li><a href="#tab-2" data-toggle="tab">添加更新班级</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">
			  		<h3>查询班级信息</h3><hr>
					<?php $this->load->view('partials/classes/class_search_form') ?>
					<br><br>
					<h3>所有班级 [最近前100]</h3><hr>
					<?php $this->load->view('partials/classes/class_all_class_form') ?>
				</div>
			  	<div class="tab-pane fade" id="tab-2">
			  		<h3>添加或更新班级信息</h3><hr>
			  		<?php
						if($this->apis->check_user_role() == 'admin') {
							$this->load->view('partials/classes/class_create_update_form');
						} else if($this->apis->check_user_role() == 'operator'){
							$this->load->view('partials/classes/class_create_update_form_operator');
						}
					?>
					<br><br>
			  	</div>
			</div>
		</div>
    </div>
</body>