<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['mobil'] = $this->db->query("SELECT * from mobil_sampah")->num_rows();
		$data['mobil_ready'] = $this->db->query("SELECT * from mobil_sampah WHERE STATUS = 'ready'")->num_rows();
		$data['mobil_dipakai'] = $this->db->query("SELECT * from mobil_sampah WHERE STATUS = 'dipakai'")->num_rows();
		$data['mobil_service'] = $this->db->query("SELECT * from mobil_sampah WHERE STATUS = 'service'")->num_rows();

		$data['petugas'] = $this->db->query("SELECT * from pengguna WHERE JABATAN_PENGGUNA = 'Petugas'")->num_rows();
		$data['tempat_sampah'] = $this->db->query("SELECT * from tempat_sampah")->num_rows();

		$this->load->view('_partials/head');
		$this->load->view('_partials/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('_partials/footer');
	}
}
