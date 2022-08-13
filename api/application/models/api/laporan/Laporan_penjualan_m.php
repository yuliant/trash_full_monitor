<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjualan_m extends CI_Model {

    public function tampilData($id_pengguna = null, $tgaw = null, $tgak = null)
    {
        return $this->db->query(
            "
            SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            WHERE pj.ID_PENGGUNA = '$id_pengguna' AND pj.TGL_PENJUALAN BETWEEN '$tgaw' AND '$tgak'
            "
        );
    }

}

/* End of file Laporan_penjualan_m.php */
