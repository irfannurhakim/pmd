<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $now = date('Y/m/d');
    $userCondition = "IS NOT NULL";

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $userCondition = " = '" . $this->session->userdata('ID') . "'";  
    }

    $sql = "SELECT P.ID, P.NAME, U.AFFILIATION VENDOR_NAME, (P.FINISH_DATE - TO_DATE('".$now."', 'yyyy/mm/dd')) DUE, 0 AS PROGRESS, 0 AS DEVIATION FROM TBL_PROJECT P, TBL_USER U WHERE P.ID_VENDOR = U.ID AND P.ID IN (SELECT ID_PROJECT FROM TBL_SUPERVISOR_PROJECT WHERE ID_USER ".$userCondition.")";

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
      'i' => $this->input->post('contract-no')
    );

    if($this->input->post('id-project')){
      $res = $this->builtbyprime->explicit("UPDATE TBL_PROJECT SET start_date = TO_DATE('".$data['b']."','dd/mm/yyyy'), finish_date = TO_DATE('".$data['c']."','dd/mm/yyyy'), budget = '".$data['d']."', id_vendor = '".$data['e']."', contract_no= '".$data['i']."', modified_by = '".$data['f']."', modified_date = SYSDATE WHERE id = '".$this->input->post('id-project')."'");

      $this->builtbyprime->delete('TBL_SUPERVISOR_PROJECT', array('id_project' => $this->input->post('id-project')));
    } else {
      $res = $this->builtbyprime->explicit("INSERT INTO TBL_PROJECT (id, name, start_date, finish_date, budget, id_vendor, contract_no, created_date, modified_date, created_by, modified_by) VALUES ('".$data['h']."','".$data['a']."',TO_DATE('".$data['b']."','dd/mm/yyyy'),TO_DATE('".$data['c']."','dd/mm/yyyy'),'".$data['d']."','".$data['e']."','".$data['i']."',SYSDATE, SYSDATE, '".$data['f']."','".$data['f']."')");      
    }

    foreach ($this->input->post('id-supervisor') as $value) {
      $this->builtbyprime->insert('TBL_SUPERVISOR_PROJECT', array('id_user'=> $value, 'id_project' => $data['h']));
    }
    
    echo json_encode($res);
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

    $isStarted = ($b->gte($a));
    $isFinish = ($b->gte($c));

    $data['weekNumber'] = ($isStarted) ? ceil(($b->diffInDays($a) + 1)/7) : 0;
    $data['countDown'] = ($isStarted) ? 0 : $b->diffInDays($a);
    $data['startWeek'] = $a->copy()->addWeeks($data['weekNumber'] - 1)->format('d/m/Y') ;
    $data['endWeek'] = $a->copy()->addWeeks($data['weekNumber'])->subDay()->format('d/m/Y');
    $data['isStarted'] = $isStarted;
    $data['statusLabel'] = ($isStarted) ? (($isFinish) ? 'PROYEK SELESAI' : 'BERLANGSUNG') : 'BELUM DIMULAI'; 
    $data['buttonStatusType'] = ($isStarted) ? (($isFinish) ? 'btn-success' : 'btn-primary') : 'btn-info'; 


    $this->load->view('project/detail', $data);
	}

	public function remove(){

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
}
