<div id="container" class="row">
    <section id="content" class="twelve columns">
        

        <div id="brand" class="row">
            <div class="four columns centered">
                <div class="logo"></div>
            </div>
        </div>

        <div id="box" class="row">
            <div class="four columns">
                <h4>Music Charts</h4>
                <p>
                    Want to know what is the best selling music from all iTunes Music Stores in different countries?
                </p>
                <p class="button-group">
                    <?= anchor('charts', 'Check Out!','class="btn"'); ?>
                </p>
            </div>
            <div class="four columns">
                <h4>Music Finder</h4>
                <p>
                    Quick search for your favourites music from iTunes Music Stores of any countries.                
                </p>
                <p class="button-group">
                    <?= anchor('finder', 'Quick Search!','class="btn"'); ?>
                </p>
            </div>
            <div class="four columns">
                <h4>Music Locator</h4>
                <p>
                    Locate your releases. Check and see if your release is available in all 63 iTunes Music Stores.                
                </p>
                <p class="button-group">
                    <?= anchor('locator', 'Locate Now!','class="btn"'); ?>
                </p>
            </div> 
        </div>

         <?= $this->load->view('layout/well'); ?> 

    </section>

</div>



  

