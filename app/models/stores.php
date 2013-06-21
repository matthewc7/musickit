<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stores extends CI_Model 
{    
    var $_date;

    function __construct() 
	{
        parent::__construct();
        $this->_date = date('Y-m-d');
    }


    /**
     * Select all iTunes Music Stores
     * @return [array] [country]
     */
    function itunes_music()
    {
    	$sql = "SELECT country.name, store_itunes.iso
				FROM country, store_itunes
				WHERE country.iso = store_itunes.iso
				AND store_itunes.music = 1";

		$query = $this->db->query($sql);
		return $query->result();
    }

    function itunes_priority($more_than = 5)
    {
        $sql = "SELECT country.name, store_itunes.iso
                FROM country, store_itunes
                WHERE country.iso = store_itunes.iso
                AND store_itunes.music = 1 AND country.priority > $more_than";
                
        $query = $this->db->query($sql);
        return $query->result();   
    }


}    
