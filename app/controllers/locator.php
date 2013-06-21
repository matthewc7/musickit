<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locator extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('import');
		$this->load->model('stores');
	}

    function index()
    {
		$data['style'] = 'locator/style';
		$data['script'] = 'locator/script';
		$data['title'] = 'MUSIC.KIT | Is Your Music Available in All iTunes Stores?';
        $data['page_title'] = 'locator';
		$data['content'] = 'locator/index';
        $data['panel'] = 'locator/panel';
        $data['meta_description'] = 'Find your releases in iTunes Stores in various countries. A quick and simple way to locate your releases in all iTunes Stores.';
        $data['meta_keywords'] = "Locate album in iTunes, find album in iTunes, search for album in different countries, available in all iTunes Stores, iTunes Store in 63 countries. How to find album in all iTunes Stores.";

		$this->layout->render($data);
    }


    /**
     * Search for album in itunes. 
     * @return void.
     */
    function search()
    {
    	$array = array();
    	$count = 1;
        $available = 0;

        $album = "";
    	$response = "<div class='row'>";

    	$upc = $this->input->get('upc');
    	$location = $this->stores->itunes_music();		

    	foreach ($location as $country) 
    	{
			$url = "http://itunes.apple.com/lookup?upc=" . $upc ."&country=" . $country->iso;
			$data = $this->import->data($url);

			$array[$country->iso] = array($country->name, $data['resultCount']);

            if($data['resultCount'] > 0)
            {
                foreach($data['results'] as $info)
                {
                    $album = "<div id='info' class='row panel'><div class='eight columns centered'>";
                    $album .= "<div class='three columns'>";
                    $album .= "<img class='thumbnail' src='$info[artworkUrl100]' title='$info[collectionName]'>";
                    $album .= "</div><div class='nine columns'>";
                    $album .= "<p class='upc'>$upc</p>";                            
                    $album .= "<p class='title'>$info[collectionName]</p><p class='artist'>$info[artistName]</p><p id='results'></p>";
                    $album .= "</div></div></div>";

                    array_push($array[$country->iso], $info['collectionViewUrl']);
                }              
            }
    	}

    	
    	foreach ($array as $iso => $value) 
    	{
            if($count == 1)
            {
                $response .="<ul class='lists four columns'>";
            }

            if($value[1] > 0)
            {
                $url = $this->itunes->trim($value['2']);

                if($iso == 'AU')
                {
                    $url = $this->itunes->encode($value['2']);
                }

                $response .= "<li class='available'>" . isoimg($iso) . " <a href='$url' target='itunes_store'>iTunes $value[0]</a> </li>";  
                $available++;
            }
            else
            {
                $response .= "<li class='unavailable'>" . isoimg($iso) . " iTunes $value[0] </li>";    
            }

            if($count == 21)
            {
                 $response .="</ul>";
                 $count = 0;
            }

            $count++;
    	}


        $data['content'] = $album."</div>".$response."</div>";
        $data['available'] = $available;

        if($available == 63)
        {
            $data['total'] = "Available in all 63 iTunes stores.";
        }
        else
        {
            $data['total'] = "Available in $available iTunes stores (Out of 63 stores).";
        }

    	echo json_encode($data); 
    }

}


