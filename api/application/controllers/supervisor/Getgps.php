<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Getgps extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $idpp = $this->session->userdata('idp');
        $data['title'] = 'Pelacakan';
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idp = $data['user']['ID_PERUSAHAAN'];
        // $data['sales'] = $this->db->get_where('pengguna', ['ID_HAK_AKSES' => '4', 'ATASAN_PENGGUNA' => '$idpp', 'ID_PERUSAHAAN' => $idp])->result();
        $data['sales'] = $this->db->query("SELECT * FROM pengguna WHERE ID_HAK_AKSES = '4' AND ATASAN_PENGGUNA = '$idpp' AND ID_PERUSAHAAN = '$idp'")->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('map/index', $data);
        $this->load->view('templates/footer');
    }

    public function map($idpengguna)
    {
        $data['idp'] = $idpengguna;
        $this->load->view('map/map', $data);
    }

    public function map2()
    {
        $data['idp'] = 'tes';
        $this->load->view('map/map2', $data);
    }
}

/* End of file Login   .php */
