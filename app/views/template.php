<?=	doctype('html5'); ?>  
<html class=" js no-touch svg inlinesvg svgclippaths no-ie8compat">
<head> 
    <?= meta($this->config->item('meta'));?>
    <meta name="description" content="<?= $meta_description;?>">
    <meta name="keywords" content="<?= $meta_keywords;?>">
    <?= favicon('favicon.png'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    	$this->load->view('layout/styles');
    ?>

    <title> <?= $title; ?> </title>   
</head>  
<body>  
    <?= $this->load->view('layout/header'); ?>
    <?= $this->load->view('content/'.$content); ?>
    <?= $this->load->view('layout/footer'); ?>

	<?php
		$this->load->view('layout/scripts'); 
		if($script != ''):
			$this->load->view('content/'.$script);
		endif;
        $this->load->view('layout/analytic'); 
	?>
</body>  
</html>