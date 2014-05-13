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
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/parsley/parsley.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/buttons/font-awesome.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/buttons/buttons.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/docs.css"/>

	<!-- js files -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/parsley/parsley.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/buttons/buttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
	<script type="text/javascript">
		window.api_url = "http://sims.com/SIMS/index.php/api/";

		// var ci_session_string = decodeURIComponent(readCookie('ci_session'));
		// alert("window.api_url: " + window.api_url + " window.session_string: " + get_cookie('session_id'));

		// function readCookie(name) {
		//     var nameEQ = name + "=";
		//     var ca = document.cookie.split(';');
		//     for(var i=0;i < ca.length;i++) {
		//         var c = ca[i];
		//         while (c.charAt(0)==' ') c = c.substring(1,c.length);
		//         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		//     }
		//     return null;
		// }

		// function get_cookie(cookie_name)
		// {
		//     var cookie_string = readCookie('ci_session');
		//     alert("cookie_string: " + cookie_string);
		//     if (cookie_string.length != 0) {
		//         var cookie_value = cookie_string.match (
		//                         cookie_name +
		//                         '=([^;]*)' );
		//         alert("cookie value: " + cookie_value);
		//         return decodeURIComponent ( cookie_value[2] ) ;
		//     }
		//     return '' ;
		// }
		moment().format();
	</script>
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