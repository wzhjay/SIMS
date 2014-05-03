<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bav-bar-sims">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $this->config->base_url(); ?>index.php/welcome">长春教育管理系统</a>
	</div>
	<div class="collapse navbar-collapse" id="bav-bar-sims">
          <ul class="nav navbar-nav pull-right">
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/students">学员管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/classes">班级管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/exams">考试管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/system">系统管理</a></li>
          </ul>
        </div>
</nav>
	this is header!! 
	<?php 
		if($this->session->userdata('user_id')) 
			echo 'Hi! '.$this->session->userdata('username'); 
	?>
<hr>