<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_m extends CI_Model 
{
    public function TampilData($id = null)
    {
        $this->db->from('barang');
        if ($id != null) {
            $this->db->where('ID_BARANG', $id);
        }
        $query = $this->db->get();
        return $query;
    }
}

/* End of file Barang_m.php */
