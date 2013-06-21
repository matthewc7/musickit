<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Itunes
{
	function encode($string)
	{
		$count = 0;
		$start = 20;
		$end = -5;

		if(strpos($string, '?'))
		{
			$end = -(strlen($string) - strpos($string, '?'));
		}

		$array = str_split($string);

		for ($i = 0; $i < COUNT($array) ; $i++) 
		{ 
			if($array[$i] == '/')
			{
				$count++;
			}

			if($count == 4)
			{
				$start = $i + 1;
				break;
			}
		}

		$link = substr($string, $start, $end); 
		$link = urlencode("http://itunes.apple.com/au/".$link."?partnerId=1002");
		$url = "http://t.dgm-au.com/c/40782/31316/1152?u=".$link;

		return $url;

	}


	function trim($string)
	{
		$end = -5;

		if(strpos($string, '?'))
		{
			$end = -(strlen($string) - strpos($string, '?'));
		}

		$array = str_split($string);
		return substr($string, 0, $end); 
		
	}

}



