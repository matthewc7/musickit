<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Well
{
	var $CI;

	function regular()
	{
		$CI =& get_instance();
		$CI->load->model('select');

		$data['songs'] = $CI->select->best_selling('T');
		$data['albums'] = $CI->select->best_selling('A');

		return $data;
	}
	
    function get_itunes_stores($select = false)
    {
    	$CI =& get_instance();
    	$CI->load->model('stores');
    	
        $array = array();
        
        if(!$select)
        {
            $array[0] = "Please select a country.";
        }
    	
    	$data = $CI->stores->itunes_music();

    	foreach ($data as $country) 
    	{
    		$array[$country->iso] = $country->name;
    	}

    	return $array;
    }


}