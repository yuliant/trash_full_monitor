<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil_m extends CI_Model
{
    public function ProfilSaya($id = null)
    {
        $this->db->select('
            ID_PENGGUNA,
            NAMA_PENGGUNA,
            EMAIL_PENGGUNA,
            FOTO_PENGGUNA,
            ID_HAK_AKSES
        ');
        $this->db->from('pengguna');
        if ($id != null) {
            $this->db->where('ID_PENGGUNA ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function ProfilSayaWithPassword($id = null)
    {
        $this->db->select('
            NAMA_PENGGUNA,
            EMAIL_PENGGUNA,
            FOTO_PENGGUNA,
            PASSWORD_PENGGUNA
        ');
        $this->db->from('pengguna');
        if ($id != null) {
            $this->db->where('ID_PENGGUNA ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function ubahProfil($id_pengguna, $nama_pengguna)
    {
        $this->db->set('NAMA_PENGGUNA', $nama_pengguna);
        $this->db->where('ID_PENGGUNA', $id_pengguna);
        $this->db->update('pengguna');
    }

    public function ubahProfilDanGambar($id_pengguna, $nama_pengguna, $gambar)
    {
        $this->db->set('NAMA_PENGGUNA', $nama_pengguna);
        $this->db->set('FOTO_PENGGUNA', $gambar);
        $this->db->where('ID_PENGGUNA', $id_pengguna);
        $this->db->update('pengguna');
    }
}

/* End of file Profil_m.php */
