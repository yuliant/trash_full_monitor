<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->from('supplier');
        if ($id != null) {
            $this->db->where('ID_SUPPLIER ', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function tambahData($id_pengguna, $post)
    {
        $this->db->set('ID_PENGGUNA ', $id_pengguna);
        $this->db->set('NAMA_SUPPLIER', htmlspecialchars($post['nama_supplier'], true));
        $this->db->set('EMAIL_SUPPLIER', htmlspecialchars($post['email_supplier'], true));
        $this->db->set('NO_HP_SUPPLIER', htmlspecialchars($post['no_hp_supplier'], true));
        $this->db->set('ALAMAT_SUPPLIER', htmlspecialchars($post['alamat_supplier'], true));
        $this->db->insert('supplier');
    }

    public function ubahData($id_pengguna, $id_supplier, $post)
    {
        $this->db->set('ID_PENGGUNA ', $id_pengguna);
        $this->db->set('NAMA_SUPPLIER', htmlspecialchars($post['nama_supplier'], true));
        $this->db->set('EMAIL_SUPPLIER', htmlspecialchars($post['email_supplier'], true));
        $this->db->set('NO_HP_SUPPLIER', htmlspecialchars($post['no_hp_supplier'], true));
        $this->db->set('ALAMAT_SUPPLIER', htmlspecialchars($post['alamat_supplier'], true));
        $this->db->where('ID_SUPPLIER', $id_supplier);
        $this->db->update('supplier');
    }

    public function hapusData($id_supplier)
    {
        $this->db->delete('supplier', ['ID_SUPPLIER' => $id_supplier]);
    }
}

/* End of file Supplier_m.php */
