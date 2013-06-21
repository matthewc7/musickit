<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Import
{
	var $CI;
	

	/**
	 * Import the iTunes data through Lookup or Search.
	 * @param  [string] $link [URL link]
	 * @return [array]       [Response from iTunes]
	 */
	function data($link)
	{
		$channel = curl_init($link);
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($channel);
		curl_close($channel);
		return json_decode($data, TRUE);
	}



	/**
	 * Import the iTunes Chart from iTunes RSS Feed.
	 * @param  [string]  $iso   [ISO of country]
	 * @param  [string]  $type  [Album or Track]
	 * @param  integer $limit [Limit of SQL]
	 * @return [array]         [Response from iTunes]
	 */
	function chart($iso, $type, $limit = 10)
	{
		$import = array();
		$rank = 1;
		$url = "http://itunes.apple.com/". lowercase($iso) ."/rss/". $type. "/limit=".$limit."/json";

		$data = $this->data($url);

		if(count($data) != 0)
		{
			foreach($data['feed']['entry'] as $entry)
			{
				$array = array();

				$array['country'] = $iso;
				$array['rank'] = $rank;
				$array['title'] = $entry['title']['label'];
				$array['name'] = $entry['im:name']['label'];
				$array['artist'] = $entry['im:artist']['label'];
				$array['thumbnail'] = $entry['im:image'][1]['label'];
				$array['image'] = $entry['im:image'][2]['label'];

				switch($type)
				{
					case 'topsongs':
						$array['link'] = $entry['im:collection']['link']['attributes']['href'];
						break;
					case 'topalbums':
						$array['link'] = $entry['link']['attributes']['href'];
						break;
				}

				array_push($import, $array);
				$rank++;
			}
		}

		return $import;
	}



	/**
	 * Update the iTunes Chart.
	 * @return [array] [Response from the update]
	 */
	function update_chart()
	{
		$CI =& get_instance();
		$CI->load->model('select');
		$CI->load->model('update');	

		$multiArray = array();
		$expired = $CI->select->itunes_expired(50);	

		if(COUNT($expired))
		{
			$array['store'] = 'iTunes';
			
			foreach ($expired as $data) 
			{
				$type = $this->get_itunes_type($data->type);
				$updates = $this->chart($data->iso, $type);

				if(count($updates) > 0)
				{
					$CI->update->itunes_chart($updates, $data->type);
					$array['type'] = $data->type;
					$array['country'] = $data->country_name;
				}

				array_push($multiArray, $array);
			}	
		}

		return $multiArray;
	}




	/**
	 * Update the iTunes Top 100.
	 * @return [array] [Response from the update]
	 */
	function update_top100()
	{
		$CI =& get_instance();
		$CI->load->model('update');	
		$CI->load->model('stores');	

		$location = $CI->stores->itunes_priority(6);
		$types = $CI->config->item('itunes_type');

		foreach ($location as $country) 
		{
			foreach ($types as $mytype => $itunetype) 
			{
				$data = $CI->import->chart($country->iso, $itunetype, 100);
				if(count($data) > 0)
				{
					$CI->update->itunes_top100($data, $mytype);
				}
			}	
		}


	}


	/**
	 * Get the iTunes type using the our defined type in config.
	 * @param  [string] $type [Album or Track]
	 * @return [string]       [iTunes defined type]
	 */
	function get_itunes_type($type)
	{
		$CI =& get_instance();
		$types = $CI->config->item('itunes_type');

		foreach ($types as $mytype => $itunetype) 
		{
			if($type == $mytype)
			{
				return $itunetype;
			}
		}
	}





	/**
	 * Import new data from iTunes.
	 * @return [array] [imported variables]
	 */
	function new_itunes($top = 10, $priority_country = false, $table = "chart_itunes")
	{
		$CI =& get_instance();
		$CI->load->model('stores');
		$CI->load->model('insert');

		$imports['albums'] = 0;
		$imports['tracks'] = 0;

		$location = $CI->stores->itunes_music();
		
		if($priority)
		{
			$location = $CI->stores->itunes_priority(6);
		}	

		$types = $CI->config->item('itunes_type');

		foreach ($location as $country) 
		{
			foreach ($types as $mytype => $itunetype) 
			{
				$data = $this->chart($country->iso, $itunetype, $top);
				if(count($data) > 0)
				{
					$CI->insert->itunes_chart($data, $mytype, $table);
					switch($mytype)
					{
						case 'A':
							$imports['albums']++;
							break;
						case 'T':
							$imports['tracks']++;
							break;
					}
				}
			}	
		}

		return $imports;
	}


}