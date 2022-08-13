<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
  public function getSubMenu(){
    $query = "SELECT sub_menu_pengguna.*, menu_pengguna.MENU_PENGGUNA
              FROM sub_menu_pengguna JOIN menu_pengguna
              ON sub_menu_pengguna.ID_MENU_PENGGUNA = menu_pengguna.ID_MENU_PENGGUNA ";
    return $this->db->query($query)->result_array();
  }

  public function deleteSubmenu($id){
    $this->db->where('ID_SUB_MENU_PENGGUNA', $id);
    $this->db->delete('sub_menu_pengguna');
  }
}
