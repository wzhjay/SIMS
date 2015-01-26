<!doctype html>

<header>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title><?php $template['title'] ?></title>
	<?php echo $template['metadata']; ?>

	<!-- css files -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css"/>
	<link type='text/css' rel="stylesheet" href="<?php echo base_url() ?>assets/datepicker/css/datepicker3.css" >
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/parsley/parsley.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/buttons/font-awesome.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/buttons/buttons.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/docs.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/toastr/toastr.min.css"/>

	<!-- js files -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/parsley/parsley.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/buttons/buttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/toastr/toastr.min.js"></script>
	<script type="text/javascript">
		window.api_url = "http://sims.com/SIMS/index.php/api/";
		//window.api_url = "http://changchun.edu.sg/system/index.php/api/";

		toastr.options = {
		  "closeButton": false,
		  "debug": false,
		  "positionClass": "toast-top-left",
		  "onclick": null,
		  "showDuration": "200",
		  "hideDuration": "1000",
		  "timeOut": "3500",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "show",
		  "hideMethod": "fadeOut"
		}
		moment().format();
	</script>
	<!-- header -->
	<?php 
		if($this->apis->check_user_role() == 'admin') {
			$this->load->view('partials/header');
		} else {
			$this->load->view('partials/header_operator');
		}
	?>
</header>
<body>
	<div class='sims-body'>
		<?php echo $template['body']; ?>
	</div>
	<?php $this->load->view('partials/footer') ?>
</body>
</html>