<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }
  public function add(){

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|jpeg';
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('input-upload-document')){
      echo json_encode(array('error' => $this->upload->display_errors('<span>', '</span>')));
      exit();
    } else {
      // upload success
      $upload_data = $this->upload->data();

      $factory   = new RandomLib\Factory;
      $generator = $factory->getMediumStrengthGenerator();
      //Generate Token
      $token      = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }

    $id = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_DOCUMENT");

    $data = array(
      'id' => $id[0]['MAX'],
      'id_project' => $this->input->post('input-id-project'),
      'file_name' => $upload_data['file_name'],
      'original_file_name' => $upload_data['orig_name'],
      'hash_code_url' => $token,
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    $res = $this->builtbyprime->insert('TBL_PROJECT_DOCUMENT', $data);

    echo json_encode($res);
  }

  public function view($hashCode){
    
    $document = $this->builtbyprime->get('TBL_PROJECT_DOCUMENT', array('hash_code_url' => $hashCode), TRUE);

    if($document){
      $data = file_get_contents('./uploads/' . $document['FILE_NAME']);

      if(!$data)
        show_404();

      $name = $document['ORIGINAL_FILE_NAME'];

      force_download($name, $data);
    } else {
      show_404();
    }
  }

  public function remove($id){
    $data = $this->db->delete('TBL_PROJECT_DOCUMENT', array('id' => $id));

    if($data){
      echo json_encode(array('status'=>0, 'data' => $data));
    } else {
      echo json_encode(array('status'=>1));
    }

  }

}