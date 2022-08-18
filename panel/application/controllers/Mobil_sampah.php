<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobil_sampah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('_partials/head');
        $this->load->view('_partials/sidebar');
        $this->load->view('admin/mobil_sampah');
        $this->load->view('_partials/footer');
    }

    function simpan()
    {
        $merek       = $this->input->post('merek');
        $no_plat      = $this->input->post('no_plat');
        $lokasi       = $this->input->post('lokasi');

        $data = array(
            'MEREK' => $merek,
            'NO_PLAT' => $no_plat,
            'LOKASI' => $lokasi,
        );

        if ($this->db->insert('mobil_sampah', $data)) {
            $this->session->set_flashdata(array('notif' => 1));
        } else {
            $this->session->set_flashdata(array('notif' => 2));
        }
        redirect('mobil_sampah');
    }

    function edit($id)
    {
        $data['mobil_sampah'] = $this->db->query("SELECT * FROM mobil_sampah WHERE ID_MOBIL_SAMPAH= '$id'")->row();
        $this->load->view('_partials/head');
        $this->load->view('_partials/sidebar');
        $this->load->view('admin/mobil_sampah_edit', $data);
        $this->load->view('_partials/footer');
    }

    function update()
    {
        $id         = $this->input->post('id');
        $merek       = $this->input->post('merek');
        $no_plat      = $this->input->post('no_plat');
        $lokasi       = $this->input->post('lokasi');
        $status       = $this->input->post('status');

        $this->db->set('MEREK', htmlspecialchars($merek, true));
        $this->db->set('NO_PLAT', htmlspecialchars($no_plat, true));
        $this->db->set('LOKASI', htmlspecialchars($lokasi, true));
        $this->db->set('STATUS', htmlspecialchars($status, true));
        $this->db->where('ID_MOBIL_SAMPAH', $id);
        $result = $this->db->update('mobil_sampah');

        if ($result) {
            $this->session->set_flashdata(array('notif' => 1));
        } else {
            $this->session->set_flashdata(array('notif' => 2));
        }
        redirect('mobil_sampah');
    }

    function hapus($id_pengguna)
    {
        $id = $id_pengguna;
        if ($this->db->query("DELETE FROM mobil_sampah WHERE ID_MOBIL_SANMPAH = '$id'")) {
            $this->session->set_flashdata(array('notif' => 1));
            redirect('mobil_sampah');
        } else {
            $this->session->set_flashdata(array('notif' => 2));
            redirect('mobil_sampah');
        }
    }
}

/* End of file Mobil_sampah.php */
