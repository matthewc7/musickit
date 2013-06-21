<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('array_random'))
{
	function array_random($array)
	{
		shuffle($array);
		$key = array_rand($array);

		return $array[$key];
	}
}

if (!function_exists('number_random'))
{
	function number_random($array)
	{
		return rand(0, COUNT($array));
	}
}

if (!function_exists('format_title'))
{
	function format_title($text)
	{
		$pos = strpos($text, '(');

		if($pos === FALSE)
		{
			return $text;
		}
		else
		{
			$string = substr($text, 0, $pos - 1); 
			$substring = substr($text, $pos, strlen($text)); 

			return "$string <small>$substring</small>";
		}
	}
}

if (!function_exists('capitalise'))
{
	function capitalise($text)
	{
		return ucwords(strtolower($text));
	}
}

if (!function_exists('lowercase'))
{
	function lowercase($text)
	{
		return strtolower($text);
	}
}

if (!function_exists('uppercase'))
{
	function uppercase($text)
	{
		return strtoupper($text);
	}
}