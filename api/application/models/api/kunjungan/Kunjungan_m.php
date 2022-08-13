<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjungan_m extends CI_Model
{
    public function addKunjungan($id_kunjungan, $keterangan_kunjungan, $lat, $long, $gambar)
    {
        $this->db->set('KETERANGAN_KUNJUNGAN', $keterangan_kunjungan);
        $this->db->set('LATITUDE_KUNJUNGAN', $lat);
        $this->db->set('LONGITUDE_KUNJUNGAN', $long);
        $this->db->set('BUKTI_KUNJUNGAN', $gambar);
        $this->db->set('STATUS_KUNJUNGAN', 1);
        $this->db->where('ID_KUNJUNGAN', $id_kunjungan);
        $this->db->update('kunjungan');
    }

    public function addAksesCepat($id_pengguna, $nama_kunjungan, $alamat_kunjungan, $no_telp_kunjungan, $keterangan_kunjungan, $tgl, $lat, $long, $gambar)
    {
        $this->db->set('ID_PENGGUNA', $id_pengguna);
        $this->db->set('NAMA_KUNJUNGAN', $nama_kunjungan);
        $this->db->set('ALAMAT_KUNJUNGAN', $alamat_kunjungan);
        $this->db->set('NO_TELP_KUNJUNGAN', $no_telp_kunjungan);
        $this->db->set('KETERANGAN_KUNJUNGAN', $keterangan_kunjungan);
        $this->db->set('TGL_KUNJUNGAN', $tgl);
        $this->db->set('LATITUDE_KUNJUNGAN', $lat);
        $this->db->set('LONGITUDE_KUNJUNGAN', $long);
        $this->db->set('BUKTI_KUNJUNGAN', $gambar);
        $this->db->set('STATUS_KUNJUNGAN', 1);
        $this->db->insert('kunjungan');
    }

    public function showKunjungan($id_pengguna, $tgaw, $tgak)
    {
        return $this->db->query(
            "
            SELECT * FROM kunjungan
            WHERE ID_PENGGUNA = '$id_pengguna' 
			AND STATUS_KUNJUNGAN = 1
			AND DATE(TGL_KUNJUNGAN) >= '$tgaw' AND DATE(TGL_KUNJUNGAN) <='$tgak'
			ORDER BY ID_KUNJUNGAN  DESC
            "
        );
    }
}

/* End of file Kunjungan_m.php */
