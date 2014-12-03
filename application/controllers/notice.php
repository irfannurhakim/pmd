<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Controller {

  public function index(){
    $data['notice'] = $this->builtbyprime->get('TBL_MASTER_NOTICE');

    $this->load->view('parameter/notice/index', $data);
  }

  public function add(){

    $id = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_MASTER_NOTICE");

    $data = array(
      'id' => $id[0]['MAX'],
      'name' => $this->input->post('name'),
      'description' => $this->input->post('description'),
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    //update
    if($this->input->post('is-edit') == 1 && $this->input->post('id') != -1){
      unset($data['created_by']);

      $update = $this->builtbyprime->update('TBL_MASTER_NOTICE', array('id' => $this->input->post('id')), $data);

      if($update){
        echo json_encode(array('status'=> 'ok', 'data' => $data));
      } else {
        echo json_encode(array('status'=> 'not ok'));
      }

      exit();
    }

    $res = $this->builtbyprime->insert('TBL_MASTER_NOTICE', $data);

    if($res){
      echo json_encode(Array('status' => 'ok', 'data' => $res));
    } else {
      echo json_encode(Array('status' => 'not ok'));
    }
  }

  public function view($id){
    $data = $this->builtbyprime->get('TBL_MASTER_NOTICE', array('id'=>$id), TRUE);

    if($data){
      echo json_encode(array('status'=>'ok', 'data' => $data));
    } else {
      echo json_encode(array('status'=>'not ok'));
    }
  }

  public function remove($id){
    $data = $this->builtbyprime->delete('TBL_MASTER_NOTICE', array('id'=>$id));

    if($data){
      echo json_encode(array('status'=>'ok', 'data' => $data));
    } else {
      echo json_encode(array('status'=>'not ok'));
    }
  }
}