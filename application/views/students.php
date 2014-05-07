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
	<script type="text/javascript" src="<?php echo base_url() ?>assets/tabulous/tabulous.js"></script>
	<script>
		$(document).ready(function($) {
			$('#tabs').tabulous({
		      effect: 'scale'
		    });
		});
		$('.collapse').collapse();
		$('#my-affix').affix({
		    offset: {
		      top: 100
		    , bottom: function () {
		        return (this.bottom = $('.footer').outerHeight(true))
		      }
		    }
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
				<div class="tab_container" id="tabs-1">
					    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus.</p><p>Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
				</div>
				<div class="tab_container" id="tabs-2">
					<h2 id="new-reg-info">输入新的注册信息</h2><hr>
					<div class="highlight" role="form">
						<div class="row">
						  	<div class="col-xs-4">
						  		<label for="input_ic">IC Number</label>
								<input class="form-control" id="input_ic" placeholder="IC Number">
						  	</div>
  							<div class="col-xs-4">
  								<label for="input_reg_date">Register Date</label>
								<input class="form-control" id="input_reg_date" placeholder="Register Date">
  							</div>
  							<div class="col-xs-4">
  								<label for="input_reg_branch">Register Branch</label>
								<input class="form-control" id="input_reg_branch" placeholder="Register Branch">
  							</div>
						</div>
						<div class="row">
						  	<div class="col-xs-4">
						  		<label for="input_reg_no">Register Number</label>
								<input class="form-control" id="input_reg_no" placeholder="Register Number">
						  	</div>
  							<div class="col-xs-4">
  								<label for="input_reg_op">Register Operator</label>
								<input class="form-control" id="input_reg_op" placeholder="Register Operator">
  							</div>
  							<div class="col-xs-4">
  								<label for="input_start_date">Start Date Wanted</label>
								<input class="form-control" id="input_start_date" placeholder="Start Date Wanted">
  							</div>
						</div>
						<div class="row">
						  	<div class="col-xs-4">
						  		<label for="input_reg_status">Status</label>
								<input class="form-control" id="input_reg_status" placeholder="Register Status">
						  	</div>
						</div>
						<div class="row">
  							<div class="col-xs-4">
  								<label for="input_reg_remark">Remark</label>
  								<textarea class="form-control" id="input_reg_remark" rows="3"></textarea>
  							</div>
						</div>
						<hr>
					  	<button class="btn btn-default" id="reg_new_submit">Submit</button>
					</div>
					<br><br>
					<h2 id="new-reg-info">查询所以注册信息</h2><hr>
					<div class="highlight" role="form">
						<div class="row">
						  	<div class="col-xs-4">
								<input class="form-control" id="input_reg_search_from" placeholder="From">
						  	</div>
  							<div class="col-xs-4">
								<input class="form-control" id="input_reg_search_to" placeholder="To">
  							</div>
  							<div class="col-xs-2">
  								<button class="btn btn-default" id="reg_search_submit">Search</button>
  							</div>
  							<div class="col-xs-2">
  								<button class="btn btn-default" id="reg_to_excel">TO Excel</button>
  							</div>
						</div>
					</div>
				<div class="tab_container" id="tabs-3">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div class="tab_container" id="tabs-4">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div class="tab_container" id="tabs-5">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
				<div class="tab_container" id="tabs-6">
					    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem.</p><p> Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales.</p>
				</div>
			</div><!--End tabs container-->
		</div>
    </div>
</body>
</html>