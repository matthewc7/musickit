<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}


    function index()
    {
		$data['style'] = 'home/style';
		$data['script'] = 'home/script';
		$data['title'] = 'MUSIC.KIT | Fathom Your Music in iTunes';
        $data['page_title'] = 'home';
		$data['content'] = 'home/index';
		$data['panel'] = '';
        $data['meta_description'] = 'Discover your music in iTunes Store. A quick and simple way to locate your music in all iTunes Stores. A glance at all the best selling music in all iTunes Stores.';
        $data['meta_keywords'] = "Best Selling Music, Music Chart, Locate music in iTunes, find music in iTunes, search for music in different countries, available in all iTunes Stores, iTunes Store in 63 countries. How to find music in all iTunes Store.";

        $data['country'] = $this->well->get_itunes_stores();

		$this->layout->render($data);
    }






}


