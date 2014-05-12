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
<body>
    <?php $this->load->view('partials/classes/class_banner') ?>
    <div class="container" id="sims-classes-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">所有班级</a></li>
			  <li><a href="#tab-2" data-toggle="tab">学员管理</a></li>
			  <li><a href="#tab-3" data-toggle="tab">添加班级</a></li>
			  <li><a href="#tab-4" data-toggle="tab">班级管理</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">

				</div>
			  	<div class="tab-pane fade" id="tab-2">
			  	
			  	</div>
			  <div class="tab-pane fade" id="tab-3">
			  	
			  </div>
			  <div class="tab-pane fade" id="tab-4">
			  	
			  </div>
			</div>
		</div>
    </div>
</body>