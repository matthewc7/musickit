<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_url'))
{
	function get_url($link)
	{
		return site_url($link);
	}
}

if(!function_exists('favicon'))
{
	function favicon($file)
	{
		$CI =& get_instance();
		$directory = $CI->config->item('images');
		$ext = end(explode('.', $file));
		
		$scriptag = "<link type='image/$ext' href='".base_url($directory.$file)."' rel='icon'>";

		return "\n".$scriptag;
	}
}

if (!function_exists('getcss'))
{
	function getcss($file, $type = 'screen', $ie = false)
	{
		$CI =& get_instance();
		$directory = $CI->config->item('css');
		$scriptag = "<link rel='stylesheet' media='$type' type='text/css' href='" .base_url($directory.$file)."'/>";

		if($ie)
		{
		 	$scriptag = "<!--[if lt IE 9]> $scriptag <![endif]-->";
		}	

		return "\n".$scriptag;
	}
}

if (!function_exists('getjs'))
{
	function getjs($file)
	{
		$CI =& get_instance();
		$script = '';
		
		switch($file)
		{
			case 'jquery':
				$script =  $CI->config->item('jquery');
				break;
			case 'jquery_ui':
				$script = $CI->config->item('jquery_ui');
				break;
			case 'google_api':
				$script = $CI->config->item('google_api');
				break;
			default: 
				$directory = $CI->config->item('scripts');
				$script = base_url($directory.$file);
				break;
		}
		
		$scriptag = "<script src='$script'> </script>";
		return "\n".$scriptag;
	}
}

if (!function_exists('getmedia'))
{
	function getmedia($file, $size='767px')
	{
		$CI =& get_instance();
		$directory = $CI->config->item('css');
		$scriptag = "<link rel='stylesheet' type='text/css' href='".base_url($directory.$file)."' media='handheld, only screen and (max-width:".$size.")' />";

		return "\n".$scriptag;
	}
}

if (!function_exists('getimg'))
{
	function getimg($img, $anchor = array())
	{
		$CI =& get_instance();
		$directory = $CI->config->item('images');
		
		$scriptag = "<img $img[0] src='".base_url($directory.$img[1])."' alt='$img[2]' width='$img[3]' height='$img[4]' />";
		
		if(COUNT($anchor) > 0)
		{
			$site_url = get_url($anchor[0]);
			$scriptag = "<a href='$site_url' $anchor[1] >$scriptag </a>";
		}

		return $scriptag;
	}
}


if (!function_exists('isoimg'))
{
	function isoimg($iso)
	{
		$CI =& get_instance();
		$directory = $CI->config->item('images');
		
		$scriptag = "<img class='iso' src='" . base_url($directory.'country/'.$iso.'.png') . "' alt='$iso' width='22' height='14' />";
		
		return $scriptag;
	}
}