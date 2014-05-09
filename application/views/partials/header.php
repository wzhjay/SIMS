<nav class="navbar navbar-default navbar-fixed-top" id="top" role="navigation">
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
            <?php 
                if($this->tank_auth->is_logged_in()) {
                    echo '<li class="dropdown">';
                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$this->tank_auth->get_username().' <b class="caret"></b></a>';
                    echo '<ul class="dropdown-menu" role="menu">';
                    echo '<li><a href="#">Region</a></li>';
                    echo '<li><a href="#">Chatting Room</a></li>';
                    echo '<li><a href="#">Change Password</a></li>';
                    echo '<li class="divider"></li>';
                    echo '<li><a href="#">Profile</a></li>';
                    echo '<li class="divider"></li>';
                    echo '<li><a href='.$this->config->base_url().'index.php/auth/logout>Logout</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
            ?>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/students">学员管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/classes">班级管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/exams">考试管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/system">系统管理</a></li>
          </ul>
    </div>
  </div>
</nav>
<hr>