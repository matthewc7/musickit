<div id="setting" class="hide">
    <div class="row content">
        <div class="six columns centered">
            <div class="row">
                <p class="two columns">COUNTRY: </p>
                <?= form_dropdown('country', $country, 'AU', 'id="c" class="dropdown four columns"'); ?>
            </div>
            <div class="row">
                <p class="two columns">TYPE: </p>
                <?= form_dropdown('entity', $this->config->item('entity'), 'song', 'id="e" class="dropdown four columns"'); ?>
            </div> 
        </div>
    </div>
</div>


<div id="container" class="row">
    <section id="content" class="twelve columns">
        <div id="<?= $page_title; ?>" class="row page-title">
            <div class="six columns">
                <h4>Music <?= $page_title; ?> </h4>
            </div>
        </div>

        <div id="loading">
            <div class="row">
                <div class="one column centered">
                    <div class="load"></div>
                </div>
            </div>
        </div>

        <div id="response"></div>
        <?= $this->load->view('layout/well'); ?> 
    </section>

</div>