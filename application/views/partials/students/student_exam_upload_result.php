<?php
	if(sizeof($result) > 1) {
		echo '<h3>File upload successfully!</b></h3><br><hr>';
		foreach ($result as $item => $value):
			echo '<li>'.$item.': '.$value.'</li>';
		endforeach;
	} else {
		echo '<h3>File upload failed!</b></h3><br><hr>';
		echo $result;
	}
?>