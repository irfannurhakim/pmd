<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Builtbyprime extends CI_Model {

  public function get($a,$b=array(),$c=0){$d=$this->db->get_where($a,$b);$e=$d->result_array();if($c)return $e[0];return $e;}
 
  public function update($a,$b=array(),$c){$this->db->update($a,$c,$b);return $this->db->affected_rows();}
 
  public function insert($a,$b){$this->db->insert($a,$b);return $b;}
 
  public function delete($a,$b=array()){$this->db->delete($a,$b);return $this->db->affected_rows();}
 
  public function explicit($a){$b=$this->db->query($a);if(is_object($b))return $b->result_array();return $b;}

}