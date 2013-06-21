
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