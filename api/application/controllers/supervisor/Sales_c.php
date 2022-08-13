<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('gudang/Supplier_m', 'supplier_m');
        $this->load->model('gudang/Satuan_m', 'satuan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
    }

    public function index()
    {
        $data['title'] = "Daftar Sales";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idps = $data['user']['ID_PERUSAHAAN'];
            $data['sales'] = $this->db->query("
                SELECT * FROM pengguna p LEFT JOIN wilayah w ON w.ID_WILAYAH = p.ID_WILAYAH WHERE p.ID_HAK_AKSES = '4' ")->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('supervisor/sales/all', $data);
            $this->load->view('templates/footer');
    }

}

/* End of file Barang_c.php */