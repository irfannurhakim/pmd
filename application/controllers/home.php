<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('isLoggedIn')){
			redirect('/authentication/', 'refresh');
		} 
	}

	public function index(){
    $data['contractors'] = $this->builtbyprime->explicit("SELECT * FROM (SELECT v.affiliation name, p.id_vendor, count(p.id_vendor) jml_proyek, sum(p.budget) jml_nilai_proyek FROM TBL_PROJECT p, TBL_USER v WHERE v.id = p.id_vendor GROUP BY p.id_vendor, v.affiliation ORDER BY jml_nilai_proyek DESC) WHERE ROWNUM <= 5");

    $data['supervisors'] = $this->builtbyprime->explicit("SELECT * FROM (SELECT U.NAME, U.AFFILIATION, S.ID_USER, COUNT(S.ID_USER) JML_PROYEK FROM TBL_SUPERVISOR_PROJECT S, TBL_USER U WHERE U.ID = S.ID_USER GROUP BY U.NAME, S.ID_USER, U.AFFILIATION ORDER BY JML_PROYEK DESC) WHERE ROWNUM <= 5");    


		$this->load->view('home/index', $data);	
	}

	public function add(){

	}

	public function view(){

	}

	public function remove(){

	}

	public function edit(){

	}
}
