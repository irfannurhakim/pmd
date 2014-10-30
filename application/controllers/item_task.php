<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_task extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $data['project'] = $this->builtbyprime->get('TBL_PROJECT');
    $data['item']    = $this->builtbyprime->get('TBL_ITEM_TASK');

    $data['item_list']    = $this->builtbyprime->get('TBL_ITEM_TASK');
		$this->load->view('item_task/index', $data);
	}

	public function add(){
    $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");

    $data = array(
      'a' => $this->input->post('id-project'),
      'b' => $this->input->post('id-parent'),
      'c' => $this->input->post('name'),
      'd' => $this->input->post('value'),
      'e' => $this->input->post('volume'),
      'f' => $this->input->post('satuan'),
      'g' => $idItem[0]['MAX'],
      'h' => $this->session->userdata('USERNAME')
    );

    $res = $this->builtbyprime->explicit("INSERT INTO TBL_ITEM_TASK
                                        (id, id_parent, id_project, name, value, volume, satuan, created_date, modified_date, created_by, modified_by) 
                                        VALUES 
                                        ('".$data['g']."','".$data['b']."','".$data['a']."','".$data['c']."','".$data['d']."','".$data['e']."','".$data['f']."',SYSDATE, SYSDATE, '".$data['h']."','".$data['h']."')");
    
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
