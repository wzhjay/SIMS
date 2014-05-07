<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 02.05.2014 
 -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<!-- Include js plugin -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/tabulous/tabulous.min.js"></script>
	<script>
		$(document).ready(function($) {
			$('#tabs').tabulous({
		      effect: 'scale'
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
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1" title="管理员" class="tabulous_active">管理员</a></li>
				<li><a href="#tabs-2" title="创建管理员">创建管理员</a></li>
				<li><a href="#tabs-3" title="数据库">数据库</a></li>
			</ul>

			<div id="tabs_container">
				<div class="tab_container" id="tabs-1">
					    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.</p><p>Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
				</div>
				<div class="tab_container" id="tabs-2">
					    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor.</p>
				</div>
				<div class="tab_container" id="tabs-3">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
			</div><!--End tabs container-->
		</div>
    </div>
</body>
</html>