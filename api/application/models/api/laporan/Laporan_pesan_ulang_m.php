<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pesan_ulang_m extends CI_Model
{
    public function ambilData($id_pengguna = null, $tgaw = null, $tgak = null)
    {
        return $this->db->query(
            "
            SELECT * FROM pesan_ulang pu
            JOIN detail_pesan_ulang dpu ON dpu.ID_PESAN_ULANG = pu.ID_PESAN_ULANG
            JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
            WHERE pu.ID_PENGGUNA = '$id_pengguna' AND pu.TGL_PESAN_ULANG BETWEEN '$tgaw' AND '$tgak'
            "
        );
    }
}

/* End of file Laporan_pesan_ulang_m.php */
