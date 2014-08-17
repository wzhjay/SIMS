<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 10.05.2014 
 -->
 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {

		});
	</script>
</head>
<div class="highlight">
	<form role="form" action="<?php echo $this->config->base_url(); ?>index.php/api/uploadExamResults" method="post" target="_blank" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-4"></div>
			<div class="col-xs-8">
				<label for="input_student_upload_exam_file">XLS/XLSX文件</label>
		    	<input type="file" name="userfile" id="input_student_upload_exam_file">
		    </div>
		</div>
		<div class="row">
		<div class="col-xs-10"></div>
			<div class="col-xs-2">
				<input class="button glow button-rounded button-flat" type='submit' id="student_exam_upload" value="Upload">
			</div>
		</div>
	</form>
</div>