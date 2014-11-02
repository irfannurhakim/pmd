<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $now = date('Y/m/d');
    $sql = "SELECT P.ID, P.NAME, U.AFFILIATION VENDOR_NAME, (P.FINISH_DATE - TO_DATE('".$now."', 'yyyy/mm/dd')) DUE, 0 AS PROGRESS, 0 AS DEVIATION FROM TBL_PROJECT P, TBL_USER U WHERE P.ID_VENDOR = U.ID";

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
}
