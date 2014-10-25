<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	public function index()
	{
		$this->load->view('project/index');
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
