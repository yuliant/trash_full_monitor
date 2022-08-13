<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verif_pesan_ulang_m extends CI_Model
{
    public function VerifPesanUlang($id_pesan_ulang)
    {
        $this->db->set('STATUS_PESAN_ULANG', 1);
        $this->db->where('ID_PESAN_ULANG', $id_pesan_ulang);
        $this->db->update('pesan_ulang');
    }

    public function TolakPesanUlang($id_pesan_ulang)
    {
        $this->db->set('STATUS_PESAN_ULANG', 2);
        $this->db->where('ID_PESAN_ULANG', $id_pesan_ulang);
        $this->db->update('pesan_ulang');
    }
}

/* End of file Verif_surat_jalan_m.php */
