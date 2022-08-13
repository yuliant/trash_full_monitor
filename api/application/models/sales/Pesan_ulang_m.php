<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_ulang_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('pesan_ulang');
        if ($id != null) {
            $this->db->where('ID_PESAN_ULANG ', $id);
        }
        $query = $this->db->get();
        return $query;
    }


    public function hapusData($id_surat_jalan)
    {
        $this->db->delete('surat_jalan', ['ID_SURAT_JALAN' => $id_surat_jalan]);
    }

    public function TampilDataDSJ($id = null)
    {
        $this->db->from('detail_surat_jalan');
        if ($id != null) {
            $this->db->where('ID_DETAIL_SURAT_JALAN ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function tambahDataDSJ($id_surat_jalan, $post)
    {
        $this->db->set('ID_SURAT_JALAN', $id_surat_jalan);
        $this->db->set('ID_BARANG', htmlspecialchars($post['id_barang'], true));
        $this->db->set('JUMLAH_BAWA', htmlspecialchars($post['jumlah_bawa'], true));
        $this->db->insert('detail_surat_jalan');
    }

    public function ubahDataDSJ($id_surat_jalan, $id_detail_surat_jalan, $post)
    {
        $this->db->set('ID_SURAT_JALAN', $id_surat_jalan);
        $this->db->set('ID_BARANG', htmlspecialchars($post['id_barang'], true));
        $this->db->set('JUMLAH_SISA', htmlspecialchars($post['jumlah_sisa'], true));
        $this->db->where('ID_DETAIL_SURAT_JALAN', $id_detail_surat_jalan);
        $this->db->update('detail_surat_jalan');
    }

    public function hapusDataDSJ($id_surat_jalan)
    {
        $this->db->delete('detail_surat_jalan', ['ID_DETAIL_SURAT_JALAN' => $id_surat_jalan]);
    }

    public function noSJ()
    {
        $query = $this->db->query("SELECT MAX(NO_SURAT_JALAN) as nsj from surat_jalan");
        $hasil = $query->row();
        return $hasil->nsj;
    }
}

/* End of file pelanggan_m.php */
