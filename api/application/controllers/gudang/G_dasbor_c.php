<?php
defined('BASEPATH') or exit('No direct script access allowed');

class G_dasbor_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index($id_barang = null)
    {

        $data['title'] = 'Dasbor';
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/dasbor', $data);
            $this->load->view('templates/footer');
    }

}

/* End of file Barang_c.php */