<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delete extends CI_Model 
{    
    var $_date;

    function __construct() 
	{
        parent::__construct();
        $this->_date = date('Y-m-d');
    }

    function social($id)
    {
    	$this->db->delete('social', array('id' => $id)); 
    }
}