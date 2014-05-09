<!doctype html>
<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 29.04.2014 
 -->
<header>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title><?php $template['title'] ?></title>
	<?php echo $template['metadata']; ?>

	<!-- css files -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css"/>
	<link type='text/css' rel="stylesheet" href="<?php echo base_url() ?>assets/datepicker/css/datepicker3.css" >
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/docs.css"/>

	<!-- js files -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/datepicker/js/bootstrap-datepicker.js"></script>
	
	<!-- header -->
	<?php $this->load->view('partials/header') ?>
</header>
<body>
	<div class='sims-body'>
		<?php echo $template['body']; ?>
	</div>
	<?php $this->load->view('partials/footer') ?>
</body>
</html>