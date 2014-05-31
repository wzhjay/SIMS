<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 15.05.2014 
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
	<?php $this->load->view('partials/financial/financial_banner') ?>
    <div class="container" id="sims-financial-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">收入部分</a></li>
			  <li><a href="#tab-2" data-toggle="tab">支出部分</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">
			  		<h3>添加或更新收入信息</h3><hr>
					<?php $this->load->view('partials/financial/financial_receipt_form') ?>
					<br><br>
					<h3>查询收费信息</h3><hr>
					<?php $this->load->view('partials/financial/financial_search_receipt_form') ?>
			  	</div>
			  	<div class="tab-pane fade" id="tab-2">
			  		<h3>添加或更新支出信息</h3><hr>
					<?php $this->load->view('partials/financial/financial_expense_form') ?>
					<br><br>
					<h3>查询支出信息</h3><hr>
					<?php $this->load->view('partials/financial/financial_search_expense_form') ?>
				</div>
			</div>
		</div>
    </div>
</body>