<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $data['user'] = $this->builtbyprime->get('TBL_USER');

		$this->load->view('project/index', $data);
	}

	public function add(){

	}

	public function view(){
    $this->load->view('project/detail');
	}

	public function remove(){

	}

	public function edit(){

	}
}
