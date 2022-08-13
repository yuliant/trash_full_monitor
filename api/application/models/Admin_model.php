<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
  public function deleteRole($id)
  {
    $this->db->where('ID_HAK_AKSES', $id);
    $this->db->delete('hak_akses');
  }
  public function deleteUser($id)
  {
    $this->db->where('ID_PENGGUNA', $id);
    $this->db->delete('pengguna');
  }
}
