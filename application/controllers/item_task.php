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
    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,TBL_ITEM_TASK.* FROM TBL_ITEM_TASK WHERE ID_PROJECT = '.$id.' START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME');
    $data['max_level']    = $this->builtbyprime->explicit('SELECT MAX(LEVEL) AS MAX FROM TBL_ITEM_TASK WHERE ID_PROJECT = 1 START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME');
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

  public function flatten($nav, $budget){
    $html = '';
    $isLast = false;

    foreach($nav as $page){
      if($page['SUB'] == null) {
        $isLast = true;
      } 

      $style = ($page['LEVEL'] == 1) ? 'style="font-weight:bold;"' : '';
      $html .= '<tr '. $style . '>';
      $html .= '<td>' . $page['NUMBER'] . '</td>';
      $html .= '<td>' . (($page['LEVEL'] == 1) ? strtoupper($page['NAME']) : $page['NAME']) . '</td>';
      $html .= '<td>' . (($isLast) ? $page['SPECIFICATION'] : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? $page['VOLUME'] : '') . '</td>';
      $html .= '<td class="dt-cols-center">' . (($isLast) ? $page['UNIT'] : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? $page['UNIT_PRICE'] : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? round((($page['UNIT_PRICE'] * $page['VOLUME']) / $budget ) * 100, 3) : '' ) . '</td>';
      $html .= '<td class="dt-cols-right">' . (($isLast) ? ($page['UNIT_PRICE'] * $page['VOLUME']) : '' ) . '</td>';
      $html .= '<td class="dt-cols-center">';
      $html .=    '<a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="'. $page['ID'] .'"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;';
      $html .=    '<a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="'. $page['ID'] .'"><i class="fa fa-trash-o"></i></a>';
      $html .=  '</td>';
      $html .= '</tr>';
      $html .= $this->flatten($page['SUB'], $budget);
    }

    return $html;
  }

   public function periode($id){ 
    $lvl2                 = $this->builtbyprime->get('TBL_ITEM_TASK', array('id_parent' => 0));
    $data['item_list']    = $this->builtbyprime->explicit('SELECT LEVEL,A.* FROM TBL_ITEM_TASK A WHERE A.ID_PROJECT = '.$id.' START WITH A.ID_PARENT = 0 CONNECT BY PRIOR A.ID = A.ID_PARENT ORDER SIBLINGS BY NAME');
    $data['max_level']    = $this->builtbyprime->explicit('SELECT MAX(LEVEL) AS MAX FROM TBL_ITEM_TASK WHERE ID_PROJECT = 1 START WITH ID_PARENT = 0 CONNECT BY PRIOR ID = ID_PARENT ORDER SIBLINGS BY NAME');
    $data['project']      = $this->builtbyprime->get('TBL_PROJECT', array('id' => $id), TRUE);
    $data['id']           = $id;

    $project              = $this->builtbyprime->explicit('select START_DATE,FINISH_DATE from TBL_PROJECT WHERE ID = '.$id.'');
    $start                = explode(' ',$project[0]['START_DATE']); 
    $finish               = explode(' ',$project[0]['FINISH_DATE']);
    $datediff             = strtotime($finish[0]) - strtotime($start[0]);
    $week                 = floor(($datediff/(60*60*24))/7);
    
    $html = '';
    for($i=1;$i<=$week;$i++)
    {
       $html .= '<th class="text-center">'.$i.'</th>';
    }
    $data['column'] = $html;
    $data['week']   = $week;

    $t            = $this->genMulDimArr($data['item_list']);
    $data['rows'] = $this->flatten_periode($t, $data['project']['BUDGET']);

    $this->load->view('item_task/periode', $data);
  }

   public function flatten_periode($nav, $budget){
    $html = '';
    $isLast = false;

    foreach($nav as $page){
      if($page['SUB'] == null) {
        $isLast = true;
      } 

    $project              = $this->builtbyprime->explicit('select START_DATE,FINISH_DATE from TBL_PROJECT WHERE ID = '.$page['ID_PROJECT'].'');
    $start                = explode(' ',$project[0]['START_DATE']); 
    $finish               = explode(' ',$project[0]['FINISH_DATE']);
    $datediff             = strtotime($finish[0]) - strtotime($start[0]);
    $week                 = floor(($datediff/(60*60*24))/7);

     $style = ($page['LEVEL'] == 1) ? 'style="font-weight:bold;"' : '';
     $html .= '<tr '. $style . '>';
     $html .= '<td>' . $page['NUMBER'] . '</td>';
     $html .= '<td>' . (($page['LEVEL'] == 1) ? strtoupper($page['NAME']) : $page['NAME']) . '</td>';
     $html .= '<td>' . (($isLast) ? $page['SPECIFICATION'] : '' ) . '</td>';

     for($i=1;$i<=$week;$i++)
     {
       $value = $this->builtbyprime->explicit('select * from TBL_ITEM_TASK_TIME where ID_ITEM_TASK = '.$page['ID'].' and NO_WEEK = '.$i.' ');
       $val   = ($value)? number_format($value[0]['PERCENTAGE']) : '';
       $html .= '<td class="dt-cols-center">
                '.(($isLast) ? '<input type="text" value ="'.$val.'" style="width:90px;text-align:right;" id="'.$page['ID'].'" week="'.$i.'" class="item-value"  />' : '').'</td>';
     }

     $html .= '</tr>';
     $html .= $this->flatten_periode($page['SUB'], $budget);
    }

    return $html;
  }

  function update_value()
  {
    $id      =$_GET['id'];
    $week    =$_GET['week'];
    $value   =str_replace(',','',$_GET['v']);

    $idItem = $this->builtbyprime->explicit("SELECT nvl(max(ID),0) + 1 max FROM TBL_ITEM_TASK_TIME");
    $exists = $this->builtbyprime->explicit('select * from TBL_ITEM_TASK_TIME where ID_ITEM_TASK = '.$id.' and NO_WEEK = '.$week.' ');
    if($exists)
    {
      $this->builtbyprime->update('TBL_ITEM_TASK_TIME',array('ID_ITEM_TASK'=>$id,'NO_WEEK'=>$week),array('PERCENTAGE'=>$value));
    }
    else
    {
      $this->builtbyprime->insert('TBL_ITEM_TASK_TIME',array('ID'=>$idItem[0]['MAX'],'ID_ITEM_TASK'=>$id,'NO_WEEK'=>$week,'PERCENTAGE'=>$value));
    }
  }

}
