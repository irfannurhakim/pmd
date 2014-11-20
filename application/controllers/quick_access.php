<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_access extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('isLoggedIn')){
      redirect('/authentication/', 'refresh');
    } 
  }

  public function index(){
    $userCondition = "IS NOT NULL";

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $userCondition = " = '" . $this->session->userdata('ID') . "'";  
    }

    //pilih semua projek yang diawasi oleh user, pilih item yang dikerjakan pada minggu ini, pilih perencanaan terakhir dan pilih item, volume untuk realisasi
    $data['projects'] = $this->builtbyprime->explicit("SELECT P.* FROM TBL_PROJECT P WHERE P.ID IN (SELECT ID_PROJECT FROM TBL_SUPERVISOR_PROJECT WHERE ID_USER ".$userCondition.")");
    $data['items'] = $this->builtbyprime->explicit("SELECT IT.*, PPD.*, PPD.ID_ITEM_TASK AS ID_ITEM_TASK, (SELECT COUNT(*) FROM demon.TBL_DISCUSSION WHERE ID_ITEM_TASK = IT.ID) COMMENTS FROM demon.TBL_ITEM_TASK IT, demon.TBL_PROJECT_PLANNING_DETAIL PPD WHERE IT.ID = PPD.ID_ITEM_TASK");

    $this->load->view('quick_access/index', $data);
  }



}
