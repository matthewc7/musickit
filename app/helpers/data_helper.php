<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

if (!function_exists('multicount'))
{
	function multicount($array = array())
	{
		return sum_array(array_map("count", $array));
	}
}

if (!function_exists('sum_array'))
{
	function sum_array($array = array())
	{
		return array_sum($array);
	}
}

