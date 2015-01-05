<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {

		});
	</script>
</head>
<div class="highlight">
	<form role="form" action="<?php echo $this->config->base_url(); ?>index.php/api/uploadStudentBasicInfo" method="post" target="_blank" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-4"></div>
			<div class="col-xs-8">
				<label for="input_student_upload_info_file">XLS/XLSX文件</label>
		    	<input type="file" name="userfile" id="input_student_upload_info_file">
		    </div>
		</div>
		<div class="row">
		<div class="col-xs-10"></div>
			<div class="col-xs-2">
				<input class="button glow button-rounded button-flat" type='submit' id="student_info_upload" value="Upload">
			</div>
		</div>
	</form>
</div>