<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Back_computer extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
	}

	public function data_user()
	{
        $data_computer =  $this->M_crud->tampil_data('tb_computer')->result_array();
		$data = array(
			'title_bar' 	  => 'Data Computer',
			'title' 		  => 'Computer', //H4
			'br_title' 		  => $this->uri->segment('1'),//Breadcumb
			'br_title_active' => $this->uri->segment('2'),//Breadcumb
            'data_computer'        => $data_computer,
		);

		$this->load->view('back/group_register/computer',$data);
	}
}