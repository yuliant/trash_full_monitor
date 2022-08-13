<?php
	class Auth extends CI_controller {

		function __construct(){
			parent::__construct();
			// $this->load->model('model_login');
		} 
		function index ()
		{
			redirect('Auth/login');
		}
		function login (){
			if (isset($_POST['submit'])) {
			 	// proses login disini
			 	$email = $this->input->post('email');
			 	$password = md5($this->input->post('password'));
			 	$us = '';
			 	$hasil = $this->db->query("SELECT * FROM pengguna WHERE EMAIL_PENGGUNA = '$email' AND PASSWORD_PENGGUNA = '$password'")->result();
			 	foreach ($hasil as $k) {
			 		$id = $k->ID_PENGGUNA;	
			 		$em = $k->EMAIL_PENGGUNA;
			 		$nm = $k->NAMA_PENGGUNA;
			 		$us = $k->JABATAN_PENGGUNA;
			 	}	
			 	if ($us=='Administrator') {
			 		$this->session->set_userdata(
			 			array(
			 				'id'=>$id,
			 				'us'=>$us,
			 				'nm'=>$nm,
			 				'status_login'=>'oke'
			 			));
			 		redirect('dashboard');
			 	}elseif ($us=='Petugas'){
			 		$this->session->set_userdata(
			 			array(
			 				'id'=>$id,
			 				'us'=>$us,
			 				'nm'=>$nm,
			 				'status_login'=>'oke'
			 			));
			 		redirect('dashboard');
			 	}else{
			 		$this->session->set_userdata('notif','1');
			 		$this->load->view('login');
			 	}
			 		 	
			 }else{
			 	$this->load->view('login');
			 }  
		}

		function logout (){
			$this->session->sess_destroy();
			redirect('auth/login');
		}
	}
?>