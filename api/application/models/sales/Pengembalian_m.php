<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('pengembalian');
        if ($id != null) {
            $this->db->where('ID_PENGEMBALIAN ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

}

/* End of file pelanggan_m.php */
