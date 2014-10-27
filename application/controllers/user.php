<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index(){
    $data['user_type'] = $this->builtbyprime->get('TBL_USER_TYPE');
    $data['users'] = $this->builtbyprime->explicit('SELECT a.ID, a.USERNAME, a.NAME, a.AFFILIATION, a.EMAIL, a.PASSWORD, b.NAME as TIPE FROM TBL_USER a, TBL_USER_TYPE b WHERE b.ID = a.ID_USER_TYPE');

		$this->load->view('parameter/user/index', $data);
	}

	public function add(){
    $data = array(
      'username' => $this->input->post('username'),
      'name' => $this->input->post('name'),
      'password' => md5($this->input->post('password')),
      'email' => $this->input->post('email'),
      'affiliation' => $this->input->post('affiliation'),
      'id_user_type' => $this->input->post('id-user-type')
    );

    //update
    if($this->input->post('is-edit') == 1 && $this->input->post('id') != -1){
      if(strlen($this->input->post('password')) < 1) {
        unset($data['password']);
      }

      $update = $this->builtbyprime->update('TBL_USER', array('id' => $this->input->post('id')), $data);

      if($update){
        echo json_encode(array('status'=>0, 'data' => $data));
      } else {
        echo json_encode(array('status'=>1));
      }

      exit();
    }

    //cek username
    $usernameIsExist = $this->builtbyprime->get('TBL_USER', array('username' => $this->input->post('username')), TRUE);
    if($usernameIsExist){
      echo json_encode(array('message'=>'Username sudah dipakai'));
      exit();
    }

    //cek email
    $emailIsExist = $this->builtbyprime->get('TBL_USER', array('email' => $this->input->post('email')), TRUE);
    if($emailIsExist){
      echo json_encode(array('message'=>'Email sudah dipakai'));
      exit();
    }

    $res = $this->builtbyprime->insert('TBL_USER', $data);

    echo json_encode($res);
	}

	public function view($id){
    $data = $this->builtbyprime->get('TBL_USER', array('id'=>$id), TRUE);

    if($data){
      echo json_encode(array('status'=>0, 'data' => $data));
    } else {
      echo json_encode(array('status'=>1));
    }
	}

	public function remove($id){
    $data = $this->builtbyprime->delete('TBL_USER', array('id'=>$id));

    if($data){
      echo json_encode(array('status'=>0, 'data' => $data));
    } else {
      echo json_encode(array('status'=>1));
    }
	}

	public function edit(){
		
	}

  public function dt_get_all_user(){
    $this->datatables->select('id, username, name, affiliation, email')
      ->from('TBL_USER')
      ->add_column('action', '<a data-toggle="tooltip" title="Edit" class="tooltips" object="$1"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" title="Hapus" class="tooltips" object="$1"><i class="fa fa-trash-o"></i></a>', 'id');

    echo $this->datatables->generate();
  }
}