<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Select extends CI_Model 
{    
    var $_date;

    function __construct() 
	{
        parent::__construct();
        $this->_date = date('Y-m-d');
    }


    /**
     * Get the prefix text for social tweet.
     * @param  [string] $type     [release type]
     * @param  [string] $category [category]
     * @return [string]           [Prefix text] 
     */
    function social_format($type, $category)
    {
        $this->db->select('text');
        $this->db->where('category', $category);

        $query = $this->db->get('format');

        $row = $query->row_array(number_random($query->result_array()));
        return $row['text'];
    }



    /**
     * Select Best Selling from iTunes Chart. 
     * @param  [string] $type [Album or Track]
     * @return [array]       
     */
    function best_selling($type)
    {
    	$sql = "SELECT chart_itunes.thumbnail, chart_itunes.title, chart_itunes.name, chart_itunes.artist, COUNT(chart_itunes.iso) AS 'number', country.name AS 'country', chart_itunes.link
                FROM chart_itunes, country
                WHERE chart_itunes.iso = country.iso AND chart_itunes.rank = 1 
                AND chart_itunes.type = '$type'  
                GROUP BY chart_itunes.name
                ORDER BY COUNT(chart_itunes.iso) DESC, country.priority DESC
                LIMIT 0, 5";  


        $query = $this->db->query($sql);        

        if($query->num_rows() > 0)
        {  
            return $query->result();
        }

        return array();  
    }





    /**
     * Look for iTunes Chart that requires an update.
     * @param  [integer] $time [Minutes]
     * @return [array]      
     */
    function itunes_expired($time)
    {
        $sql = "SELECT DISTINCT chart_itunes.iso, chart_itunes.type, country.name AS country_name
                FROM chart_itunes, country
                WHERE chart_itunes.iso = country.iso AND TIMESTAMPDIFF(MINUTE, chart_itunes.datetime, CURRENT_TIMESTAMP) > $time";

        $query = $this->db->query($sql);
        return $query->result();

    }


    /**
     * Select iTunes Top Chart
     * @param  [string] $country [Country ISO]
     * @param  [string] $type    [Album or Track]
     * @return [array]          [Response]
     */
    function itunes_top($country, $type)
    {
        $sql = "SELECT chart_itunes.iso, chart_itunes.type, chart_itunes.image, country.name, chart_itunes.rank, chart_itunes.name, chart_itunes.thumbnail, chart_itunes.title, chart_itunes.artist, chart_itunes.link
                FROM chart_itunes, country
                WHERE chart_itunes.iso = country.iso 
                AND chart_itunes.iso = '$country' AND chart_itunes.type = '$type' 
                AND TIMESTAMPDIFF(MINUTE, chart_itunes.datetime, CURRENT_TIMESTAMP) < 60";

        $query = $this->db->query($sql);
        return $query->result_array();            
    }


}