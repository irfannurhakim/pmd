<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_task extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $data['project'] = $this->builtbyprime->get('TBL_PROJECT');
    $data['item']    = $this->builtbyprime->get('TBL_ITEM_TASK');

    $data['item_list']    = $this->builtbyprime->explicit('SELECT A.*,B.NAME PARENT FROM TBL_ITEM_TASK A LEFT JOIN TBL_ITEM_TASK B ON A.ID_PARENT = B.ID ORDER BY A.ID_PARENT');
    $this->load->view('item_task/index', $data);
  }

  public function add(){
    $is_edit = $this->input->post('is-edit');
    $id      = $this->input->post('id');

    $data = array(
      'a' => $this->input->post('id-project'),
      'b' => $this->input->post('id-parent'),
      'c' => $this->input->post('name'),
      'd' => $this->input->post('specification'),
      'e' => $this->input->post('volume'),
      'f' => $this->input->post('unit'),
      'g' => str_replace(".","", $this->input->post('unit_price')),
      'h' => $this->session->userdata('USERNAME'),
    );

    if($is_edit == 1){ //edit
      $this->builtbyprime->update('TBL_ITEM_TASK',array('ID'=>$id),
        array(
          'id_parent'=>$data['b'],
          'id_project'=>$data['a'],
          'name'=>$data['c'],
          'specification'=>$data['d'],
          'volume'=>$data['e'],
          'unit'=>$data['f'],
          'unit_price'=>$data['g'],
          //'modified_date'=>date('d/m/Y H:i:s'),
          'modified_by'=>$data['h']
          )
        );
    }
    else
    {
      $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");
      $res    = $this->builtbyprime->explicit("INSERT INTO TBL_ITEM_TASK
        (id, id_parent, id_project, name, specification, volume, unit, created_date, modified_date, created_by, modified_by, unit_price) 
        VALUES 
        ('".$idItem[0]['MAX']."',
         '".$data['b']."',
         '".$data['a']."',
         '".$data['c']."',
         '".$data['d']."',
         '".$data['e']."',
         '".$data['f']."',
         SYSDATE, 
         SYSDATE, 
         '".$data['h']."',
         '".$data['h']."',
         '".$data['g']."')
      ");
    }
    
    echo json_encode($res);
  }

  public function id($id){
    $user = $this->builtbyprime->get('TBL_ITEM_TASK',array('ID'=>$id), TRUE);

    if($user){
      echo json_encode(array('status' => 'ok', 'data' => $user));
    } else {
      echo json_encode(array('status' => 'error'));
    }
  }

  public function view(){
    $this->load->view('project/detail');
  }

  public function remove($id){
    $remove = $this->builtbyprime->delete('TBL_ITEM_TASK',array('ID'=>$id));

    if($remove){
      echo json_encode(array('status' => 'ok'));
    } else {
      echo json_encode(array('status' => 'error'));
    }
  }

  public function remove_all($id){
    $this->builtbyprime->explicit("DELETE FROM TBL_DISCUSSION WHERE ID_ITEM_TASK IN (SELECT ID FROM TBL_ITEM_TASK WHERE ID_PROJECT = '".$id."')");
    $this->builtbyprime->explicit("DELETE FROM TBL_ITEM_TASK_TIME WHERE ID_ITEM_TASK IN (SELECT ID FROM TBL_ITEM_TASK WHERE ID_PROJECT = '".$id."')");
    $remove = $this->builtbyprime->delete('TBL_ITEM_TASK', array('id_project' => $id));


    if($remove){
      echo json_encode(array('status' => 'ok'));
    } else {
      echo json_encode(array('status' => 'error'));
    }
  }


  public function project($id){ 
    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,TBL_ITEM_TASK.* FROM TBL_ITEM_TASK WHERE ID_PROJECT = '.$id.' START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY ID');
    $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['id']           = $id;

    $t = $this->genMulDimArr($data['item_list']);
    $data['rows'] = $this->flatten($t, $data['project']['BUDGET']);

    $this->load->view('item_task/project', $data);
  }

  public function genMulDimArr($arr, $parent = 0, $root = ''){
    $pages = Array();
    $local = 1;
    foreach($arr as $page){
      if($page['ID_PARENT'] == $parent){
        $page['NUMBER'] = $root . $local . '.';
        $page['SUB'] = isset($page['SUB']) ? $page['SUB'] : $this->genMulDimArr($arr, $page['ID'], $page['NUMBER']);
        $pages[] = $page;
        $local++;
      }
    }
    return $pages;
  }

  public function flatten($arr, $budget){
    $html = '';
    $isLast = false;

    foreach($arr as $item){
      if($item['SUB'] == null) {
        $isLast = true;
      } 

      $style = ($item['LEVEL'] == 1 || $item['LEVEL'] == 2) ? 'style="font-weight:bold;"' : '';
      $html .= '<tr '. $style . '>';
      $html .= '<td>' . $item['NUMBER'] . '</td>';
      $html .= '<td>' . (($item['LEVEL'] == 1) ? strtoupper($item['NAME']) : $item['NAME']) . '</td>';
      $html .= '<td>' . (($isLast) ? $item['SPECIFICATION'] : '' ) . '</td>';
      $html .= '<td class="dt-cols-center">' . (($isLast) ? $item['UNIT'] : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? round($item['VOLUME'],4) : '') . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'], 0,',','.') : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? round((($item['UNIT_PRICE'] * $item['VOLUME']) / $budget ) * 100, 3) : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'] * $item['VOLUME'], 0,',','.') : '' ) . '</td>';
      $html .= '<td class="dt-cols-center">';
      $html .=    '<a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="'. $item['ID'] .'"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;';
      $html .=    (($this->session->userdata('ID_USER_TYPE') == 1) || ($this->session->userdata('ID_USER_TYPE') == 6)) ? '<a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="'. $item['ID'] .'"><i class="fa fa-trash-o"></i></a>' : '';
      $html .=  '</td>';
      $html .= '</tr>';
      $html .= $this->flatten($item['SUB'], $budget);
    }

    return $html;
  }

  public function periode($id){ 

    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,A.* FROM TBL_ITEM_TASK A WHERE A.ID_PROJECT = '.$id.' START WITH A.ID_PARENT = 0 CONNECT BY PRIOR A.ID = A.ID_PARENT ORDER SIBLINGS BY ID');
    $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['id']           = $id;
    $tempAllTask          = $this->builtbyprime->explicit("SELECT * FROM TBL_PROJECT_PLANNING_DETAIL WHERE ID_PROJECT_PLANNING = (SELECT MAX(ID) FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."')");  

    $allTask = Array();

    foreach ($tempAllTask as $key => $value) {
      $allTask[(integer) $value['ID_ITEM_TASK']][(integer) $value['WEEK_NUMBER']] = $value;
    }

    $start                = explode(' ',$data['project']['START_DATE']); 
    $finish               = explode(' ',$data['project']['FINISH_DATE']);
    $datediff             = strtotime($finish[0]) - strtotime($start[0]);
    $week                 = ceil(($datediff/(60*60*24))/7);
    
    $html = '';
    for($i=1;$i<=$week;$i++){
      $html .= '<th width="30px" class="text-center">'.$i.'</th>';
    }

    $data['column'] = $html;
    $data['week']   = $week;

    $t            = $this->genMulDimArr($data['item_list']);
    $data['rows'] = $this->flatten_periode($t, $week, $allTask, $data['project']['BUDGET']);

    $this->load->view('item_task/periode', $data);
  }

  public function flatten_periode($arr, $week, $allTask, $budget){
    $html = '';
    $isLast = false;

    foreach($arr as $item){
      if($item['SUB'] == null) {
        $isLast = true;
      } 

      $style = ($item['LEVEL'] == 1 || $item['LEVEL'] == 2) ? 'style="font-weight:bold;"' : '';
      $html .= '<tr '. $style . '>';
      $html .= '<td>' . $item['NUMBER'] . '</td>';
      $html .= '<td>' . (($item['LEVEL'] == 1) ? strtoupper($item['NAME']) : $item['NAME']) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? round((($item['UNIT_PRICE'] * $item['VOLUME']) / $budget ) * 100, 4) : '' ) . '</td>';

      for($i=1;$i<=$week;$i++){
        $value = null;
        if(array_key_exists((integer) $item['ID'], $allTask)){
          if(array_key_exists((integer) $i, $allTask[$item['ID']])){
            $value = $allTask[$item['ID']][$i];
          }
        }
        $val   = ($value) ? round($value['WEIGHT_PLANNING'],4) : '';
        $html .= '<td class="dt-cols-center">' . (($isLast) ? '<input type="text" value ="'.$val.'" style="width:45px;text-align:right;" name="'.$item['ID'].'_'.$i.'" class="item-value"  />' : '').'</td>';
      }

      $html .= '</tr>';
      $html .= $this->flatten_periode($item['SUB'], $week, $allTask, $budget);
    }

    return $html;
  }

  public function update_value($id)
  {
    $project     = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $item_list   = $this->builtbyprime->explicit('SELECT LEVEL,A.* FROM TBL_ITEM_TASK A WHERE A.ID_PROJECT = '.$id.' START WITH A.ID_PARENT = 0 CONNECT BY PRIOR A.ID = A.ID_PARENT ORDER SIBLINGS BY NAME');

    $start       = explode(' ',$project['START_DATE']); 
    $finish      = explode(' ',$project['FINISH_DATE']);
    $datediff    = strtotime($finish[0]) - strtotime($start[0]);
    $week        = floor(($datediff/(60*60*24))/7);

    $idplanning = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_PLANNING");
    $this->builtbyprime->insert('TBL_PROJECT_PLANNING',array('ID'=>$idplanning[0]['MAX'],'NAME'=>$project['NAME'],'ID_PROJECT'=>$id,'CREATED_BY'=>$this->session->userdata('USERNAME'),'MODIFIED_BY'=>$this->session->userdata('USERNAME')));
    $idprojectplanning = $this->builtbyprime->explicit("SELECT MAX(ID) MAX FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."' ");  
    
    for($i=1;$i<=$week;$i++)
    {
      foreach ($item_list as $row) 
      {
        if(isset($_POST[$row['ID'].'_'.$i]))
        {
          //cek planning parent
          //$planning = $this->builtbyprime->get('TBL_PROJECT_PLANNING', array('ID_PROJECT' => $id), TRUE);
          //if(!$planning)
          // {
            //create planning parent
            //$idplanning = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_PLANNING");
            //$this->builtbyprime->insert('TBL_PROJECT_PLANNING',array('ID'=>$idplanning[0]['MAX'],'NAME'=>$project['NAME'],'ID_PROJECT'=>$id));
          // }

          //get id planning parent
          //$idprojectplanning = $this->builtbyprime->explicit("SELECT MAX(ID) MAX FROM TBL_PROJECT_PLANNING WHERE ID_PROJECT = '".$id."' ");  

          //cek planning detail
          //$planningdetail = $this->builtbyprime->explicit('SELECT * from TBL_PROJECT_PLANNING_DETAIL WHERE ID_ITEM_TASK = '.$row['ID'].' and WEEK_NUMBER = '.$i.' and ID_PROJECT_PLANNING = '.$idprojectplanning[0]['MAX'].' ');
          //if($planningdetail)
          //{
          //update
          // $this->builtbyprime->update('TBL_PROJECT_PLANNING_DETAIL',array('ID_ITEM_TASK'=>$row['ID'],'WEEK_NUMBER'=>$i,'ID_PROJECT_PLANNING'=>$idprojectplanning[0]['MAX']),array('WEIGHT_PLANNING'=>$_POST[$row['ID'].'_'.$i]));
          //}
          //else
          //{
            if($_POST[$row['ID'].'_'.$i] != '')
            {
              //create
              $idplanningdetail = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_PLANNING_DETAIL");
              $this->builtbyprime->insert('TBL_PROJECT_PLANNING_DETAIL',array('ID'=>$idplanningdetail[0]['MAX'],'ID_ITEM_TASK'=>$row['ID'],'ID_PROJECT_PLANNING'=>$idprojectplanning[0]['MAX'],'WEEK_NUMBER'=>$i,'WEIGHT_PLANNING'=>$_POST[$row['ID'].'_'.$i]));
            }
          //}
        }
      }
    }


  }

  public function update_realization(){
    $data = Array(
      'a' => $this->input->post('supervisor-volume'),
      'b' => $this->input->post('vendor-volume'),
      'c' => $this->input->post('id-item-task'),
      'd' => $this->session->userdata('USERNAME'),
      'e' => $this->input->post('bobot-item'),
      'f' => $this->input->post('planning-item'),
      'g' => $this->input->post('realization-before') 
    );

    $return = false;

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET SUPERVISOR_PROGRESS_VOLUME = '" . $data['a'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
    } else if($this->session->userdata('ID_USER_TYPE') == 4) {
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET VENDOR_PROGRESS_VOLUME = '" . $data['b'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
    } else if($this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2){
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET SUPERVISOR_PROGRESS_VOLUME = '" . $data['a'] . "', VENDOR_PROGRESS_VOLUME = '" . $data['b'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
    }

    if($data['a']){
      $id = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK_TIME");
      $percentage = (($data['a'] - $data['g']) / $data['f']) * $data['e'];
      $resHistoryu = $this->builtbyprime->explicit("INSERT INTO TBL_ITEM_TASK_TIME (id, id_project, id_item_task, percentage, start_week, end_week, no_week, created_by, modified_by) VALUES (".$id[0]['MAX'].",".$this->input->post('id-project').",".$this->input->post('id-item-task').",".round($percentage, 4).", TO_DATE('".$this->input->post('start-week')."','dd/mm/yyyy'), TO_DATE('".$this->input->post('end-week')."','dd/mm/yyyy'), ".$this->input->post('week-number').", '".$this->session->userdata('USERNAME')."', '".$this->session->userdata('USERNAME')."')");
    }

    echo json_encode(Array('status' => 'ok', 'message' => $return));
  }

  public function add_comment(){
    $data = Array(
      'a' => $this->session->userdata('ID'),
      'b' => $this->input->post('comment'),
      'c' => $this->input->post('id-item-task'),
      'd' => $this->session->userdata('USERNAME'),
      'e' => $this->input->post('id-image-attachment')
    );

    $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_DISCUSSION");
    $ret = $this->builtbyprime->explicit("INSERT INTO TBL_DISCUSSION (id, id_item_task, post, id_user, created_by, modified_by) VALUES ('".$idItem[0]['MAX']."','".$data['c']."','".$data['b']."','".$data['a']."', '".$data['d']."', '".$data['d']."')");


    if($data['e']){
      $arrOfImages = explode(",", $data['e']);
      $idImage = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_DISCUSSION_ATTACHMENT_REL");

      foreach ($arrOfImages as $key => $value) {
        if($value != ''){
          $this->builtbyprime->insert('TBL_DISCUSSION_ATTACHMENT_REL', array('id' => $idImage[0]['MAX'], 'id_attachment' => $value, 'id_discussion' => $idItem[0]['MAX']));
          $idImage[0]['MAX']++;  
        }
      }
    }

    if($ret){
      echo json_encode(Array('status' => 'ok', 'data' => $data));
    } else {
      echo json_encode(Array());
    }
  }

  public function get_comment($idItemTask){
    $data = $this->builtbyprime->explicit("SELECT U.NAME, U.PROFILE_IMAGE_URL, D.*, TO_CHAR(CAST(D.CREATED_DATE AS DATE), 'DD/MM/YYYY HH:MI:SS') CREATED FROM TBL_DISCUSSION D, TBL_USER U WHERE D.ID_ITEM_TASK = '".$idItemTask."' AND D.ID_USER = U.ID ORDER BY D.ID DESC");
    
    foreach ($data as $key => $value) {
      $image = $this->builtbyprime->explicit("SELECT DAR.ID_DISCUSSION, DA.FILE_NAME, DA.FILE_URL, DA.ID FROM TBL_DISCUSSION_ATTACHMENT DA, TBL_DISCUSSION_ATTACHMENT_REL DAR WHERE DA.ID = DAR.ID_ATTACHMENT AND DAR.ID_DISCUSSION = '".$value['ID']."'");
      $data[$key]['images'] = $image; 
    }

    echo json_encode(Array('status' => 'ok', 'data' => $data));
  }

  public function add_attachment(){

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('image-attachment')){
      echo json_encode(array('error' => $this->upload->display_errors('<span>', '</span>')));
      exit();
    } else {
      $upload_data = $this->upload->data();
    }

    $id = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_DISCUSSION_ATTACHMENT");

    $data = array(
      'id' => $id[0]['MAX'],
      'file_name' => $upload_data['file_name'],
      'original_file_name' => $upload_data['orig_name'],
      'file_url' => '/uploads/',
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    $res = $this->builtbyprime->insert('TBL_DISCUSSION_ATTACHMENT', $data);

    echo json_encode($res);
  }

  /*
  Fungsi untuk mengiport file excel
  Terima file, parsing, dan input ke database.
  */
  public function import(){

    $data = Array(
      'id_project' => $this->input->post('id-project'),
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'xls|xlsx';
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);

    if(!file_exists($config['upload_path']))
      mkdir($config['upload_path'], 0777);

    if (!$this->upload->do_upload('import-file')){
      echo json_encode(array('error' => $this->upload->display_errors('<span>', '</span>')));
      exit();
    } else {
      $upload_data = $this->upload->data();    
    }

    $this->load->library('excel');

    $inputFileName = "./uploads/" . $upload_data['file_name'];

    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);

    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  
    $tmpId = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");
    $maxId = $tmpId[0]['MAX'];

    $tmpDtlId = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_PLANNING_DETAIL");
    $maxDtlId = $tmpDtlId[0]['MAX'];

    $tmpPlanId = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_PROJECT_PLANNING");
    $maxPlanId = $tmpPlanId[0]['MAX'];

    /* Tentukan Jumlah Minggu berdasarkan end date - start date Untuk validasi */
    $project = $this->builtbyprime->get('TBL_PROJECT', array('id' => $data['id_project']), TRUE);
    $Carbon = new Carbon\Carbon;

    $a = $Carbon::createFromFormat('d-M-y', $project['START_DATE']);
    $b = $Carbon::createFromFormat('d-M-y', $project['FINISH_DATE']); 
    $totalDays = $b->diffInDays($a);
    $realNumberWeek = ceil($totalDays/7);  

    /* data planning untuk di input ke TBL_PROJECT_PLANNING' */
    $planning = Array(
      'id' => $maxPlanId,
      'name' => 'Initial Planning',
      'id_project' => $data['id_project'],
      'created_by' => $this->session->userdata('USERNAME'),
      'modified_by' => $this->session->userdata('USERNAME')
    );
    $this->builtbyprime->insert('TBL_PROJECT_PLANNING', $planning);

    /* Inisialisasi utk data */
    $arrIdParents = Array(0 => 0);
    $successInsert = 0;
    $failedInsert = 0;
    $numberWeek = $sheetData[1]['I'] + 9;

    /* jika jumlah week pada excel kurang dari 1 atau bukan berformat integer */
    if($numberWeek < 1){
      echo json_encode(array('status' => 'not ok', 'message' => 'Jumlah perencanaan minggu harus lebih 0!'));
      exit();
    }

    /*jika jumlah alokasi tidak sama dengan jumalh minggu end date - start date proyek */
    if($sheetData[1]['I'] != $realNumberWeek){
      echo json_encode(array('status' => 'not ok', 'message' => 'Jumlah perencanan minggu tidak sama dengan jumlah alokasi waktu realisasi ('.$realNumberWeek.')!'));
      exit();
    }

    /* iterasi untuk setiap row dan dimasukan ke database */
    foreach ($sheetData as $key => $value) {
      if($key != 1){
        if($value['A'] == 'eof') break;

        $id = (string) $value['A'];
        $arrIdParents[$id] = $maxId; 

        $arrIds = explode(".", $id);

        if(count($arrIds) > 1){
          $parent = array_slice($arrIds, 0, count($arrIds) - 1);
          $idx = (string) implode(".", $parent);     
          $idParent = $arrIdParents[$idx];
        } else {
          $idParent = $arrIdParents["0"];
        }

        $taskItem = Array(
          'id' => $maxId,
          'id_parent' => $idParent,
          'id_project' => $data['id_project'],
          'name' => htmlspecialchars(str_replace("'", "''", $value['B'])),
          'specification' => htmlspecialchars(str_replace("'", "''", $value['C'])),
          'volume' => str_replace(",", "", $value['G']),
          'unit' => htmlspecialchars(str_replace("'", "''", $value['F'])),
          'unit_price' => str_replace(",", "", $value['H']),
          'created_by' => $this->session->userdata('USERNAME'),
          'modified_by' => $this->session->userdata('USERNAME')
        );

        for ($i=0; $i <= $numberWeek; $i++) { 
          if($i > 7 && current($value) !== null){
            $planningItem = Array(
              'id' => $maxDtlId,
              'id_item_task' => $maxId,
              'week_number' => $i - 8,
              'weight_planning' => current($value),
              'id_project_planning' => $maxPlanId
            );
            $this->builtbyprime->insert('TBL_PROJECT_PLANNING_DETAIL', $planningItem);

            $maxDtlId++;
          }
          next($value);
        }

        if($this->builtbyprime->insert('TBL_ITEM_TASK', $taskItem)){
          $successInsert++;
        } else {
          $failedInsert++;
        }
        $maxId++;
      }
    }

    $this->builtbyprime->update('TBL_PROJECT', Array('id' => $data['id_project']), Array('file_planning_url' => $upload_data['file_name']));

    echo json_encode(Array('status'=>"ok", "message" => "Jumlah baris sukses diimpor : " . $successInsert ."<br/> Gagal: " . $failedInsert));
  }


  public function export($id){
    $this->load->helper('download');

    $project = $this->builtbyprime->get('TBL_PROJECT', Array('id' => $id), TRUE);
    $data = file_get_contents("./uploads/" . $project['FILE_PLANNING_URL']);

    force_download($project['FILE_PLANNING_URL'], $data);
    // $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,TBL_ITEM_TASK.* FROM TBL_ITEM_TASK WHERE ID_PROJECT = '.$id.' START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY ID');
    // $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    // $data['id']           = $id;

    // $t = $this->genMulDimArr($data['item_list']);
    // $kosong = array();
    // $rows = $this->flatten($t, $data['project']['BUDGET'], $kosong);

    // print_r($rows);

    // $this->load->library('excel');

    // $objPHPExcel = new PHPExcel();
    // // Set document properties
    // $objPHPExcel->getProperties()->setCreator($this->session->userdata('USERNAME'))
    //   ->setLastModifiedBy($this->session->userdata('USERNAME'))
    //   ->setTitle("RAB " . $data['project']['NAME'])
    //   ->setSubject("RAB " . $data['project']['NAME']);

    // $objPHPExcel->setActiveSheetIndex(0)
    //   ->setCellValue('A1', 'No')
    //   ->setCellValue('B1', 'Uraian')
    //   ->setCellValue('C1', 'Spesifikasi')
    //   ->setCellValue('D1', 'No Gambar')
    //   ->setCellValue('E1', 'No RKS')
    //   ->setCellValue('F1', 'Satuan')
    //   ->setCellValue('G1', 'Volume')
    //   ->setCellValue('H1', 'Harga Satuan')
    //   ->setCellValue('I1', 'Bobot')
    //   ->setCellValue('J1', 'Jumlah');




    // // Redirect output to a client’s web browser (Excel5)
    // header('Content-Type: application/vnd.ms-excel');
    // header('Content-Disposition: attachment;filename="RAB_'.$data['project']['NAME'].'.xls"');
    // header('Cache-Control: max-age=0');
    // // If you're serving to IE 9, then the following may be needed
    // header('Cache-Control: max-age=1');
    // // If you're serving to IE over SSL, then the following may be needed
    // header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    // header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    // header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    // header ('Pragma: public'); // HTTP/1.0
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    // $objWriter->save('php://output');
    // exit;

  }

  public function flatten_export($arr, $budget, $outArr){

    foreach($arr as $item){ 
      array_push($outArr, $item);
      $this->flatten($item['SUB'], $budget, $outArr);
    
      // $style = ($item['LEVEL'] == 1 || $item['LEVEL'] == 2) ? 'style="font-weight:bold;"' : '';
      // $html .= '<tr '. $style . '>';
      // $html .= '<td>' . $item['NUMBER'] . '</td>';
      // $html .= '<td>' . (($item['LEVEL'] == 1) ? strtoupper($item['NAME']) : $item['NAME']) . '</td>';
      // $html .= '<td>' . (($isLast) ? $item['SPECIFICATION'] : '' ) . '</td>';
      // $html .= '<td class="dt-cols-center">' . (($isLast) ? $item['UNIT'] : '' ) . '</td>';
      // $html .= '<td class="dt-cols-right">' . (($isLast) ? $item['VOLUME'] : '') . '</td>';
      // $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'], 0,',','.') : '' ) . '</td>';
      // $html .= '<td class="dt-cols-right">' . (($isLast) ? round((($item['UNIT_PRICE'] * $item['VOLUME']) / $budget ) * 100, 3) : '' ) . '</td>';
      // $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'] * $item['VOLUME'], 0,',','.') : '' ) . '</td>';
      // $html .= '<td class="dt-cols-center">';
      // $html .=    '<a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="'. $item['ID'] .'"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;';
      // $html .=    '<a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="'. $item['ID'] .'"><i class="fa fa-trash-o"></i></a>';
      // $html .=  '</td>';
      // $html .= '</tr>';
      // $html .= $this->flatten($item['SUB'], $budget);
    }

    return $outArr;
  }


}
