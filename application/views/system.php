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
	<div class="sims-docs-header" id="sims-system-header">
      <div class="container">
        <h1>System</h1>
        <p>Global CSS settings, fundamental HTML elements styled and enhanced with extensible classes, and an advanced grid system.</p>
      </div>
    </div>
    <div class="container" id="sims-system-tabs">
    	<div class="container tab_content">
			<ul class="nav nav-tabs" id="my_tab">
			  <li class="active"><a href="#tab-1" data-toggle="tab">管理员</a></li>
			  <li><a href="#tab-2" data-toggle="tab">创建管理员</a></li>
			  <li><a href="#tab-3" data-toggle="tab">数据库</a></li>
			</ul>

			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="tab-1">
			  		
				</div>
			  	<div class="tab-pane fade" id="tab-2">
			  		
			  	</div>
			  <div class="tab-pane fade" id="tab-3">
			  	
			  </div>
			</div>
		</div>
    </div>
</body>