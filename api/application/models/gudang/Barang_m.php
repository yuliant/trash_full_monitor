<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_m extends CI_Model
{
    public function TampilData($id = null)
    {
        $this->db->select(
            'barang.*, 
            supplier.ID_SUPPLIER, 
            supplier.NAMA_SUPPLIER, 
            satuan.ID_SATUAN,
            satuan.NAMA_SATUAN'
        );
        $this->db->from('barang');
        $this->db->join('supplier', 'supplier.ID_SUPPLIER = barang.ID_SUPPLIER', 'left');
        $this->db->join('satuan', 'satuan.ID_SATUAN = barang.ID_SATUAN', 'left');

        if ($id != null) {
            $this->db->where('barang.ID_BARANG', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function tambahData($id_pengguna, $post)
    {
        $this->db->set('ID_PENGGUNA ', $id_pengguna);
        $this->db->set('ID_SUPPLIER', htmlspecialchars($post['nama_supplier'], true));
        $this->db->set('ID_SATUAN', htmlspecialchars($post['nama_satuan'], true));
        $this->db->set('NAMA_BARANG', htmlspecialchars($post['nama_barang'], true));
        $this->db->set('STOK_BARANG', htmlspecialchars($post['stok_barang'], true));
        $this->db->set('HARGA_BELI_BARANG', htmlspecialchars($post['harga_beli_barang'], true));
        $this->db->set('HARGA_JUAL_BARANG', htmlspecialchars($post['harga_jual_barang'], true));
        $this->db->insert('barang');
    }

    public function ubahData($id_pengguna, $id_barang, $post)
    {
        $this->db->set('ID_PENGGUNA ', $id_pengguna);
        $this->db->set('ID_SUPPLIER', htmlspecialchars($post['nama_supplier'], true));
        $this->db->set('ID_SATUAN', htmlspecialchars($post['nama_satuan'], true));
        $this->db->set('NAMA_BARANG', htmlspecialchars($post['nama_barang'], true));
        $this->db->set('STOK_BARANG', htmlspecialchars($post['stok_barang'], true));
        $this->db->set('HARGA_BELI_BARANG', htmlspecialchars($post['harga_beli_barang'], true));
        $this->db->set('HARGA_JUAL_BARANG', htmlspecialchars($post['harga_jual_barang'], true));
        $this->db->where('ID_BARANG', $id_barang);
        $this->db->update('barang');
    }

    public function hapusData($id_barang)
    {
        $this->db->delete('barang', ['ID_BARANG ' => $id_barang]);
    }
}

/* End of file Barang_m.php */
