<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('import');
		$this->load->library('send');
		$this->load->model('insert');
	}


	function index()
	{
		$this->import->update_chart();
		$this->import->update_top100();
	}


	/**
	 * Clean up the data
	 * @return void
	 */
	function clean()
	{
		$this->db->truncate('social_top');
		$this->db->truncate('social_chart');
		$this->db->truncate('archive100');

		$query = $this->db->get('top100');

		if ($query->num_rows() > 0)
		{
			$this->insert->archive100($query->result_array());
		}

	}



}