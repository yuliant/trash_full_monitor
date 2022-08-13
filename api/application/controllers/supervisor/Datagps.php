<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datagps extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($idpengguna)
    {
        $data['title'] = 'Pelacakan';
        $idp = $idpengguna;
        $data['id_pengguna'] = $idpengguna;
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        // $this->load->view('map/datamap/index', $data);
        $data['idp'] = $idpengguna;
        $this->load->view('map/map_here', $data);
        $this->load->view('templates/footer');
    }

    public function getmap2()
    {
        $data['title'] = 'Pelacakan';
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('map/datamap/index2', $data);
        $this->load->view('templates/footer');
    }
}

/* End of file Login   .php */
