<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_task extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $data['project'] = $this->builtbyprime->get('TBL_PROJECT');
    $data['item']    = $this->builtbyprime->get('TBL_ITEM_TASK');

    $data['item_list']    = $this->builtbyprime->explicit('SELECT A.*,B.NAME PARENT FROM TBL_ITEM_TASK A LEFT JOIN TBL_ITEM_TASK B ON A.ID_PARENT = B.ID ORDER BY A.ID_PARENT');
		$this->load->view('item_task/index', $data);
	}

	public function add(){
    $is_edit = $this->input->post('is-edit');
    $id      = $this->input->post('id');

    $data = array(
      'a' => $this->input->post('id-project'),
      'b' => $this->input->post('id-parent'),
      'c' => $this->input->post('name'),
      'd' => $this->input->post('value'),
      'e' => $this->input->post('volume'),
      'f' => $this->input->post('satuan'),
      'h' => $this->session->userdata('USERNAME')
    );

    if($is_edit == 1){ //edit
      $this->builtbyprime->update('TBL_ITEM_TASK',array('ID'=>$id),
                                    array(
                                            'id_parent'=>$data['b'],
                                            'id_project'=>$data['a'],
                                            'name'=>$data['c'],
                                            'value'=>$data['d'],
                                            'volume'=>$data['e'],
                                            'satuan'=>$data['f'],
                                            //'modified_date'=>date('d/m/Y H:i:s'),
                                            'modified_by'=>$data['h'],
                                          )
                                  );
    }
    else
    {
      $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");
      $res    = $this->builtbyprime->explicit("INSERT INTO TBL_ITEM_TASK
                                          (id, id_parent, id_project, name, value, volume, satuan, created_date, modified_date, created_by, modified_by) 
                                          VALUES 
                                          ('".$idItem[0]['MAX']."','".$data['b']."','".$data['a']."','".$data['c']."','".$data['d']."','".$data['e']."','".$data['f']."',SYSDATE, SYSDATE, '".$data['h']."','".$data['h']."')");
    }
    
    echo json_encode($res);
	}

  public function id($id){
    $user = $this->builtbyprime->get('TBL_ITEM_TASK',array('ID'=>$id), TRUE);

    if($user){
      echo json_encode(array('status' => 'ok', 'data' => $user));
    } else {
      echo json_encode(array('status' => 'error'));
    }
  }

	public function view(){
    $this->load->view('project/detail');
	}

	public function remove($id){
    $remove = $this->builtbyprime->delete('TBL_ITEM_TASK',array('ID'=>$id));

    if($remove){
      echo json_encode(array('status' => 'ok'));
    } else {
      echo json_encode(array('status' => 'error'));
    }

	}
}
