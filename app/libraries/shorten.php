<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class CI_Shorten{

	function url($url, $type = "bit")
	{
		$new_url = $this->shorten_url($url, $type);
		return substr($new_url, 7, strlen($new_url)); 
	}

	function shorten_url($url, $type)
	{
		switch($type)
		{
			case "bit":
				return $this->get_bit_url($url);
				break;
			case "tiny":
				return $this->get_tiny_url($url);
				break;
		}
	}


	function get_tiny_url($url)  
	{  
		return $this->get_curl('http://tinyurl.com/api-create.php?url='.$url);
	}

	function get_bit_url($longUrl, $domain = '', $x_login = '', $x_apiKey = '') 
	{
		$result = array();

		$url = "http://api.bit.ly/v3/" . "shorten?login=" . "kentyc" . "&apiKey=" . "R_d716593df7f19009585d292580cd93a3" . "&format=json&longUrl=" . urlencode($longUrl);
		
		if ($domain != '') 
		{
			$url .= "&domain=" . $domain;
		}
		
		if ($x_login != '' && $x_apiKey != '') 
		{
			$url .= "&x_login=" . $x_login . "&x_apiKey=" . $x_apiKey;
		}

		$output = json_decode($this->get_curl($url));
		
		if (isset($output->{'data'}->{'hash'})) 
		{
			$result['url'] = $output->{'data'}->{'url'};
			$result['hash'] = $output->{'data'}->{'hash'};
			$result['global_hash'] = $output->{'data'}->{'global_hash'};
			$result['long_url'] = $output->{'data'}->{'long_url'};
			$result['new_hash'] = $output->{'data'}->{'new_hash'};
		}
		return $result['url'];
	}

	function get_curl($uri) 
	{
		$output = "";

		try {
			$ch = curl_init($uri);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 4);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$output = curl_exec($ch);
			curl_close($ch);
		} catch (Exception $e) {}

		return $output;
	}






}