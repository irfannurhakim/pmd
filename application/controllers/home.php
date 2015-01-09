<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('isLoggedIn')){
			redirect('/authentication/', 'refresh');
		} 
	}

	public function index(){ 
    $userCondition = "IS NOT NULL";
    $adpro = '';
    $vendor = '';

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $userCondition = " = '" . $this->session->userdata('ID') . "'";  
    } else if($this->session->userdata('ID_USER_TYPE') == 6){
      $adpro = " AND P.CREATED_BY = '" .$this->session->userdata('USERNAME') . "'";  
    } else if($this->session->userdata('ID_USER_TYPE') == 4){
      $vendor = " AND P.ID_VENDOR = '" .$this->session->userdata('ID') . "'";  
    }

    $data['projects'] = $this->builtbyprime->explicit("SELECT P.ID, P.NAME, P.START_DATE, P.FINISH_DATE, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = P.ID GROUP BY ID_PROJECT),0) TOTAL_PERCENTAGE FROM TBL_PROJECT P WHERE P.IS_FINISHED != 1 AND P.START_DATE <= SYSDATE ".$adpro." ORDER BY P.ID DESC");
    
    if(count($data['projects']) < 1){
      $this->load->view('home/no_project');
      exit();
    }

    $Carbon = new Carbon\Carbon;

    $b = $Carbon::now();

    for ($i=0; $i < count($data['projects']); $i++) {   
      $a = $Carbon::createFromFormat('d-M-y', $data['projects'][$i]['START_DATE']);  
      $c = $Carbon::createFromFormat('d-M-y', $data['projects'][$i]['FINISH_DATE']); 
    
      $totalDays = $c->diffInDays($a);
      $usedDays = $b->diffInDays($a);
      $remainingDays = 100 - (($usedDays/$totalDays) * 100);
      $weekNumber = ceil(($b->diffInDays($a) + 1)/7);

      $data['projects'][$i]['REMAINING_DAYS'] = round($remainingDays, 4);

      $arrPlan = $this->builtbyprime->explicit("SELECT nvl((SELECT SUM(WEIGHT_PLANNING) FROM TBL_PROJECT_PLANNING_DETAIL WHERE WEEK_NUMBER <= ".$weekNumber." AND ID_PROJECT_PLANNING = (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$data['projects'][$i]['ID']."')),0) TOTAL_PLANNING FROM DUAL");

      $arrPlanGauge = $this->builtbyprime->explicit("SELECT nvl((SELECT SUM(WEIGHT_PLANNING) FROM TBL_PROJECT_PLANNING_DETAIL WHERE WEEK_NUMBER <= ".($weekNumber - 1)." AND ID_PROJECT_PLANNING = (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$data['projects'][$i]['ID']."')),0) TOTAL_PLANNING FROM DUAL");

      $data['projects'][$i]['TOTAL_PLANNING'] = $arrPlan[0]['TOTAL_PLANNING'];
      $data['projects'][$i]['TOTAL_PLANNING_GAUGE'] = $arrPlanGauge[0]['TOTAL_PLANNING'];

      $dataPlaning = $this->builtbyprime->explicit("SELECT PPD.WEEK_NUMBER, SUM(PPD.WEIGHT_PLANNING) TOTAL FROM TBL_PROJECT_PLANNING_DETAIL PPD WHERE PPD.ID_PROJECT_PLANNING IN (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$data['projects'][$i]['ID']."') GROUP BY PPD.WEEK_NUMBER ORDER BY PPD.WEEK_NUMBER");
      
      $dataRealization = $this->builtbyprime->explicit("SELECT NO_WEEK WEEK_NUMBER, SUM(PERCENTAGE) TOTAL FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$data['projects'][$i]['ID']."' GROUP BY NO_WEEK ORDER BY NO_WEEK");


      $arrPlan = Array([0,0]);
      $arrReal = Array([0,0]);
      $totPlan = 0;
      $totReal = 0;
      foreach ($dataPlaning as $week) { 
        $totPlan += $week['TOTAL'];
        array_push($arrPlan, [intval($week['WEEK_NUMBER']), $totPlan]);
      }

      foreach ($dataRealization as $week) {
        $totReal += $week['TOTAL'];
        array_push($arrReal, [intval($week['WEEK_NUMBER']), $totReal]);     
      }      

      $data['projects'][$i]['PLAN'] = json_encode($arrPlan);
      $data['projects'][$i]['REAL'] = json_encode($arrReal);
    }

		$this->load->view('home/index', $data);	
	}

  public function topstat($sorting = 0, $year = null){
    //sorting 0 by jumlah nilai proyek, sorting 1 by jumlah poyek 
    $sortby = 'jml_proyek';
    $tahun = ($year) ? $year : date('Y');

    if($sorting == 1){
      $sortby = 'jml_nilai_proyek';
    }

    $contractors = $this->builtbyprime->explicit("SELECT * FROM (SELECT v.affiliation name, v.profile_image_url, p.id_vendor, COUNT(p.id_vendor) jml_proyek, SUM(p.budget) jml_nilai_proyek FROM TBL_PROJECT p, TBL_USER v WHERE v.id = p.id_vendor and EXTRACT(YEAR FROM p.SPK_DATE) = '".$tahun."' GROUP BY p.id_vendor, v.affiliation, v.profile_image_url ORDER BY ".$sortby." DESC) WHERE ROWNUM <= 7");
    $supervisors = $this->builtbyprime->explicit("SELECT * FROM (SELECT U.NAME,  U.PROFILE_IMAGE_URL, U.AFFILIATION, S.ID_USER, COUNT(S.ID_USER) JML_PROYEK FROM TBL_SUPERVISOR_PROJECT S, TBL_USER U, TBL_PROJECT P WHERE U.ID = S.ID_USER AND P.ID = S.ID_PROJECT AND EXTRACT(YEAR FROM P.SPK_DATE) = '".$tahun."' GROUP BY U.NAME,  U.PROFILE_IMAGE_URL, S.ID_USER, U.AFFILIATION ORDER BY JML_PROYEK DESC) WHERE ROWNUM <= 7");

    $project = $this->builtbyprime->explicit("SELECT COUNT(ID) COUNT_TOTAL_PROJECT, SUM(BUDGET) SUM_TOTAL_BUDGET FROM TBL_PROJECT WHERE EXTRACT(YEAR FROM SPK_DATE) = '".$tahun."'");
    $others  = $this->builtbyprime->explicit("SELECT (SELECT COUNT(ID) FROM TBL_USER WHERE ID_USER_TYPE = 4) COUNT_CONTRACTOR, (SELECT COUNT(ID) FROM TBL_USER WHERE ID_USER_TYPE = 3) COUNT_SUPERVISOR FROM DUAL");


    echo json_encode(array('status' => 'ok', 'contractors' => $contractors, 'supervisors' => $supervisors, 'project' => $project, 'others' => $others));
  }

  public function data_curva(){
    $projects = $this->builtbyprime->explicit("SELECT P.ID FROM TBL_PROJECT P WHERE P.FINISH_DATE >= SYSDATE AND P.START_DATE <= SYSDATE ORDER BY P.ID");
    $projArray = Array();

    foreach ($projects as $project) {
      $start       = explode(' ',$project['START_DATE']); 
      $finish      = explode(' ',$project['FINISH_DATE']);
      $datediff    = strtotime($finish[0]) - strtotime($start[0]);
      $jumlahMinggu        = ceil(($datediff/(60*60*24))/7);
      
      $dataPlaning = $this->builtbyprime->explicit("SELECT PPD.WEEK_NUMBER, SUM(PPD.WEIGHT_PLANNING) TOTAL FROM TBL_PROJECT_PLANNING_DETAIL PPD WHERE PPD.ID_PROJECT_PLANNING IN (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$project['ID']."') AND PPD.WEEK_NUMBER <= ".$jumlahMinggu." GROUP BY PPD.WEEK_NUMBER ORDER BY PPD.WEEK_NUMBER");
      
      $dataRealization = $this->builtbyprime->explicit("SELECT NO_WEEK WEEK_NUMBER, SUM(PERCENTAGE) TOTAL FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$project['ID']."' AND WEEK_NUMBER <= ".$jumlahMinggu." GROUP BY NO_WEEK ORDER BY NO_WEEK");


      $arrPlan = Array([0,0]);
      $arrReal = Array([0,0]);
      $totPlan = 0;
      $totReal = 0;
      foreach ($dataPlaning as $week) { 
        $totPlan += $week['TOTAL'];
        array_push($arrPlan, [intval($week['WEEK_NUMBER']), $totPlan]);
      }

      foreach ($dataRealization as $week) {
        $totReal += $week['TOTAL'];
        array_push($arrReal, [intval($week['WEEK_NUMBER']), $totPlan]);     
      }      

      $projArray[$project['ID']]['PLAN'] = $arrPlan;
      $projArray[$project['ID']]['REAL'] = $arrReal;
    }

    echo json_encode(Array('status' => 'ok', 'data' => $projArray));
  }

  public function help(){
    $this->load->view('help/index');
  }
}
