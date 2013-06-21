<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social extends CI_Controller {

	var $_filepath;

	function __construct()
	{
		parent::__construct();
		$this->_filepath = FCPATH.'temp/image.jpg';

		$this->load->library('twitter');
		$this->load->library('shorten');
		$this->load->library('import');
		$this->load->model('insert');
		$this->load->model('select');
	}



	/**
	 * Create the sum of chart. 
	 * @return void. 
	 */
	function music_sum()
	{
		$sql = "SELECT chart_itunes.title, chart_itunes.name, chart_itunes.artist, COUNT(chart_itunes.iso) AS 'number', GROUP_CONCAT(country.name) AS 'country', chart_itunes.link, chart_itunes.image
				FROM chart_itunes, country
				WHERE chart_itunes.iso = country.iso AND chart_itunes.rank = 1 
				AND chart_itunes.title NOT IN (SELECT social_chart.title FROM social_chart) 
				GROUP BY chart_itunes.name
				HAVING number > 1
				ORDER BY COUNT(chart_itunes.iso) DESC, country.priority DESC";

		$query = $this->db->query($sql);

        if($query->num_rows() > 0)
        {  
        	$row = $query->row_array(number_random($query->result_array()));

        	$url = $this->itunes->encode($row['link']);
        	$country = "";

        	if($row['number'] < 6)
        	{
        		$country = "(".$row['country'].")";
        	}

   			$text = 'Best Selling #iTunes in '.$row['number']." countries $country: ".$row['title'] . ' > ' . $this->shorten->url($url, 'bit');
   			
        	$this->insert->social_chart($row);
        	$response = $this->tweet($text, $row['image']);

			if($response)
			{
				$this->insert->social_history($text);
			}
        }


	}


	/**
	 * Process Charts
	 * @return void. 
	 */
	function music_chart()
	{
		$sql = "SELECT chart_itunes.type, chart_itunes.rank, chart_itunes.iso, country.name AS country, chart_itunes.title, chart_itunes.name, chart_itunes.artist, chart_itunes.link, chart_itunes.image
				FROM chart_itunes, country
				WHERE chart_itunes.iso = country.iso 
				AND ROW(chart_itunes.title, chart_itunes.iso, chart_itunes.rank) NOT IN (SELECT social_top.title, social_top.iso, social_top.rank FROM social_top)";

		$query = $this->db->query($sql);    
		$this->process($query, 'chart');

	}




	/**
	 * Create the top music chart. 
	 * @return void. 
	 */
	function music_top()
	{
		$array = array('AU','AU','AU','AU','NZ','NZ','NZ','US','US','GB');
		$country = array_random($array);

		$sql = "SELECT top100.type, top100.rank, top100.iso, country.name AS country, top100.title, top100.name, top100.artist, top100.link, top100.image
				FROM top100, country
				WHERE top100.iso = country.iso AND top100.iso = '$country'
				AND ROW(top100.title, top100.iso) NOT IN (SELECT social_top.title, social_top.iso FROM social_top)";

		$query = $this->db->query($sql);    
		$this->process($query, 'top');

	}


	/**
	 * Get new music. 
	 * @return void.
	 */
	function music_new()
	{
		$sql = "SELECT top100.type, top100.rank, top100.iso, country.name AS country, top100.title, top100.name, top100.artist, top100.link, top100.image
				FROM top100, country
				WHERE top100.iso = country.iso 
				AND ROW(top100.title, top100.iso) NOT IN (SELECT archive100.title, archive100.iso FROM archive100) 
				AND ROW(top100.title, top100.iso) NOT IN (SELECT social_top.title, social_top.iso FROM social_top)";

        $query = $this->db->query($sql);        
        $this->process($query, 'new');
	}



	/**
	 * Processor
	 * @return void
	 */
	function process($query, $category)
	{
		$response = FALSE;

        if($query->num_rows() > 0)
        {  
        	$row = $query->row_array(number_random($query->result_array()));
        	$text = $this->format($category, $row);

        	$this->insert->social_top($row);

        	switch ($category) 
        	{
        		case 'new':
        			$response = $this->tweet($text, $row['image']);
        			break;  		
        		default:
        			$response = $this->tweet($text);
        			break;
        	}

			if($response)
			{
				$this->insert->social_history($text);
			}
        }
	}



	/**
	 * Make a tweet
	 * @param  string $message message to tweet.
	 * @param  string $media   image for tweet.
	 * @return response from twitter.
	 */
	function tweet($message, $media = NULL)
	{
		if($media != NULL)
		{
			if($this->grab_image($media))
			{
				return $this->twitter->tweetImage($message." < ", $this->_filepath);
				unlink($this->_filepath);
			}
			else
			{
				if(is_file($this->_filepath))
				{
					unlink($this->_filepath);
				}
				return $this->twitter->tweetText($message);
			}			
		}
		else
		{
			return $this->twitter->tweetText($message);
		}


	}

	/**
	 * Grab image from external link
	 * @param  string $link link of the image.
	 * @return boolean
	 */
	function grab_image($link)
	{
		$content = file_get_contents($link);
		file_put_contents($this->_filepath, $content);

		if(is_file($this->_filepath))
		{
			return TRUE;
		}

		return FALSE;
	}


/**
 * format the data
 * @return new format.
 */
	function format($category, $data = array())
	{
    	$shortener = 'tiny';
    	$music_type = 'Song';
    	$url = $this->itunes->trim($data['link']); 

    	$format = $this->select->social_format($data['type'], $category); 
    	$country = str_replace(" ", "", $data['country']);

    	if($data['iso'] == 'AU' || $data['iso'] == 'NZ')
    	{
    		$url = $this->itunes->encode($data['link']);
    	}

    	switch ($category) 
    	{
    		case 'one':
    		case 'top':
    			$shortener = 'bit';
    			break;
    	}

    	if($data['type'] = "A")
    	{
    		$music_type = 'Album';
    	}

    	return sprintf($format, $music_type, $data['rank'], $country, $data['title']) . ' > ' . $this->shorten->url($url, $shortener);
	
	}


	/**
	 * promotional text.
	 */

	function promote()
	{
		$s1 = "Want to find out what's the greatest hit song in #iTunes? Check out the iTunes Charts from 63 countries > musickit.net/charts";
		$s2 = "What is the best selling music in iTunes? Check out the #iTunes Charts from 63 countries > musickit.net/charts";
		$s3 = "Wonder what's the best music in 63 different countries? #iTunes Check out the iTunes Charts > musickit.net/charts";
		$s4 = "#iTunes #TopSong in 63 different countries. Check out the iTunes Charts > musickit.net/charts";
		
		$s5 = "Have you wonder is your album available in all 63 #iTunes Stores? Locate your music in iTunes now > musickit.net/locator";
		$s6 = "How many countries are you selling your releases to? Locate your music in #iTunes now > musickit.net/locator";
		$s7 = "Are you selling your releases at the right country in #iTunes? Locate your music in iTunes now > musickit.net/locator";
		$s8 = "Check out your releases in all 63 #iTunes Stores! Locate your music in iTunes now > musickit.net/locator";

		$array = array($s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8);
		$text = array_random($array);
		$response = $this->twitter->tweetText($text);

		if($response)
		{
			$this->insert->social_history($text);
		}
		
	}




}