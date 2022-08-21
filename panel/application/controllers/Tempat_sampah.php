<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tempat_sampah extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$this->load->view('_partials/head');
		$this->load->view('_partials/sidebar');
		$this->load->view('admin/tempat_sampah');
		$this->load->view('_partials/footer');
	}

	function edit($id)
	{
		$data['tempat_sampah'] = $this->db->query("SELECT * from tempat_sampah WHERE ID_TEMPAT_SAMPAH = '$id'")->row();
		$this->load->view('_partials/head');
		$this->load->view('_partials/sidebar');
		$this->load->view('admin/tempat_sampah_edit', $data);
		$this->load->view('_partials/footer');
	}

	public function gps($id)
	{
		$data['tempat_sampah'] = $this->db->query("SELECT * from tempat_sampah WHERE ID_TEMPAT_SAMPAH = '$id'")->row();
		$this->load->view('admin/tempat_sampah_gps', $data);
	}

	function update()
	{
		$id 		= $this->input->post('id');
		$nama 		= $this->input->post('nama');
		$latitude 	= $this->input->post('latitude');
		$longitude 	= $this->input->post('longitude');
		$lokasi 	= $this->input->post('lokasi');

		$this->db->set('NAMA_TEMPAT_SAMPAH', htmlspecialchars($nama, true));
		$this->db->set('LONGITUDE', htmlspecialchars($longitude, true));
		$this->db->set('LATITUDE', htmlspecialchars($latitude, true));
		$this->db->set('LOKASI', htmlspecialchars($lokasi, true));
		$this->db->where('ID_TEMPAT_SAMPAH', $id);
		$result = $this->db->update('tempat_sampah');

		if ($result) {
			$this->session->set_flashdata(array('notif' => 1));
		} else {
			$this->session->set_flashdata(array('notif' => 2));
		}
		redirect('tempat_sampah');
	}

	function simpan()
	{
		$nama 	= $this->input->post('nama');
		$latitude 	= $this->input->post('latitude');
		$longitude 	= $this->input->post('longitude');
		$lokasi 	= $this->input->post('lokasi');

		$data = array(
			'NAMA_TEMPAT_SAMPAH' => $nama,
			'LONGITUDE' => $longitude,
			'LATITUDE' => $latitude,
			'LOKASI' => $lokasi
		);
		if ($this->db->insert('tempat_sampah', $data)) {
			$this->session->set_flashdata(array('notif' => 1));
		} else {
			$this->session->set_flashdata(array('notif' => 2));
		}
		redirect('tempat_sampah');
	}

	function hapus($id_lokasi)
	{
		$id = $id_lokasi;
		if ($this->db->query("DELETE FROM tempat_sampah WHERE ID_TEMPAT_SAMPAH = '$id'")) {
			$this->session->set_flashdata(
				array('notif' => 1)
			);
			redirect('tempat_sampah');
		} else {
			$this->session->set_flashdata(
				array('notif' => 2)
			);
			redirect('tempat_sampah');
		}
	}
}
