<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_ulang_m extends CI_Model
{
	public function dataterakhir($id_pengguna)
	{
		return $this->db->query(
			"
                SELECT * FROM pesan_ulang pu 
                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PENGGUNA = '$id_pengguna'
                ORDER BY pu.ID_PESAN_ULANG DESC LIMIT 1
            "
		);
	}

	public function ambilData($id_pengguna = null)
	{
		return $this->db->query(
			"
                SELECT * FROM pesan_ulang pu 
                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PENGGUNA = '$id_pengguna'
                ORDER BY pu.ID_PESAN_ULANG DESC
                "
		);
	}

	public function ambilSatuDatabyIdPesanUlang($id_pesan_ulang = null)
	{
		return $this->db->query(
			"
                SELECT * FROM pesan_ulang pu 
                JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PESAN_ULANG = '$id_pesan_ulang'
                "
		)->row();
	}

	public function detailBarangPesanUlang($id_pesan_ulang = null)
	{
		return $this->db->query(
			"
                SELECT * FROM detail_pesan_ulang dpu 
                JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
                WHERE dpu.ID_PESAN_ULANG = '$id_pesan_ulang'
                ORDER BY dpu.ID_DETAIL_PESAN_ULANG DESC
                "
		)->result();
	}

	public function tambahDataPesanUlang($data)
	{
		$this->db->set('ID_PENGGUNA ', $data['ID_PENGGUNA']);
		$this->db->set('ID_PELANGGAN ', $data['ID_PELANGGAN']);
		$this->db->set('TGL_PESAN_ULANG ', $data['TGL_PESAN_ULANG']);
		$this->db->set('STATUS_PESAN_ULANG ', 0);
		$this->db->set('STATUS_PEMBAYARAN_PESAN_ULANG ', $data['STATUS_PEMBAYARAN_PESAN_ULANG']);
		$this->db->insert('pesan_ulang');
	}

	public function tambahDetailPesanUlang($data)
	{
		$this->db->set('ID_PESAN_ULANG ', $data['ID_PESAN_ULANG']);
		$this->db->set('ID_BARANG ', $data['ID_BARANG']);
		$this->db->set('JUMLAH_PESAN_ULANG ', $data['JUMLAH_PESAN_ULANG']);
		$this->db->set('HARGA_PESAN_ULANG ', $data['HARGA_PESAN_ULANG']);
		$this->db->insert('detail_pesan_ulang');
	}
}

/* End of file Pesan_ulang_m.php */
