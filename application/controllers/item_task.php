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
      'd' => $this->input->post('specification'),
      'e' => $this->input->post('volume'),
      'f' => $this->input->post('unit'),
      'g' => $this->input->post('unit_price'),
      'h' => $this->session->userdata('USERNAME'),
      );

    if($is_edit == 1){ //edit
      $this->builtbyprime->update('TBL_ITEM_TASK',array('ID'=>$id),
        array(
          'id_parent'=>$data['b'],
          'id_project'=>$data['a'],
          'name'=>$data['c'],
          'specification'=>$data['d'],
          'volume'=>$data['e'],
          'unit'=>$data['f'],
          'unit_price'=>$data['g'],
           //'modified_date'=>date('d/m/Y H:i:s'),
          'modified_by'=>$data['h']
          )
        );
    }
    else
    {
      $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");
      $res    = $this->builtbyprime->explicit("INSERT INTO TBL_ITEM_TASK
        (id, id_parent, id_project, name, specification, volume, unit, created_date, modified_date, created_by, modified_by, unit_price) 
        VALUES 
        ('".$idItem[0]['MAX']."',
         '".$data['b']."',
         '".$data['a']."',
         '".$data['c']."',
         '".$data['d']."',
         '".$data['e']."',
         '".$data['f']."',
         SYSDATE, 
         SYSDATE, 
         '".$data['h']."',
         '".$data['h']."',
         '".$data['g']."')
      ");
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

  public function project($id){ 
    $lvl2                 = $this->builtbyprime->get('TBL_ITEM_TASK', array('id_parent' => 0));
   
    /*
    $ar                   = array();
    foreach ($lvl2 as $v):
      $ar[] = $v['ID'];
    endforeach;
    $data['ar_id']        = $ar;
    */

    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,TBL_ITEM_TASK.* FROM TBL_ITEM_TASK WHERE ID_PROJECT = '.$id.' START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME');
    $data['max_level']    = $this->builtbyprime->explicit('SELECT MAX(LEVEL) AS MAX FROM TBL_ITEM_TASK WHERE ID_PROJECT = 1 START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME');

    $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['id']           = $id;
    $this->load->view('item_task/project', $data);
  }

}
