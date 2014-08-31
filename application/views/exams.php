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
    <?php $this->load->view('partials/exams/exam_banner') ?>
    <div class="container" id="sims-exams-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">定位信息</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">
			  		<h3>添加或更新考试定位信息</h3><hr>
					<?php
						if($this->apis->check_user_role() == 'admin') {
							$this->load->view('partials/exams/exam_seat_booking'); 
						} else if($this->apis->check_user_role() == 'operator'){
							$this->load->view('partials/exams/exam_seat_booking_operator');
						}
					?>
					<br><br>
				</div>
			</div>
		</div>
    </div>
</body>