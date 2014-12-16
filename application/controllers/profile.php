<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('isLoggedIn')){
      redirect('/authentication/', 'refresh');
    } 
  }

  public function index(){
   
  }

  public function update(){ 

    $data = array(
      'name' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'affiliation' => $this->input->post('affiliation'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    if(!empty($_FILES['profile-picture']['name'])){

      $config['upload_path'] = './uploads/profile_pictures/';
      $config['allowed_types'] = 'png|jpg|jpeg';
      $config['encrypt_name'] = true;

      $this->load->library('upload', $config);

      if(!file_exists($config['upload_path']))
        mkdir($config['upload_path'], 0777);

      if(!$this->upload->do_upload('profile-picture')){
        echo json_encode(array('error' => $this->upload->display_errors('<span>', '</span>')));
        exit();
      } else {
        $upload_data = $this->upload->data();    
        $data['profile_image_url'] = 'uploads/profile_pictures/' . $upload_data['file_name'];
      }
    } 

    $update = $this->builtbyprime->update('TBL_USER', array('id' => $this->session->userdata('ID')), $data);

    if($update){
      $this->session->set_userdata('NAME', $data['name']);
      $this->session->set_userdata('EMAIL', $data['email']);
      $this->session->set_userdata('AFFILIATION', $data['affiliation']);
      if(!empty($_FILES['profile-picture']['name']))
        $this->session->set_userdata('PROFILE_IMAGE_URL', $data['profile_image_url']);

      echo json_encode(array('status'=> 'ok', 'data' => $data));
    } else {
      echo json_encode(array('status'=> 'not ok'));
    }
  }

  public function update_password(){
    $oldpass = $this->input->post('my-old-password');
    $newpass = $this->input->post('my-new-password');

    //check pass lama
    $user = $this->builtbyprime->get('TBL_USER', array('username' => $this->session->userdata('USERNAME'), 'password' => md5($oldpass)), TRUE);

    if(!$user){
      echo json_encode(array('status' => 'not ok', 'message' => 'Password lama tidak cocok!'));
      exit();
    } 

    $update = $this->builtbyprime->update('TBL_USER', array('id' => $this->session->userdata('ID')), array('password' => md5($newpass)));

    if($update){
      echo json_encode(array('status'=> 'ok'));
    } else {
      echo json_encode(array('status'=> 'not ok'));
    }
  }
}
