<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('_partials/head');
		$this->load->view('_partials/sidebar');
		$this->load->view('admin/petugas');
		$this->load->view('_partials/footer');
	}

	function edit($id)
	{
		$data['pengguna'] = $this->db->query("SELECT * FROM pengguna WHERE ID_PENGGUNA = '$id'")->row();
		$this->load->view('_partials/head');
		$this->load->view('_partials/sidebar');
		$this->load->view('admin/petugas_edit', $data);
		$this->load->view('_partials/footer');
	}

	function update()
	{
		$id 		= $this->input->post('id_petugas');
		$nama 		= $this->input->post('nama');
		$password 	= md5($this->input->post('password'));
		$nohp 		= $this->input->post('nohp');
		$jb 		= 'Petugas';

		$this->db->set('NAMA_PENGGUNA', htmlspecialchars($nama, true));
		if ($password) {
			$this->db->set('PASSWORD_PENGGUNA', htmlspecialchars($password, true));
		}
		$this->db->set('NOHP_PENGGUNA', htmlspecialchars($nohp, true));
		$this->db->set('JABATAN_PENGGUNA', htmlspecialchars($jb, true));
		$this->db->where('ID_PENGGUNA', $id);
		$result = $this->db->update('pengguna');

		if ($result) {
			$this->session->set_flashdata(array('notif' => 1));
		} else {
			$this->session->set_flashdata(array('notif' => 2));
		}
		redirect('petugas');
	}

	function simpan()
	{
		$nama 		= $this->input->post('nama');
		$email 		= $this->input->post('email');
		$password 	= md5($this->input->post('password'));
		$nohp 		= $this->input->post('nohp');
		$jb 		= 'Petugas';

		$data = array(
			'NAMA_PENGGUNA' => $nama,
			'EMAIL_PENGGUNA' => $email,
			'PASSWORD_PENGGUNA' => $password,
			'NOHP_PENGGUNA' => $nohp,
			'JABATAN_PENGGUNA' => $jb
		);

		if ($this->db->insert('pengguna', $data)) {
			$this->session->set_flashdata(
				array('notif' => 1)
			);
		} else {
			$this->session->set_flashdata(
				array('notif' => 2)
			);
		}
		redirect('petugas');
	}

	function hapus($id_pengguna)
	{
		$id = $id_pengguna;
		if ($this->db->query("DELETE FROM pengguna WHERE ID_PENGGUNA = '$id'")) {
			$this->session->set_flashdata(
				array('notif' => 1)
			);
			redirect('petugas');
		} else {
			$this->session->set_flashdata(
				array('notif' => 2)
			);
			redirect('petugas');
		}
	}
}
