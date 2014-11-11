<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quick_access extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('isLoggedIn')){
      redirect('/authentication/', 'refresh');
    } 
  }

  public function index(){
    //pilih semua projek yang diawasi oleh user, pilih item yang dikerjakan pada minggu ini, pilih perencanaan terakhir dan pilih item, volume untuk realisasi


    $this->load->view('quick_access/index');
  }



}
