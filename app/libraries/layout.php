<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Layout
{
	var $CI;

	function render($data = array(), $return = FALSE)
	{
		$CI =& get_instance();
		$CI->config->load('layout');
		$template = $CI->config->item('template');
		$CI->load->view($template, $data, $return);
	}
	
}	
