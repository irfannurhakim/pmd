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
    $data['items'] = $this->builtbyprime->explicit("SELECT PPD.ID_PROJECT_PLANNING ID_PROJECT_PLANNING, IT.NAME,  IT.ID_PROJECT, IT.UNIT_PRICE, IT.VOLUME, IT.VENDOR_PROGRESS_VOLUME, IT.SUPERVISOR_PROGRESS_VOLUME, SUM(PPD.WEIGHT_PLANNING) WEIGHT_PLANNING, PPD.ID_ITEM_TASK AS ID_ITEM_TASK, C.COMMENTS 
FROM demon.TBL_ITEM_TASK IT 
JOIN demon.TBL_PROJECT_PLANNING_DETAIL PPD ON IT.ID = PPD.ID_ITEM_TASK 
LEFT JOIN (SELECT COUNT(*) COMMENTS, ID_ITEM_TASK FROM demon.TBL_DISCUSSION GROUP BY ID_ITEM_TASK) C ON C.ID_ITEM_TASK = IT.ID
WHERE  PPD.ID_PROJECT_PLANNING IN (SELECT MAX(ID) FROM DEMON.TBL_PROJECT_PLANNING GROUP BY ID_PROJECT)
GROUP BY PPD.ID_PROJECT_PLANNING, IT.NAME,  IT.ID_PROJECT, IT.UNIT_PRICE, IT.VOLUME, IT.VENDOR_PROGRESS_VOLUME, IT.SUPERVISOR_PROGRESS_VOLUME, PPD.ID_ITEM_TASK, C.COMMENTS
ORDER BY ID_ITEM_TASK");

    $this->load->view('quick_access/index', $data);
  }



}
