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
    if($this->session->userdata('ID_USER_TYPE') == 1){
      $data['router'] = array('/home'=>'home', 'project/'=>'projects','/project/view/:id'=>'projectDetail');
      //$data['router'] = array('test'=>'test');
      $data['initRoute'] = '/home';
    } else if($this->session->userdata('ID_USER_TYPE') == 2){
      $data['initRoute'] = '/home';
    } else if($this->session->userdata('ID_USER_TYPE') == 3 || $this->session->userdata('ID_USER_TYPE') == 4 || $this->session->userdata('ID_USER_TYPE') == 6){
      $data['initRoute'] = '/projects';
    }


		$this->load->view('partial/header');
		$this->load->view('partial/sidebar');
		$this->load->view('partial/main', $data);
		$this->load->view('partial/footer');		
	}
}
