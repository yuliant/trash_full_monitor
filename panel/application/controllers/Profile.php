<?php
defined('BASEPATH') or exit('No direct script access allowed');

	class Profile extends CI_Controller{
		function __construct (){
			parent::__construct();
		}
		function index (){
			$this->load->view('_partials/head');
			$this->load->view('_partials/sidebar');
			$this->load->view('profile');
			$this->load->view('_partials/footer');
		}
		function password()
		{
			$pass1 = $this->input->post('pass1');
			$pass2 = $this->input->post('pass2');
			$pass3 = $this->input->post('pass3');
			$pass4 = md5($this->input->post('pass3'));
			$pass5 = md5($pass1);
			$idp = $this->session->userdata('id');
			
			if($pass2 == $pass3){

				$cek = $this->db->query("SELECT * FROM pengguna WHERE PASSWORD_PENGGUNA = '$pass5'");
				$jmldata = $cek->num_rows();
				if($jmldata > 0){
					$data = array(
					'PASSWORD_PENGGUNA' => $pass4
					);
					$this->db->where("ID_PENGGUNA", $idp);
			        $this->db->update("pengguna", $data);
						$this->session->set_flashdata(
			 			array('notif'=>1));
						redirect("profile");
				}else{
					$this->session->set_flashdata(
			 			array('notif'=>2));
					//redirect("profile");	
				}

			}else{
				$this->session->set_flashdata(
			 			array('notif'=>3));
				redirect("profile");
			}
		}
	}

?>