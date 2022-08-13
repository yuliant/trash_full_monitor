<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home_m extends CI_Model
{
	public function belumDikunjungi($date, $id)
	{
		$this->db->from('kunjungan');
		$this->db->where('DATE(TGL_KUNJUNGAN)', $date);
		$this->db->where('ID_PENGGUNA', $id);
		$this->db->where('STATUS_KUNJUNGAN', 0);
		$this->db->order_by('ID_KUNJUNGAN', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function telahDikunjungi($date, $id)
	{
		$this->db->from('kunjungan');
		$this->db->where('DATE(TGL_KUNJUNGAN)', $date);
		$this->db->where('ID_PENGGUNA', $id);
		$this->db->where('STATUS_KUNJUNGAN', 1);
		$this->db->order_by('ID_KUNJUNGAN', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function historyBulanan($month, $id)
	{
		$this->db->from('kunjungan');
		$this->db->where("month(TGL_KUNJUNGAN)", $month);
		$this->db->where('ID_PENGGUNA', $id);
		$this->db->where('STATUS_KUNJUNGAN ', 1);
		$this->db->order_by('ID_KUNJUNGAN', 'desc');
		$query = $this->db->get();
		return $query;
	}
}

/* End of file Home_m.php */
