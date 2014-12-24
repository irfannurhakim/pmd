<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $now = date('Y/m/d');
    $userCondition = "IS NOT NULL";

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $userCondition = " = '" . $this->session->userdata('ID') . "'";  
    }

    $sql = "SELECT P.ID, P.NAME, U.AFFILIATION VENDOR_NAME, (P.START_DATE -  TO_DATE('".$now."', 'yyyy/mm/dd')) FROM_START, (P.FINISH_DATE - TO_DATE('".$now."', 'yyyy/mm/dd')) DUE, nvl((SELECT SUM(PERCENTAGE) FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = P.ID GROUP BY ID_PROJECT),0) PROGRESS, 0 AS DEVIATION FROM TBL_PROJECT P, TBL_USER U WHERE P.ID_VENDOR = U.ID AND P.ID IN (SELECT ID_PROJECT FROM TBL_SUPERVISOR_PROJECT WHERE ID_USER ".$userCondition.") AND P.FINISH_DATE >= SYSDATE AND P.START_DATE <= SYSDATE";

    $data['projects'] = $this->builtbyprime->explicit($sql);
    $data['user'] = $this->builtbyprime->get('TBL_USER');

    $this->load->view('reports/index', $data);

  }

  public function weekly_report($id,$week=1){ 
    $data['item_list']    = $this->builtbyprime->explicit('SELECT A.NAME,A.UNIT,B.* FROM TBL_ITEM_TASK A JOIN TBL_ITEM_TASK_TIME B ON A.ID = B.ID_ITEM_TASK WHERE A.ID_PROJECT = '.$id.' AND B.NO_WEEK = '.$week.' ');
    $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['id']           = $id;
    $data['week']         = $this->builtbyprime->explicit('select NO_WEEK FROM TBL_ITEM_TASK_TIME WHERE ID_PROJECT = 13 GROUP BY NO_WEEK ORDER BY NO_WEEK ASC');
    $data['cur_week']     = $week;
    $this->load->view('reports/weekly_report', $data);
  }

  public function weekly_report_chart($id,$week=1){ 
    $sql = $this->builtbyprime->explicit('SELECT A.NAME,A.UNIT,B.* FROM TBL_ITEM_TASK A JOIN TBL_ITEM_TASK_TIME B ON A.ID = B.ID_ITEM_TASK WHERE A.ID_PROJECT = '.$id.' AND B.NO_WEEK = '.$week.' ');

    foreach($sql as $val)
    {
      $judul[]   = $val['NAME'];
      $nilai[]   = (int) $val['PERCENTAGE'];
    }
        
    $data = array('nilai' => $nilai,'judul' => $judul);
    echo json_encode($data);
  }

  function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = $this->json_encode($value);
                    $output_associative[] = $this->json_encode($key) . ':' . $this->json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }

}
