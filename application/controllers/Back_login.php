<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Back_login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('livetable_model');

		if (!isset($_SESSION)) {
			session_start();
		}

		if ($this->session->userdata('loged') == 1) {
			redirect(base_url('master/tageto'));
			// echo $this->session->userdata('loged');
		}
	}

	public function index()
	{
		$data = array(
			'title_bar' => 'Login Form',
		);
		$this->load->view('back/login_form', $data);
	}

	public function process()
	{
		$this->load->helper('security');
		$user = $this->security->xss_clean($this->input->post('username', TRUE));
		$psw  = $this->security->xss_clean($this->input->post('password', TRUE));
		$u    = strtolower($user); // karena kolom username pakai lowercase
		$p    = md5($psw); // masih pakai md5 sesuai isi kolom password kamu

		// Load koneksi database kedua (db_user)
		$db_user = $this->load->database('database2', TRUE);
		$this->livetable_model->set_user_db($db_user); // ini penting

		// Ambil data dari tb_user
		$query = $this->livetable_model->_get('tb_user', [
			'username' => $u,
			'password' => $p,
			'is_active' => 1
		]);

		if ($query && $query->num_rows() > 0) {
			$data = $query->row_array();

			// Simpan ke session
			$sess_data = array(
				'loged'     => 1,
				'id_user'   => $data['user_id'],
				'full_name' => $data['full_name'],
				'username'  => $data['username'],
				'role'      => $data['role'],
				'is_active' => $data['is_active'],
			);

			$this->session->set_userdata($sess_data);
			redirect(base_url('master/tageto')); // ganti ke halaman dashboard kamu
		} else {
			$this->session->set_flashdata('result', '<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-info"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Incorrect username or password. Please try again!</b>
		</div>');
			redirect(base_url('login'));
		}
	}
}
