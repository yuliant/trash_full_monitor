<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_m', 'api_m');
    }

    public function tempat_sampah()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $tempat_sampah = $this->db->query("SELECT * FROM tempat_sampah")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'data' => $tempat_sampah
        ];
        $json = json_encode($respon);
        echo $json;
    }

    public function histori_tugas()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $tugas = $this->db->query("SELECT * FROM list_tugas WHERE ID_PENGGUNA = '$id_pengguna'")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'data' => $tugas
        ];
        $json = json_encode($respon);
        echo $json;
    }

    public function mobil_sampah()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $mobil_sampah = $this->db->query("SELECT * FROM mobil_sampah")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'data' => $mobil_sampah
        ];
        $json = json_encode($respon);
        echo $json;
    }
}

/* End of file Mobile.php */
