<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Send
{
	var $CI;

	/**
	 * Email the notification of the import process.
	 * @param  array  $data [Response from the import]
	 */
	public function update_notification($data = array())
	{
		$CI =& get_instance();
		$CI->load->library('email');
		
		$count = 0;

		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		
		$CI->email->initialize($config);
		
		$subject = "Music Kit Chart Updates";

		$message = "<h3>Cron Updates:</h3>";
		$message .= "<p>Updates initiated at " . $data['time_start'] . " and ended at " . $data['time_end']." on " . $data['date']. ".</p>";
		
		if(multicount($data['responses']) == 0)
		{
			$message .= "No updates available.";
		}
		else
		{
			foreach ($data['responses'] as $key => $array) 
			{
				$message .= "<p>". $array['store'] ." ". $array['country'] ."(". $array['type'] .") updated. </p>";
				$count++;
			}

			$message .= "<p>Total of $count updates.</p>";

		}

		$CI->email->from($CI->config->item('sender'), $CI->config->item('sender_name'));
		$CI->email->to($CI->config->item('recipient'));
		$CI->email->subject($subject);

		$CI->email->message($message);
		$CI->email->send();   
		
	}

}