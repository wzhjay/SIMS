<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 01.05.2014 
 -->

 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/owl.carousel.css">
	 
	<!-- Default Theme -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/owl.theme.css">

	<!-- Include js plugin -->
	<script src="<?php echo base_url() ?>assets/owl-carousel/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#sims-banner").owlCarousel({
 
			    // navigation : true, // Show next and prev buttons
			    slideSpeed : 300,
			    paginationSpeed : 400,
			    singleItem:true
			 
			    // "singleItem:true" is a shortcut for:
			    // items : 1, 
			    // itemsDesktop : false,
			    // itemsDesktopSmall : false,
				// itemsTablet: false,
			    // itemsMobile : false
		 
			});
		});
	</script>
</head>

<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<body>
<?php $this->load->view('partials/banner') ?>
	<div class="container">
	<?php echo form_open($this->uri->uri_string()); ?>
	<table>
		<tr>
			<td><?php echo form_label($login_label, $login['id']); ?></td>
			<td><?php echo form_input($login); ?></td>
			<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
		</tr>
		<tr>
			<td><?php echo form_label('Password', $password['id']); ?></td>
			<td><?php echo form_password($password); ?></td>
			<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
		</tr>

		<?php if ($show_captcha) {
			if ($use_recaptcha) { ?>
		<tr>
			<td colspan="2">
				<div id="recaptcha_image"></div>
			</td>
			<td>
				<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
				<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
				<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="recaptcha_only_if_image">Enter the words above</div>
				<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
			</td>
			<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
			<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
			<?php echo $recaptcha_html; ?>
		</tr>
		<?php } else { ?>
		<tr>
			<td colspan="3">
				<p>Enter the code exactly as it appears:</p>
				<?php echo $captcha_html; ?>
			</td>
		</tr>
		<tr>
			<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
			<td><?php echo form_input($captcha); ?></td>
			<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
		</tr>
		<?php }
		} ?>

		<tr>
			<td colspan="3">
				<?php echo form_checkbox($remember); ?>
				<?php echo form_label('Remember me', $remember['id']); ?>
				<?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
				<!-- <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?> -->
			</td>
		</tr>
	</table>
	<?php echo form_submit('submit', 'Let me in'); ?>
	<?php echo form_close(); ?>
	</div>
</body>

</html>