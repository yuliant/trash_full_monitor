<?php
defined('BASEPATH') or exit('No direct script access allowed');

	class Dashboard extends CI_Controller{
		function __construct (){
			parent::__construct();
		}
		function index (){
			$this->load->view('_partials/head');
			$this->load->view('_partials/sidebar');
			$this->load->view('admin/dashboard');
			$this->load->view('_partials/footer');
		}
	}

?>