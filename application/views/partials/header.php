<div class='container'>
	this is header!! 
	<?php 
		if($this->session->userdata('user_id')) 
			echo 'Hi! '.$this->session->userdata('username'); 
	?>
</div>
<hr>