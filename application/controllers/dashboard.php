<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('isLoggedIn')){
			redirect('/authentication/', 'refresh');
		} 
	}

	public function index()
	{
		$this->load->view('partial/header');
		$this->load->view('partial/sidebar');
		$this->load->view('partial/main');
		$this->load->view('partial/footer');		
	}
}
