<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('penjualan');
        if ($id != null) {
            $this->db->where('ID_PENJUALAN ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function tambahData($id_pengguna, $post)
    {
        $this->db->set('ID_DETAIL_SURAT_JALAN', htmlspecialchars($post['id_detail_surat_jalan'], true));
        $this->db->set('ID_PENGGUNA', $id_pengguna);
        $this->db->set('ID_PELANGGAN', htmlspecialchars($post['id_pelanggan'], true));
        $this->db->set('TGL_PENJUALAN', htmlspecialchars($post['tgl_penjualan'], true));
        $this->db->set('JUMLAH_PENJUALAN', htmlspecialchars($post['jumlah_penjualan'], true));
        $this->db->set('TOTAL_HARGA_PENJUALAN', htmlspecialchars($post['total_harga_penjualan'], true));
        $this->db->insert('penjualan');
    }


}

/* End of file pelanggan_m.php */
