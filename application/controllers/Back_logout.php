<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Back_logout extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('LiveTable_model'));
	}
	// Logout
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(''));
	}
}
