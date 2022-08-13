<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('satuan');
        if ($id != null) {
            $this->db->where('ID_SATUAN ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function tambahData($id_pengguna, $post)
    {
        $this->db->set('ID_PENGGUNA ', $id_pengguna);
        $this->db->set('NAMA_SATUAN', htmlspecialchars($post['nama_satuan'], true));
        $this->db->insert('satuan');
    }

    public function ubahData($id_satuan, $post)
    {
        $this->db->set('NAMA_SATUAN', htmlspecialchars($post['nama_satuan'], true));
        $this->db->where('ID_SATUAN', $id_satuan);
        $this->db->update('satuan');
    }

    public function hapusData($id_satuan)
    {
        $this->db->delete('satuan', ['ID_SATUAN' => $id_satuan]);
    }
}

/* End of file Satuan_m.php */
