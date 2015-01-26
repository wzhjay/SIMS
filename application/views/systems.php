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
<body>
	<?php $this->load->view('partials/systems/system_banner') ?>
    <div class="container" id="sims-system-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">创建管理员</a></li>
			  <li><a href="#tab-2" data-toggle="tab">管理员</a></li>
			  <li><a href="#tab-3" data-toggle="tab">数据库</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">
			  		<h3>注册新的管理员</h3><hr>
			  		<?php $this->load->view('partials/systems/system_to_register_form') ?>
			  		<br><br>
			  		<h3>分配新注册管理员权限</h3><hr>
			  		<?php $this->load->view('partials/systems/system_assign_new_admin_role_form') ?>
			  	</div>
			  	<div class="tab-pane fade" id="tab-2">
			  		<h3>查询管理员</h3><hr>
					<?php $this->load->view('partials/systems/system_all_search_form') ?>
					<br><br>
					<h3>所有管理员</h3><hr>
					<?php $this->load->view('partials/systems/system_all_admin_form') ?>
				</div>
			  <div class="tab-pane fade" id="tab-3">
			  	
			  </div>
			</div>
		</div>
    </div>
</body>