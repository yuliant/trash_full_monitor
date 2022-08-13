<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pengembalian_m extends CI_Model
{
    public function ambilData($id_pengguna = null, $tgaw = null, $tgak = null)
    {
        return $this->db->query(
            "
            SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id_pengguna' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
            "
        );
    }
}

/* End of file Laporan_pengembalian_m.php */
