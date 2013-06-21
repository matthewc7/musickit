<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finder extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('import');
		$this->load->model('stores');
	}

    function index()
    {
		$data['style'] = 'finder/style';
		$data['script'] = 'finder/script';
		$data['title'] = 'MUSIC.KIT | Find your favourite music in iTunes Stores';
        $data['page_title'] = 'finder';
		$data['content'] = 'finder/index';
        $data['panel'] = 'finder/panel';
        $data['meta_description'] = 'Find your releases in iTunes Stores in various countries. A quick and simple way to locate your releases in all iTunes Stores.';
        $data['meta_keywords'] = "Locate album in iTunes, find album in iTunes, search for album in different countries, available in all iTunes Stores, iTunes Store in 63 countries. How to find album in all iTunes Stores.";

        $data['country'] = $this->well->get_itunes_stores(true);

		$this->layout->render($data);
    }


    /**
     * Search for music in itunes. 
     * @return json data. 
     */
    function search()
    {
    	$term = $this->input->get('term');
        $country = lowercase($this->input->get('country'));
        $entity = $this->input->get('entity');

		$url = "http://itunes.apple.com/search?term=" . $term ."&country=" . $country ."&entity=" . $entity ."&limit=48";
		$data = $this->import->data($url);

        $array['content'] = '';
        $array['results'] = $data['resultCount'];
        $count = 1;
     
        if($data['resultCount'] > 0)
        {
            foreach($data['results'] as $info)
            {
                if($count == 1)
                {
                    $array['content'] .= "<div class='row'>";
                }

                $array['content'] .= "<div class='three columns list'>"; 
                $array['content'] .= "<img class='thumbnail' src='$info[artworkUrl100]' title='$info[collectionName]'>";      
                $array['content'] .= "<p class='title'>$info[collectionName]</p><p class='artist'>$info[artistName]</p>";
                $array['content'] .= "</div>";

                if($count == 4)
                {
                    $array['content'] .= "</div>";
                    $count = 0;
                }

                $count++;
            }              
        } 

    	echo json_encode($array); 
    }

}


