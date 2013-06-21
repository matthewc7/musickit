<!-- Nav -->
<nav>
	<div class="row">
		<div class="twelve columns">
			<?= $this->load->view('content/'.$page_title.'/nav');  ?>
    	</div>
	</div>
</nav>
<!-- End Nav -->

<? if($panel != ''): ?> 
    <!-- Header -->
    <header>
        <div class="row">
            <div class="three columns">
                <div class="brand">
                    <a href="<?= base_url(); ?>">
                        <?= getimg(array('','logo.png','Music Kit','135','36')); ?>
                    </a>
                </div>
            </div>
            <div class="nine columns">
                <?= $this->load->view('content/'.$panel);  ?>
            </div>
        </div>
    </header>
    <!-- End Header -->
<? endif; ?> 