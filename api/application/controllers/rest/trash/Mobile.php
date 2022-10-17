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

        $tempat_sampah = $this->db->query("SELECT * FROM tempat_sampah ORDER BY ID_TEMPAT_SAMPAH DESC")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'daftar_lokasi' => $tempat_sampah
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

        $this->db->select(
            'list_tugas.*, mobil_sampah.*, mobil_sampah.LOKASI as LOKASI_MOBIL_SAMPAH, tempat_sampah.*'
        );
        $this->db->from('list_tugas');
        $this->db->join('tempat_sampah', 'tempat_sampah.ID_TEMPAT_SAMPAH = list_tugas.ID_TEMPAT_SAMPAH', 'left');
        $this->db->join('mobil_sampah', 'mobil_sampah.ID_MOBIL_SAMPAH = list_tugas.ID_MOBIL_SAMPAH', 'left');
        $this->db->where('list_tugas.ID_PENGGUNA', $id_pengguna);
        $this->db->order_by("list_tugas.ID_LIST_TUGAS", "desc");
        $tugas = $this->db->get()->result();

        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'histori' => $tugas
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

        $mobil_sampah = $this->db->query("SELECT * FROM mobil_sampah ORDER BY ID_MOBIL_SAMPAH DESC")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'mobil_sampah' => $mobil_sampah
        ];
        $json = json_encode($respon);
        echo $json;
    }

    public function mobil_sampah_ready()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = ['status' => false, 'message' => "Error API Key"];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $mobil_sampah = $this->db->query("SELECT * FROM mobil_sampah WHERE status = 'ready' ORDER BY ID_MOBIL_SAMPAH DESC")->result();
        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'mobil_sampah_ready' => $mobil_sampah
        ];
        $json = json_encode($respon);
        echo $json;
    }

    public function home()
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

        $tempat_sampah = $this->db->query("SELECT * FROM tempat_sampah")->num_rows();
        $mobil_sampah = $this->db->query("SELECT * FROM mobil_sampah")->num_rows();

        $this->db->from('list_tugas');
        $this->db->where('ID_PENGGUNA', $id_pengguna);
        $tugas = $this->db->get()->num_rows();

        $respon = [
            'status' => true,
            'message' => "Data berhasil didapatkan",
            'home' => [
                "daftar_lokasi" => "$tempat_sampah",
                "histori" => "$tugas",
                "mobil" => "$mobil_sampah",
            ]
        ];
        $json = json_encode($respon);
        echo $json;
    }
}

/* End of file Mobile.php */
