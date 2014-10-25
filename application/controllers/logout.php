<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {


  public function __construct(){
    parent::__construct(); 
  }

  public function index(){
    //$this->db->insert('tbl_global_logs', array('id_event'=> 11, 'id_user'=>$this->session->userdata['id'], 'description'=> 'logout', 'severity'=>'normal'));
    $this->session->sess_destroy(); 
    redirect(base_url() . 'authentication');
  }
}
