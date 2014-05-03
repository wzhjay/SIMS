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
		      effect: 'flip'
		    });
		});
	</script>
</head>
<body>
	<div class="sims-docs-header" id="sims-students-header">
      <div class="container">
        <h1>Students</h1>
        <p>Global CSS settings, fundamental HTML elements styled and enhanced with extensible classes, and an advanced grid system.</p>
      </div>
    </div>
    <div class="container" id="sims-students-tabs">
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1" title="基本信息" class="tabulous_active">基本信息</a></li>
				<li><a href="#tabs-2" title="报名信息">报名信息</a></li>
				<li><a href="#tabs-3" title="收入支出">收入支出</a></li>
				<li><a href="#tabs-4" title="ATO信息">ATO信息</a></li>
				<li><a href="#tabs-5" title="检索学员">检索学员</a></li>
				<li><a href="#tabs-6" title="输入成绩">输入成绩</a></li>
			</ul>

			<div id="tabs_container">
				<div id="tabs-1">
					    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.</p><p>Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
				</div>
				<div id="tabs-2">
					    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor.</p>
				</div>
				<div id="tabs-3">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div id="tabs-4">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div id="tabs-5">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div id="tabs-6">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
			</div><!--End tabs container-->
		</div>
    </div>
</body>
</html>