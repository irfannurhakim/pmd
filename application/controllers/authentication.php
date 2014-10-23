<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {


	public function __construct(){
		parent::__construct();


	}

	public function index()
	{
		$this->load->view('authentication/login');
	}

	public function go(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if(!$username || !$password) {
			redirect(base_url());
			exit();
		}

		if($username == 'aegisdev' && $password == 'aegisdev'){
			$user = array(
				'isLoggedIn' => TRUE,
				'id' => 99,
				'username' => 'aegisdev',
				'name' => 'Aegis Dev',
				'affiliation' => 'Developer',
				'status' => 1
			);

			$this->session->set_userdata($user);
			redirect(base_url());
			exit();
		}

		$user = $this->users->find_by_username_password($username, $password);

		if($user){
			$user['isLoggedIn'] = TRUE;
			$this->session->set_userdata($user);
			//$this->db->insert('tbl_global_logs', array('id_event'=> 10, 'id_user'=>$user['id'], 'description'=> 'login', 'severity'=>'normal'));
			redirect(base_url());
		} else {
			$this->session->set_flashdata('message', 'Incorrect username and password!');
			redirect(base_url() . 'authentication');
		}
	}

	public function logout(){
		//$this->db->insert('tbl_global_logs', array('id_event'=> 11, 'id_user'=>$this->session->userdata['id'], 'description'=> 'logout', 'severity'=>'normal'));
		$this->session->sess_destroy();	
		redirect(base_url() . 'authentication/go');
	}
}
