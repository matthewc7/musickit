<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Insert extends CI_Model 
{    
    var $_date;

    function __construct() 
	{
        parent::__construct();
        $this->_date = date('Y-m-d G:i:s');
    }

    /**
     * Insert data into iTunes Chart 
     * @param  array $title data
     * @param  string $type  release type
     * @param  string $table table name
     * @return void
     */
    function itunes_chart($title, $type, $table = "chart_itunes")
    {
    	foreach ($title as $data) 
    	{
			$this->db->insert($table, array('datetime' => $this->_date, 'type' => $type, 'rank' => $data['rank'], 'iso' => $data['country'], 'title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist'], 'image' => $data['image'], 'thumbnail' => $data['thumbnail'], 'link' => $data['link']));
    	}
    }

    /**
     * Update Social Top table after creating the social text. 
     * @param  array $data data to insert
     * @return void
     */
    function social_top($data)
    {
        $this->db->insert('social_top', array('type' => $data['type'], 'rank' => $data['rank'], 'iso' => $data['iso'], 'title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist']));
    }



    /**
     * Update Social Chart table after creating the social text. 
     * @param  array $data data to insert
     * @return void
     */
    function social_chart($data)
    {
        $this->db->insert('social_chart', array('title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist']));
    }


    /**
     * Insert into archive top 100
     * @param  array $top data to insert
     * @return void
     */
    function archive100($array)
    {
        foreach ($array as $data) 
        {
            $this->db->insert('archive100', array('datetime' => $data['datetime'], 'type' => $data['type'], 'rank' => $data['rank'], 'iso' => $data['iso'], 'title' => $data['title'], 'name' => $data['name'], 'artist' => $data['artist'], 'image' => $data['image'], 'thumbnail' => $data['thumbnail'], 'link' => $data['link']));
        }
    }


    function social_history($text)
    {
        $this->db->insert('social_history', array('text' => $text));
    }



}   