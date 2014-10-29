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
    $idProject = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT");

    $data = array(
      'a' => $this->input->post('name'),
      'b' => $this->input->post('start-date'),
      'c' => $this->input->post('end-date'),
      'd' => $this->input->post('project-budget'),
      'e' => $this->input->post('id-contractor'),
      'f' => $this->session->userdata('USERNAME'),
      'h' => $idProject[0]['MAX']
    );

    $res = $this->builtbyprime->explicit("INSERT INTO TBL_PROJECT (id, name, start_date, finish_date, budget, id_vendor, created_date, modified_date, created_by, modified_by) VALUES ('".$data['h']."','".$data['a']."',TO_DATE('".$data['b']."','dd/mm/yyyy'),TO_DATE('".$data['c']."','dd/mm/yyyy'),'".$data['d']."','".$data['e']."',SYSDATE, SYSDATE, '".$data['f']."','".$data['f']."')");

    foreach ($this->input->post('id-supervisor') as $value) {
      $this->builtbyprime->insert('TBL_SUPERVISOR_PROJECT', array('id_user'=> $value, 'id_project' => $data['h']));
    }
    
    echo json_encode($res);
	}

	public function view(){
    $this->load->view('project/detail');
	}

	public function remove(){

	}

	public function edit(){

	}
}
