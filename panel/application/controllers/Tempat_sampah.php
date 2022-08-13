<?php
defined('BASEPATH') or exit('No direct script access allowed');

	class Tempat_sampah extends CI_Controller{
		function __construct (){
			parent::__construct();
		}
		function index (){
			$this->load->view('_partials/head');
			$this->load->view('_partials/sidebar');
			$this->load->view('admin/tempat_sampah');
			$this->load->view('_partials/footer');
		}

		function simpan()
		{
			$latitude 	= $this->input->post('latitude');
			$longitude 	= $this->input->post('longitude');
			$lokasi 	= $this->input->post('lokasi');

			$data = array(
			'LONGITUDE' => $longitude,
			'LATITUDE' => $latitude,
			'LOKASI' => $lokasi
			);
			if($this->db->insert('tempat_sampah',$data)){
				$this->session->set_flashdata(
			 			array('notif'=>1));
			}else{
				$this->session->set_flashdata(
			 			array('notif'=>2));
			}
			redirect('tempat_sampah');


		}

		function hapus($id_lokasi)
		{
			$id = $id_lokasi;
			if($this->db->query("DELETE FROM tempat_sampah WHERE ID_TEMPAT_SAMPAH = '$id'")){
				$this->session->set_flashdata(
			 			array('notif'=>1));
				redirect('tempat_sampah');
			}else{
				$this->session->set_flashdata(
			 			array('notif'=>2));
				redirect('tempat_sampah');
			}
		}
	}

?>