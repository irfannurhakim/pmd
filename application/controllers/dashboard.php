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
    } else if($this->session->userdata('ID_USER_TYPE') == 3 || $this->session->userdata('ID_USER_TYPE') == 4){
      $data['initRoute'] = '/projects';
    }


		$this->load->view('partial/header');
		$this->load->view('partial/sidebar');
		$this->load->view('partial/main', $data);
		$this->load->view('partial/footer');		
	}

  public function _getInitRoute(){

  }

  public function GenerateNavArray($arr, $parent = 0)
  {
    $pages = Array();
    foreach($arr as $page)
    {
        if($page['ID_PARENT'] == $parent)
        {
            $page['sub'] = isset($page['sub']) ? $page['sub'] : $this->GenerateNavArray($arr, $page['ID']);
            $pages[] = $page;
        }
    }
    return $pages;
  }

  public function test(){
    $arr = $this->builtbyprime->explicit("SELECT TBL_ITEM_TASK.*, LEVEL, SYS_CONNECT_BY_PATH(ID, '.') AS PA FROM TBL_ITEM_TASK WHERE ID_PROJECT = 1 START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME");

    $n = $this->GenerateNavArray($arr);
    print_r($n);
  }


}
