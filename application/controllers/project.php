<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $now = date('Y/m/d');
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

    $sql = "SELECT P.ID, P.NAME, P.IS_FINISHED, U.AFFILIATION VENDOR_NAME, (P.START_DATE -  TO_DATE('".$now."', 'yyyy/mm/dd')) FROM_START, (P.FINISH_DATE - TO_DATE('".$now."', 'yyyy/mm/dd')) DUE, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = P.ID GROUP BY ID_PROJECT),0) PROGRESS, P.FINISH_DATE - P.IS_FINISHED_DATE DIFF_FINISH FROM TBL_PROJECT P, TBL_USER U WHERE P.ID_VENDOR = U.ID AND P.ID IN (SELECT ID_PROJECT FROM TBL_SUPERVISOR_PROJECT WHERE ID_USER ".$userCondition." " .$adpro. " ".$vendor.")";

    $data['projects'] = $this->builtbyprime->explicit($sql);
    $data['user'] = $this->builtbyprime->get('TBL_USER');

		$this->load->view('project/index', $data);
	}

	public function add(){

    $idProject = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT");
    
    $data = array(
      'a' => $this->input->post('name'),
      'b' => $this->input->post('start-date'),
      'c' => $this->input->post('end-date'),
      'd' => str_replace(".", "", $this->input->post('project-budget')),
      'e' => $this->input->post('id-contractor'),
      'f' => $this->session->userdata('USERNAME'),
      'h' => ($this->input->post('id-project')) ? $this->input->post('id-project') : $idProject[0]['MAX'],
      'i' => $this->input->post('contract-no'),
      'j' => $this->input->post('description'),
      'k' => $this->input->post('spk-date')
    );

    if($this->input->post('id-project')){
      $res = $this->builtbyprime->explicit("UPDATE TBL_PROJECT SET start_date = TO_DATE('".$data['b']."','dd/mm/yyyy'), finish_date = TO_DATE('".$data['c']."','dd/mm/yyyy'), spk_date = TO_DATE('".$data['k']."','dd/mm/yyyy'),budget = '".$data['d']."', id_vendor = '".$data['e']."', contract_no= '".$data['i']."', modified_by = '".$data['f']."', modified_date = SYSDATE, name = '".$data['a']."', description = '".$data['j']."' WHERE id = '".$this->input->post('id-project')."'");

      $this->builtbyprime->delete('TBL_SUPERVISOR_PROJECT', array('id_project' => $this->input->post('id-project')));
    } else {
      $res = $this->builtbyprime->explicit("INSERT INTO TBL_PROJECT (id, name, start_date, finish_date, spk_date, budget, id_vendor, contract_no, created_date, modified_date, created_by, modified_by) VALUES ('".$data['h']."','".$data['a']."',TO_DATE('".$data['b']."','dd/mm/yyyy'),TO_DATE('".$data['c']."','dd/mm/yyyy'), TO_DATE('".$data['k']."','dd/mm/yyyy'),'".$data['d']."','".$data['e']."','".$data['i']."',SYSDATE, SYSDATE, '".$data['f']."','".$data['f']."')");      
    }

    $idSupervisor = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_SUPERVISOR_PROJECT");

    foreach ($this->input->post('id-supervisor') as $value) {
      $this->builtbyprime->insert('TBL_SUPERVISOR_PROJECT', array('id' => $idSupervisor[0]['MAX'], 'id_user'=> $value, 'id_project' => $data['h']));
      $idSupervisor[0]['MAX']++;
    }
    
    if($res){
      echo json_encode(array('status' => 'ok', 'data' => $data));
    } else {
      echo json_encode(array('status' => 'not ok'));
    }
	}

	public function view($id){
    $data['project'] = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['document'] = $this->builtbyprime->get('TBL_PROJECT_DOCUMENT', array('id_project' => $id));
    $data['supervisor'] = $this->builtbyprime->get('TBL_SUPERVISOR_PROJECT', array('id_project' => $id));
    $data['user'] = $this->builtbyprime->get('TBL_USER');
    $data['notices'] = $this->builtbyprime->explicit("SELECT * FROM TBL_MASTER_NOTICE ORDER BY NAME");
    $data['notice'] = $this->builtbyprime->explicit("SELECT type_history, notice_type FROM TBL_PROJECT_NOTICE_HISTORY where id_project = '".$id."' AND status = 1 ORDER BY notice_type");

    $Carbon = new Carbon\Carbon;

    $a = $Carbon::createFromFormat('d-M-y', $data['project']['START_DATE']);
    $b = $Carbon::now();
    $c = $Carbon::createFromFormat('d-M-y', $data['project']['FINISH_DATE']); 
    
    $totalDays = $c->diffInDays($a);
    $usedDays = $b->diffInDays($a);
    $remainingDays = 100 - (($usedDays/$totalDays) * 100);

    $isStarted = ($b->gte($a));
    $isFinished = ($data['project']['IS_FINISHED'] == 1);
    $isExceeded = ($b->gte($c));

    $data['weekNumber'] = ($isStarted) ? ceil(($b->diffInDays($a) + 1)/7) : 0;
    $data['countDown'] = ($isStarted) ? 0 : $b->diffInDays($a);
    $data['startWeek'] = $a->copy()->addWeeks($data['weekNumber'] - 1)->format('d/m/Y') ;
    $data['endWeek'] = $a->copy()->addWeeks($data['weekNumber'])->subDay()->format('d/m/Y');
    $data['isStarted'] = $isStarted;
    $data['isFinished'] = $isFinished;
    $data['statusLabel'] = ($isFinished) ? 'PROYEK SELESAI' : (($isStarted) ? (($isExceeded) ? 'TERLAMBAT ' . $b->diffInDays($c) . ' HARI' : 'BERLANGSUNG') : 'BELUM DIMULAI');
    $data['buttonStatusType'] = ($isFinished) ? 'btn-success' : (($isStarted) ? (($isExceeded) ? 'btn-danger' : 'btn-info') : 'btn-default');
    $data['remainingDays'] = round($remainingDays,2);
    $data['info'] = $this->builtbyprime->explicit("SELECT nvl((SELECT SUM(WEIGHT_PLANNING) FROM TBL_PROJECT_PLANNING_DETAIL WHERE WEEK_NUMBER <= '".$data['weekNumber']."' AND ID_PROJECT_PLANNING = (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."')),0) TOTAL_PLANNING, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$id."' GROUP BY ID_PROJECT),0) TOTAL_PERCENTAGE FROM DUAL");

    $data['info_extended'] = $this->builtbyprime->explicit("SELECT nvl((SELECT SUM(WEIGHT_PLANNING) FROM TBL_PROJECT_PLANNING_DETAIL WHERE WEEK_NUMBER <= '".($data['weekNumber'] - 1)."' AND ID_PROJECT_PLANNING = (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."')),0) TOTAL_PLANNING FROM DUAL");

    $this->load->view('project/detail', $data);
	}

	public function remove($id){
    //delete tbl_project
    //$this->builtbyprime->delete('TBL_ITEM_TASK', array('id_project' => $id));
    
    $this->builtbyprime->delete('TBL_SUPERVISOR_PROJECT', array('id_project' => $id));
    
    $this->builtbyprime->explicit("DELETE FROM TBL_DISCUSSION WHERE ID_ITEM_TASK IN (SELECT ID FROM TBL_ITEM_TASK WHERE ID_PROJECT = '".$id."')");
    $this->builtbyprime->explicit("DELETE FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = '".$id."'");
    $this->builtbyprime->explicit("DELETE FROM TBL_ITEM_TASK_TIME_VENDOR WHERE ID_PROJECT = '".$id."'");
    $this->builtbyprime->delete('TBL_ITEM_TASK', array('id_project' => $id));

    $this->builtbyprime->delete('TBL_PROJECT_DOCUMENT', array('id_project' => $id));
    $this->builtbyprime->delete('TBL_PROJECT_NOTICE_HISTORY', array('id_project' => $id));

    $this->builtbyprime->explicit("DELETE FROM TBL_PROJECT_PLANNING_DETAIL WHERE ID_PROJECT_PLANNING IN (SELECT ID FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."')");
    $this->builtbyprime->delete('TBL_PROJECT_PLANNING', array('id_project' => $id));
  
    $this->builtbyprime->delete('TBL_LOG_PROJECT', array('object_id' => $id));

    $res = $this->builtbyprime->delete('TBL_PROJECT', array('id' => $id));

    if($res){
      echo json_encode(array('status' => 'ok'));
    } else {
      echo json_encode(array('status' => 'not ok'));
    }
	}

	public function edit(){
    //update

    $id = $this->input->post('id-project');



    $this->builtbyprime->remove('TBL_SUPERVISOR_PROJECT', array('id_project' => $id));
    foreach ($this->input->post('id-supervisor') as $value) {
      $this->builtbyprime->insert('TBL_SUPERVISOR_PROJECT', array('id_user'=> $value, 'id_project' => $id));
    }

    echo json_encode($res);
  }

  public function update_notice($projectId){

    $id = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_NOTICE_HISTORY");
    $data = Array(
      'id' => $id[0]['MAX'],
      'id_project' => $projectId,
      'notice_type' => $this->input->post('value'),
      'type_history' => $this->input->post('is-checked'),
      'description' => '-',
      'name' => $this->input->post('name'),
      'status' => 1,
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    $upd = $this->builtbyprime->update('TBL_PROJECT_NOTICE_HISTORY', Array('id_project' => $projectId, 'notice_type' => $this->input->post('value')), Array('status' => 0));

    $res = $this->builtbyprime->insert('TBL_PROJECT_NOTICE_HISTORY', $data);

    if($res){
      echo json_encode(Array('status'=> 'ok', 'data' => $res));
    } else {
      echo json_encode(Array());
    }

  }

  function load_log($id){
    $res = $this->builtbyprime->explicit("SELECT L.ID, L.USERNAME, U.PROFILE_IMAGE_URL, L.DESCRIPTION, TO_CHAR(CAST(L.CREATED_DATE AS DATE), 'DD/MM/YYYY HH:MI:SS') CREATED FROM TBL_LOG_PROJECT L, TBL_USER U WHERE U.USERNAME = L.USERNAME AND L.OBJECT_ID = '".$id."' ORDER BY L.ID DESC");

    echo json_encode(Array('status' => 'ok', 'data' => $res));
  }

  function set_finish($projectId){
    if($this->input->post('is-checked') == 1){
      $res = $this->builtbyprime->explicit("UPDATE TBL_PROJECT SET is_finished = '".$this->input->post('is-checked')."', is_finished_date = TO_DATE('".$this->input->post('is-finished-date')."','dd/mm/yyyy'), modified_by = '".$this->session->userdata('USERNAME')."', modified_date = SYSDATE WHERE id = '".$projectId."'");
    } else {
      $res = $this->builtbyprime->explicit("UPDATE TBL_PROJECT SET is_finished = '".$this->input->post('is-checked')."', modified_by = '".$this->session->userdata('USERNAME')."', modified_date = SYSDATE WHERE id = '".$projectId."'");
    }
      
    if($res){
      echo json_encode(Array('status'=> 'ok', 'data' => $res));
    } else {
      echo json_encode(Array());
    }

  }

}
