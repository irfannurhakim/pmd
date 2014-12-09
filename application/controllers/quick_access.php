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
    $data['projects'] = $this->builtbyprime->explicit("SELECT P.NAME, P.ID, (SELECT COUNT(ID) FROM TBL_ITEM_TASK WHERE ID_PROJECT = P.ID GROUP BY ID_PROJECT) TOTAL_TASK FROM TBL_PROJECT P WHERE P.ID IN (SELECT ID_PROJECT FROM TBL_SUPERVISOR_PROJECT WHERE ID_USER ".$userCondition.") AND P.FINISH_DATE >= SYSDATE AND P.START_DATE <= SYSDATE");

    $this->load->view('quick_access/index', $data);
  }

  public function realization($id){

    $data['project'] = $this->builtbyprime->get('TBL_PROJECT', Array('id' => $id), true);

    $data['items'] = $this->builtbyprime->explicit("SELECT PPD.ID_PROJECT_PLANNING ID_PROJECT_PLANNING, IT.NAME,  IT.ID_PROJECT, IT.UNIT_PRICE, IT.VOLUME, IT.VENDOR_PROGRESS_VOLUME, IT.SUPERVISOR_PROGRESS_VOLUME, SUM(PPD.WEIGHT_PLANNING) WEIGHT_PLANNING, PPD.ID_ITEM_TASK AS ID_ITEM_TASK, C.COMMENTS 
      FROM TBL_ITEM_TASK IT 
      JOIN TBL_PROJECT_PLANNING_DETAIL PPD ON IT.ID = PPD.ID_ITEM_TASK 
      LEFT JOIN (SELECT COUNT(*) COMMENTS, ID_ITEM_TASK FROM TBL_DISCUSSION GROUP BY ID_ITEM_TASK) C ON C.ID_ITEM_TASK = IT.ID
      WHERE  IT.ID_PROJECT = ". $id ." AND PPD.ID_PROJECT_PLANNING IN (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING GROUP BY ID_PROJECT)
      GROUP BY PPD.ID_PROJECT_PLANNING, IT.NAME,  IT.ID_PROJECT, IT.UNIT_PRICE, IT.VOLUME, IT.VENDOR_PROGRESS_VOLUME, IT.SUPERVISOR_PROGRESS_VOLUME, PPD.ID_ITEM_TASK, C.COMMENTS
      ORDER BY ID_ITEM_TASK");

    $Carbon = new Carbon\Carbon;

    $a = $Carbon::createFromFormat('d-M-y', $data['project']['START_DATE']);
    $b = $Carbon::now();
    $c = $Carbon::createFromFormat('d-M-y', $data['project']['FINISH_DATE']);

    $data['weekNumber'] = ceil(($b->diffInDays($a) + 1)/7);
    $data['startWeek'] = $a->copy()->addWeeks($data['weekNumber'] - 1)->format('d/m/Y') ;
    $data['endWeek'] = $a->copy()->addWeeks($data['weekNumber'])->subDay()->format('d/m/Y'); 

    $this->load->view('quick_access/detail', $data);        
  }

  public function insight($id, $currentWeek){
    $beforeWeek = ($currentWeek - 1 > 0) ? $currentWeek - 1 : 0;
    $res = $this->builtbyprime->explicit("SELECT nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$id."' AND NO_WEEK = '".$beforeWeek."' GROUP BY ID_PROJECT),0) TOTAL_PERCENTAGE_BEFORE, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$id."' AND NO_WEEK = '".$currentWeek."' GROUP BY ID_PROJECT),0) TOTAL_PERCENTAGE_NOW, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$id."' GROUP BY ID_PROJECT),0) TOTAL_PERCENTAGE FROM DUAL");

    

    echo json_encode(Array('status'=> 'ok', 'data' => $res));
  }

}
