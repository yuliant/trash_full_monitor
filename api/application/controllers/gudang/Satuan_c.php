<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Satuan_c extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        is_logged_in();

        $this->load->model('gudang/Satuan_m', 'satuan_m');

    }



    public function index()

    {

        $data['title'] = "Daftar Satuan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();


        $idps = $data['user']['ID_PERUSAHAAN'];
        $data['satuan'] = $this->db->query("
                SELECT * FROM satuan st  
                JOIN pengguna p ON p.ID_PENGGUNA = st.ID_PENGGUNA  WHERE p.ID_PERUSAHAAN = '$idps'")->result();



        $this->load->view('templates/header', $data);

        $this->load->view('templates/sidebar', $data);

        $this->load->view('templates/topbar', $data);

        $this->load->view('gudang/satuan/all', $data);

        $this->load->view('templates/footer');

    }



    public function tambah()

    {

        $data['title'] = "Tambah Data Satuan";

        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();



        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim|max_length[50]');

        //message

        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');

        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);

            $this->load->view('templates/sidebar', $data);

            $this->load->view('templates/topbar', $data);

            $this->load->view('gudang/satuan/add', $data);

            $this->load->view('templates/footer');

        } else {

            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->satuan_m->tambahData($id_pengguna, $post);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data satuan berhasil ditambahkan</div>');

            redirect('gudang/satuan');

        }

    }
    public function hapus($id_satuan)
    {
        $this->satuan_m->hapusData($id_satuan);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data satuan berhasil dihapus</div>');
        redirect('gudang/satuan');
    }

}



/* End of file Satuan_c.php */

