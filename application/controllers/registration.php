<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if($this->session->userdata('isLoggedIn')){
      redirect('/', 'refresh');
    } 
  }

  public function index(){
    $this->load->view('registration/index');
  }

  public function register(){
    $data = array(
      'username' => $this->input->post('username'),
      'name' => $this->input->post('name'),
      'password' => md5($this->input->post('password')),
      'email' => $this->input->post('email'),
      'telephone_number' => $this->input->post('telephone-number'),
      'affiliation' => $this->input->post('affiliation'),
      'id_user_type' => 4,
      'is_verified' => 0,
      'profile_image_url' => 'public/images/photos/profile.png'
    );

    //cek username
    $usernameIsExist = $this->builtbyprime->get('TBL_USER', array('username' => $this->input->post('username')), TRUE);
    if($usernameIsExist){
      echo json_encode(array('status' => 'param', 'message'=>'Username sudah dipakai'));
      exit();
    }

    //cek email
    $emailIsExist = $this->builtbyprime->get('TBL_USER', array('email' => $this->input->post('email')), TRUE);
    if($emailIsExist){
      echo json_encode(array('status' => 'param', 'message'=>'Email sudah dipakai'));
      exit();
    }

    $res = $this->builtbyprime->insert('TBL_USER', $data);
    if($res){
      echo json_encode(Array('status' => 'ok'));
    } else {
      echo json_encode(Array('status' => 'not ok'));
    }
  }

  public function success(){
    $this->load->view('registration/success');
  }
}