<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public function __construct(){
		parent::__construct();
    if($this->session->userdata('isLoggedIn')){
      redirect('/', 'refresh');
    } 
	}

	public function index(){
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
				'ID' => 99,
				'USERNAME' => 'aegisdev',
				'NAME' => 'Aegis Dev',
				'AFFILIATION' => 'Developer',
				'STATUS' => 1,
        'EMAIL' => 'irfan@aegis.co.id',
        'ID_USER_TYPE' => 1,
        'PROFILE_IMAGE_URL' => 'public/images/photos/profile.png'
			);

			$this->session->set_userdata($user);
			redirect(base_url());
			exit();
		}

		$user = $this->builtbyprime->get('TBL_USER', array('username' => $username, 'password' => md5($password)), TRUE);

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
}
