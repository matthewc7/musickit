<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->library('import');
		$this->load->model('stores');
        $this->load->model('select');
        $this->load->model('update');
	}

    function index()
    {
		$data['style'] = 'charts/style';
		$data['script'] = 'charts/script';
		$data['title'] = 'MUSIC.KIT | Best Selling Music in iTunes Stores';
        $data['page_title'] = 'charts';
		$data['content'] = 'charts/index';
		$data['panel'] = 'charts/panel';
        $data['meta_description'] = 'Check out the best selling music in each iTunes Store.';
        $data['meta_keywords'] = "Best Selling Music, iTunes Best Selling, iTunes Top Music, iTunes Chart, iTunes Top Albums, iTunes Top Song, iTunes Music";

        $data['country'] = $this->well->get_itunes_stores();

		$this->layout->render($data);
    }


    /**
     * Load music data. 
     * @return void.
     */
    function load()
    {
        $country = $this->input->get('country');
        $type = $this->input->get('type');;

        $this->data($country, $type);
    }



    /**
     * grab data. 
     */
    function data($country, $type)
    {
        $count = 0;
        $data = $this->select->itunes_top($country, $type);

        if(COUNT($data) == 0)
        {
            $itunestype = "topsongs";

            if($type == 'A')
            {
                $itunestype = "topalbums";
            }

            $updates = $this->import->chart($country, $itunestype);

            if(count($updates) > 0)
            {
                $this->update->itunes_chart($updates, $type);
                $this->data($country, $type);
            }
        }
        else
        {
            $response = "<ul class='twelve columns chart'>";

            foreach ($data as $chart) 
            {
                $count++;

                if($count == 6)
                {
                    $response .= "</ul><ul class='twelve columns chart'>";
                }

                $url = $this->itunes->trim($chart['link']);

                if($chart['iso'] == 'AU')
                {
                    $url = $this->itunes->encode($chart['link']);
                }
                
                $response .= "<li class='span$count'>";
                $response .= "<a class='image' href='$url'><span class='label'>$count</span><img class='thumbnail' src='$chart[image]' alt='$chart[title]'></a>";
                $response .= "<p class='title'>".format_title($chart['name'])."</p>";
                $response .= "<p class='artist'>".format_title($chart['artist'])."</p>";
                $response .= "</li>";
            }

            $response .= "</ul>";

            echo $response;

        }

    }




}