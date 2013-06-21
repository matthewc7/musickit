<?php
	echo getcss('styles.css');
	echo getcss('ie.css','screen', TRUE);

	if($style != ''):
		$this->load->view('content/'.$style);
	endif;

	echo getcss('responsive.css');
?>

