<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pelanggan_m extends CI_Model 
{
    public function TampilData($id_pengguna = null)
    {
        $this->db->from('pelanggan');
        if ($id_pengguna != null) {
            $this->db->where('ID_PENGGUNA ', $id_pengguna);
        }
        $this->db->order_by("ID_PELANGGAN", "DESC");
        $query = $this->db->get();
        return $query;
    }

    public function TambahData($data)
    {
        $this->db->set('ID_PENGGUNA', $data['id_pengguna']);
        $this->db->set('NAMA_PELANGGAN', $data['nama_pelanggan']);
        $this->db->set('EMAIL_PELANGGAN', $data['email_pelanggan']);
        $this->db->set('NO_HP_PELANGGAN', $data['no_hp_pelanggan']);
        $this->db->set('ALAMAT_PELANGGAN', $data['alamat_pelanggan']);
        $this->db->insert('pelanggan');
    }

    public function UbahData($data)
    {
        $this->db->set('ID_PENGGUNA', $data['id_pengguna']);
        $this->db->set('NAMA_PELANGGAN', $data['nama_pelanggan']);
        $this->db->set('EMAIL_PELANGGAN', $data['email_pelanggan']);
        $this->db->set('NO_HP_PELANGGAN', $data['no_hp_pelanggan']);
        $this->db->set('ALAMAT_PELANGGAN', $data['alamat_pelanggan']);
        $this->db->where('ID_PELANGGAN', $data['id_pelanggan']);
        $this->db->update('pelanggan');
    }

    public function HapusData($id_pelanggan)
    {
        $this->db->where('ID_PELANGGAN', $id_pelanggan);
        $this->db->delete('pelanggan');
    }

}

/* End of file Daftar_pelanggan_m.php */
