
<div id="container" class="row">

    <section id="content" class="twelve columns">
        <div id="<?= $page_title; ?>" class="row page-title">
            <div class="nine columns">
                <h4>Music <?= $page_title; ?> <span class="country"></span></h4>
            </div>
            <div class="three columns options">
                <ul>
                    <li class="active">
                        <a class="label round">Songs</a>
                        <input class="option" type="hidden" value="T">
                    </li>
                    <li>
                        <a class="label round">Albums</a>
                        <input class="option" type="hidden" value="A">
                    </li>
                </ul>

            </div>
        </div>

        <div id="loading">
            <div class="row">
                <div class="one column centered">
                    <div class="load"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="response"></div>
        </div>
        <?= $this->load->view('layout/well'); ?> 
    </section>

</div>
    
