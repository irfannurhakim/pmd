<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('isLoggedIn')){
			redirect('/authentication/', 'refresh');
		} 
	}

	public function index(){   
		$this->load->view('home/index');	
	}

	public function add(){

	}

	public function view(){

	}

	public function remove(){

	}

	public function edit(){

	}

  public function topstat($sorting = 0, $year = null){
    //sorting 0 by jumlah nilai proyek, sorting 1 by jumlah poyek 
    $sortby = 'jml_proyek';
    $tahun = ($year) ? $year : date('Y');

    if($sorting == 1){
      $sortby = 'jml_nilai_proyek';
    }

    $contractors = $this->builtbyprime->explicit("SELECT * FROM (SELECT v.affiliation name, p.id_vendor, COUNT(p.id_vendor) jml_proyek, SUM(p.budget) jml_nilai_proyek FROM TBL_PROJECT p, TBL_USER v WHERE v.id = p.id_vendor and EXTRACT(YEAR FROM p.START_DATE) = '".$tahun."' GROUP BY p.id_vendor, v.affiliation ORDER BY ".$sortby." DESC) WHERE ROWNUM <= 5");
    $supervisors = $this->builtbyprime->explicit("SELECT * FROM (SELECT U.NAME, U.AFFILIATION, S.ID_USER, COUNT(S.ID_USER) JML_PROYEK FROM TBL_SUPERVISOR_PROJECT S, TBL_USER U, TBL_PROJECT P WHERE U.ID = S.ID_USER AND P.ID = S.ID_PROJECT AND EXTRACT(YEAR FROM P.START_DATE) = '".$tahun."' GROUP BY U.NAME, S.ID_USER, U.AFFILIATION ORDER BY JML_PROYEK DESC) WHERE ROWNUM <= 5");

    echo json_encode(array('status' => 'ok', 'contractors' => $contractors, 'supervisors' => $supervisors));
  }


}
