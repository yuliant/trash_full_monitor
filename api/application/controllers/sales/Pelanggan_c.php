<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Pelanggan_c extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        is_logged_in();

        $this->load->model('sales/Pelanggan_m', 'pelanggan_m');

    }



    public function index()

    {

        $data['title'] = "Daftar Pelanggan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $user2 = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $idpg = $user2['ID_PENGGUNA'];

        $data['pelanggan'] = $this->db->get_where('pelanggan', ['ID_PENGGUNA' => $idpg])->result();



        $this->load->view('templates/header', $data);

        $this->load->view('templates/sidebar', $data);

        $this->load->view('templates/topbar', $data);

        $this->load->view('sales/pelanggan/all', $data);

        $this->load->view('templates/footer');

    }



    public function tambah()

    {

        $data['title'] = "Tambah Data Pelanggan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim|max_length[50]');

        $this->form_validation->set_rules('email_pelanggan', 'Email Pelanggan', 'required|trim|valid_email|max_length[50]');

        $this->form_validation->set_rules('no_hp_pelanggan', 'No Hp Pelanggan', 'required|trim|numeric|min_length[8]|max_length[13]');

        $this->form_validation->set_rules('alamat_pelanggan', 'Alamat Pelanggan', 'required|trim|max_length[200]');



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

            $this->load->view('sales/pelanggan/add', $data);

            $this->load->view('templates/footer');

        } else {

            $post = $this->input->post(null, TRUE);

            $id_pengguna = $data['user']['ID_PENGGUNA'];

            $this->pelanggan_m->tambahData($id_pengguna, $post);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pelanggan berhasil ditambahkan</div>');

            redirect('sales/pelanggan');

        }

    }



    public function ubah($id_pelanggan)

    {

        $data['title'] = "Ubah Data Pelanggan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $id_pelanggan1 = decrypt_url($id_pelanggan);

        $data['pelanggan'] = $this->pelanggan_m->TampilData($id_pelanggan1)->row();



        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim|max_length[50]');

        $this->form_validation->set_rules('email_pelanggan', 'Email Pelanggan', 'required|trim|valid_email|max_length[50]');

        $this->form_validation->set_rules('no_hp_pelanggan', 'No Hp Pelanggan', 'required|trim|numeric|min_length[8]|max_length[13]');

        $this->form_validation->set_rules('alamat_pelanggan', 'Alamat Pelanggan', 'required|trim|max_length[200]');



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

            $this->load->view('sales/pelanggan/edit', $data);

            $this->load->view('templates/footer');

        } else {

            $id_pelanggan1 = $id_pelanggan;

            // echo $nama_pelanggan = $this->input->post("nama_pelanggan");
            // echo $email_pelanggan = $this->input->post("email_pelanggan");
            // echo $no_hp_pelanggan = $this->input->post("no_hp_pelanggan");
            // echo $alamat_pelanggan = $this->input->post("alamat_pelanggan");
            $post = $this->input->post(null, TRUE);

            $id_pengguna = $data['user']['ID_PENGGUNA'];

            $this->pelanggan_m->ubahData($id_pengguna, $id_pelanggan1, $post);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pelanggan berhasil diubah</div>');

            redirect('sales/pelanggan');

        }

    }



    public function hapus($id_pelanggan)

    {

        $id_pelanggan1 = decrypt_url($id_pelanggan);

        $this->pelanggan_m->hapusData($id_pelanggan1);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data pelanggan berhasil dihapus</div>');

        redirect('sales/pelanggan');

    }

}



/* End of file Supplier_c.php */

