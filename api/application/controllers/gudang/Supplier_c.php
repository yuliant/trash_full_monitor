<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('gudang/Supplier_m', 'supplier_m');
    }

    public function index()
    {
        $data['title'] = "Daftar Supplier";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idps = $data['user']['ID_PERUSAHAAN'];
        // $data['supplier'] = $this->supplier_m->TampilData()->result();
        $data['supplier'] = $this->db->query("
                SELECT * FROM supplier sp  
                JOIN pengguna p ON p.ID_PENGGUNA = sp.ID_PENGGUNA  WHERE p.ID_PERUSAHAAN = '$idps'")->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gudang/supplier/all', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Supplier";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email_supplier', 'Email Supplier', 'required|trim|valid_email|max_length[50]');
        $this->form_validation->set_rules('no_hp_supplier', 'No Hp Supplier', 'required|trim|numeric|min_length[8]|max_length[13]');
        $this->form_validation->set_rules('alamat_supplier', 'Alamat Supplier', 'required|trim|max_length[200]');

        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
        $this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
        $this->form_validation->set_message('min_length', '%s anda terlalu pendek');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/supplier/add', $data);
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->supplier_m->tambahData($id_pengguna, $post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data supplier berhasil ditambahkan</div>');
            redirect('gudang/supplier');
        }
    }

    public function ubah($id_supplier)
    {
        $data['title'] = "Ubah Data Supplier";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $data['supplier'] = $this->supplier_m->TampilData($id_supplier)->row();

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email_supplier', 'Email Supplier', 'required|trim|valid_email|max_length[50]');
        $this->form_validation->set_rules('no_hp_supplier', 'No Hp Supplier', 'required|trim|numeric|min_length[8]|max_length[13]');
        $this->form_validation->set_rules('alamat_supplier', 'Alamat Supplier', 'required|trim|max_length[200]');

        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
        $this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
        $this->form_validation->set_message('min_length', '%s anda terlalu pendek');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/supplier/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->supplier_m->ubahData($id_pengguna, $id_supplier, $post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data supplier berhasil diubah</div>');
            redirect('gudang/supplier');
        }
    }

    public function hapus($id_supplier)
    {
        $this->supplier_m->hapusData($id_supplier);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data supplier berhasil dihapus</div>');
        redirect('gudang/supplier');
    }
}

/* End of file Supplier_c.php */
