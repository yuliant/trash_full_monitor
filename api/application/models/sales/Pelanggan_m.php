<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('pelanggan');
        if ($id != null) {
            $this->db->where('ID_PELANGGAN ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function tambahData($id_pengguna, $post)
    {
        $this->db->set('ID_PENGGUNA', $id_pengguna);
        $this->db->set('NAMA_PELANGGAN', htmlspecialchars($post['nama_pelanggan'], true));
        $this->db->set('EMAIL_PELANGGAN', htmlspecialchars($post['email_pelanggan'], true));
        $this->db->set('NO_HP_PELANGGAN', htmlspecialchars($post['no_hp_pelanggan'], true));
        $this->db->set('ALAMAT_PELANGGAN', htmlspecialchars($post['alamat_pelanggan'], true));
        $this->db->insert('pelanggan');
    }

    public function ubahData($id_pengguna, $id_pelanggan, $post)
    {
        $this->db->set('ID_PENGGUNA', $id_pengguna);
        $this->db->set('NAMA_PELANGGAN', htmlspecialchars($post['nama_pelanggan'], true));
        $this->db->set('EMAIL_PELANGGAN', htmlspecialchars($post['email_pelanggan'], true));
        $this->db->set('NO_HP_PELANGGAN', htmlspecialchars($post['no_hp_pelanggan'], true));
        $this->db->set('ALAMAT_PELANGGAN', htmlspecialchars($post['alamat_pelanggan'], true));
        $this->db->where('ID_PELANGGAN', $id_pelanggan);
        $this->db->update('pelanggan');
    }

    public function hapusData($id_pelanggan)
    {
        $this->db->delete('pelanggan', ['ID_PELANGGAN' => $id_pelanggan]);
    }
}

/* End of file pelanggan_m.php */
