<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verif_surat_jalan_m extends CI_Model
{
    public function VerifSuratJalan($id_surat_jalan)
    {
        $this->db->set('STATUS_SURAT_JALAN', 1);
        $this->db->where('ID_SURAT_JALAN', $id_surat_jalan);
        $this->db->update('surat_jalan');
    }

    public function TolakSuratJalan($id_surat_jalan)
    {
        $this->db->set('STATUS_SURAT_JALAN', 2);
        $this->db->where('ID_SURAT_JALAN', $id_surat_jalan);
        $this->db->update('surat_jalan');
    }
}

/* End of file Verif_surat_jalan_m.php */
