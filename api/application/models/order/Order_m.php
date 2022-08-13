<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_m extends CI_Model
{
	public function update_kunjungan($data, $kode)
	{
		$this->db->where('KODE', $kode);
		$this->db->update('kunjungan', $data);
		return $this->db->affected_rows();
	}

	public function insert_kunjungan($data)
	{
		$this->db->insert('kunjungan', $data);
		return $this->db->affected_rows();
	}
}

/* End of file Order_m.php */
