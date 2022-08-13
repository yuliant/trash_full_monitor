<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_c extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('gudang/Supplier_m', 'supplier_m');
        $this->load->model('gudang/Satuan_m', 'satuan_m');
        $this->load->model('gudang/Barang_m', 'barang_m');
    }

    public function index($id_barang = null)
    {
        $data['title'] = "Daftar Barang";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
        $idps = $data['user']['ID_PERUSAHAAN'];
        if ($id_barang != null) {
            // $data['barang'] = $this->barang_m->TampilData($id_barang)->row();
            $data['barang'] = $this->db->query("
                SELECT * FROM barang b
                JOIN satuan st ON st.ID_SATUAN = b.ID_SATUAN
                JOIN supplier sp ON sp.ID_SUPPLIER = b.ID_SUPPLIER 
                JOIN pengguna p ON p.ID_PENGGUNA = b.ID_PENGGUNA  WHERE b.ID_BARANG = '$id_barang'")->row();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/barang/detail', $data);
            $this->load->view('templates/footer');
        } else {
            // $data['barang'] = $this->barang_m->TampilData()->result();
            $data['barang'] = $this->db->query("
                SELECT * FROM barang b
                JOIN satuan st ON st.ID_SATUAN = b.ID_SATUAN
                JOIN supplier sp ON sp.ID_SUPPLIER = b.ID_SUPPLIER 
                JOIN pengguna p ON p.ID_PENGGUNA = b.ID_PENGGUNA  WHERE p.ID_PERUSAHAAN = '$idps'")->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/barang/all', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Barang";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $data['supplier'] = $this->supplier_m->TampilData()->result();
        $data['satuan'] = $this->satuan_m->TampilData()->result();

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('stok_barang', 'Stok Barang', 'required|trim|numeric|max_length[11]');
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');
        $this->form_validation->set_rules('harga_beli_barang', 'Harga Beli Barang', 'required|trim|numeric|max_length[11]');
        $this->form_validation->set_rules('harga_jual_barang', 'Harga Jual Barang', 'required|trim|numeric|max_length[11]');
        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
        $this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/barang/add', $data);
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->barang_m->tambahData($id_pengguna, $post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil ditambahkan</div>');
            redirect('gudang/barang');
        }
    }

    public function ubah($id_barang)
    {
        $data['title'] = "Ubah Data Barang";
        $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

        $data['barang'] = $this->barang_m->TampilData($id_barang)->row();
        $data['supplier'] = $this->supplier_m->TampilData()->result();
        $data['satuan'] = $this->satuan_m->TampilData()->result();

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('stok_barang', 'Stok Barang', 'required|trim|numeric|max_length[11]');
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');
        $this->form_validation->set_rules('harga_beli_barang', 'Harga Beli Barang', 'required|trim|numeric|max_length[11]');
        $this->form_validation->set_rules('harga_jual_barang', 'Harga Jual Barang', 'required|trim|numeric|max_length[11]');
        //message
        $this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
        $this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
        $this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
        $this->form_validation->set_message('max_length', '%s anda terlalu panjang');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gudang/barang/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $post = $this->input->post(null, TRUE);
            $id_pengguna = $data['user']['ID_PENGGUNA'];
            $this->barang_m->ubahData($id_pengguna, $id_barang, $post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil diubah</div>');
            redirect('gudang/barang');
        }
    }

    public function hapus($id_barang)
    {
        $this->barang_m->hapusData($id_barang);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil dihapus</div>');
        redirect('gudang/barang');
    }
}

/* End of file Barang_c.php */