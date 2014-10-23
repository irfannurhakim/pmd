<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('isLoggedIn')){
			redirect('/authentication/', 'refresh');
		} 
	}

	public function index()
	{
		$this->load->view('home/index');	
	}

	public function add(){

	}

	public function view(){

	}

	public function remove(){

	}

	public function edit(){

	}
}
