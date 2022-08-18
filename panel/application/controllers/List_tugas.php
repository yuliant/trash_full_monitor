<?php
defined('BASEPATH') or exit('No direct script access allowed');

class List_tugas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('_partials/head');
        $this->load->view('_partials/sidebar');
        $this->load->view('admin/list_tugas');
        $this->load->view('_partials/footer');
    }

    function hapus($id_pengguna)
    {
        $id = $id_pengguna;
        if ($this->db->query("DELETE FROM list_tugas WHERE ID_LIST_TUGAS = '$id'")) {
            $this->session->set_flashdata(array('notif' => 1));
            redirect('list_tugas');
        } else {
            $this->session->set_flashdata(array('notif' => 2));
            redirect('list_tugas');
        }
    }
}

/* End of file List_tugas.php */
