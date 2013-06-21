<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Model 
{    
    var $_date;

    function __construct() 
	{
        parent::__construct();
        $this->_date = date('Y-m-d G:i:s');
    }

    function itunes_chart($title, $type)
    {
    	foreach ($title as $data) 
    	{
            $this->db->where('type', $type);
            $this->db->where('rank', $data['rank']);
            $this->db->where('iso', $data['country']);
			$this->db->update('chart_itunes', array('datetime' => $this->_date, 'title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist'], 'image' => $data['image'], 'thumbnail' => $data['thumbnail'], 'link' => $data['link']));
    	}
    }


    function itunes_top100 ($title, $type)
    {
        foreach ($title as $data) 
        {
            $this->db->where('type', $type);
            $this->db->where('rank', $data['rank']);
            $this->db->where('iso', $data['country']);
            $this->db->update('top100', array('datetime' => $this->_date, 'title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist'], 'image' => $data['image'], 'thumbnail' => $data['thumbnail'], 'link' => $data['link']));
        }
    }


} 