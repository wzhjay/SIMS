<!doctype html>

<header>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title><?php $template['title'] ?></title>
	<?php echo $template['metadata']; ?>

	<!-- css files -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css"/>

	<!-- js files -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>

	<!-- header -->
	<?php $this->load->view('partials/header') ?>
</header>
<body>
	<div class='container'>
		<?php echo $template['body']; ?>
	</div>
	<?php $this->load->view('partials/footer') ?>
</body>
</html>