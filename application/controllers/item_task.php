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
      'g' => $this->input->post('unit_price'),
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

  public function project($id){ 
    $lvl2                 = $this->builtbyprime->get('TBL_ITEM_TASK', array('id_parent' => 0));
    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,TBL_ITEM_TASK.* FROM TBL_ITEM_TASK WHERE ID_PROJECT = '.$id.' START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY ID');
    $data['max_level']    = $this->builtbyprime->explicit('SELECT MAX(LEVEL) AS MAX FROM TBL_ITEM_TASK WHERE ID_PROJECT = 1 START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY ID');
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
      $html .= '<td class="dt-cols-right">' . (($isLast) ? $item['VOLUME'] : '') . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'], 0,',','.') : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? round((($item['UNIT_PRICE'] * $item['VOLUME']) / $budget ) * 100, 3) : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? number_format($item['UNIT_PRICE'] * $item['VOLUME'], 0,',','.') : '' ) . '</td>';
      $html .= '<td class="dt-cols-center">';
      $html .=    '<a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="'. $item['ID'] .'"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;';
      $html .=    '<a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="'. $item['ID'] .'"><i class="fa fa-trash-o"></i></a>';
      $html .=  '</td>';
      $html .= '</tr>';
      $html .= $this->flatten($item['SUB'], $budget);
    }

    return $html;
  }

  public function update_realization(){
    $data = Array(
      'a' => $this->input->post('supervisor-volume'),
      'b' => $this->input->post('vendor-volume'),
      'c' => $this->input->post('id-item-task'),
      'd' => $this->session->userdata('USERNAME')
    );

    $return = false;

    if($this->session->userdata('ID_USER_TYPE') == 3){
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET SUPERVISOR_PROGRESS_VOLUME = '" . $data['a'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
    } else if($this->session->userdata('ID_USER_TYPE') == 4) {
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET VENDOR_PROGRESS_VOLUME = '" . $data['b'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
    } else if($this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2){
      $return = $this->builtbyprime->explicit("UPDATE TBL_ITEM_TASK SET SUPERVISOR_PROGRESS_VOLUME = '" . $data['a'] . "', VENDOR_PROGRESS_VOLUME = '" . $data['b'] . "', MODIFIED_BY = '".$data['d']."', MODIFIED_DATE = SYSDATE WHERE ID = " . $data['c']);
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
    $data = $this->builtbyprime->explicit("SELECT U.NAME, D.*, TO_CHAR(CAST(D.CREATED_DATE AS DATE), 'DD/MM/YYYY HH:MI:SS') CREATED FROM TBL_DISCUSSION D, TBL_USER U WHERE D.ID_ITEM_TASK = '".$idItemTask."' AND D.ID_USER = U.ID ORDER BY D.ID DESC");
    
    foreach ($data as $key => $value) {
      $image = $this->builtbyprime->explicit("SELECT DAR.ID_DISCUSSION, DA.FILE_NAME, DA.FILE_URL, DA.ID FROM TBL_DISCUSSION_ATTACHMENT DA, TBL_DISCUSSION_ATTACHMENT_REL DAR WHERE DA.ID = DAR.ID_ATTACHMENT AND DAR.ID_DISCUSSION = '".$value['ID']."'");
      $data[$key]['images'] = $image; 
    }

    echo json_encode(Array('status' => 'ok', 'data' => $data));
  }

  public function edit_comment(){

  }

  public function delete_comment(){

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

    if(count($sheetData[1]) != 8){
      echo json_encode(Array('status'=>'not ok', 'message'=> 'Wrong file format'));
      exit();
    }
    
    $tmpId = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK");
    $maxId = $tmpId[0]['MAX'];

    $arrIdParents = Array(0 => 0);

    $successInsert = 0;
    $failedInsert = 0;

    foreach ($sheetData as $key => $value) {
      if($key != 1){
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

        if($this->builtbyprime->insert('TBL_ITEM_TASK', $taskItem)){
          $successInsert++;
        } else {
          $failedInsert++;
        }

        $maxId++;
      }
    }

    echo json_encode(Array('status'=>"ok", "message" => "Jumlah baris sukses diimpor : " . $successInsert ."<br/> Gagal: " . $failedInsert));
  }
}
