<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pelanggan extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/sales/Daftar_pelanggan_m', 'daftar_pelanggan_m');
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() > 0) {
            $respon = [
                'status' => true,
                'message' => "Data berhasil didapatkan",
                'pelanggan' => $this->daftar_pelanggan_m->TampilData($id_pengguna)->result()
            ];
        }else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }

    public function tambah()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $cek_api_key = $this->api_m->CekApiKey($api_key);

        if ($cek_api_key->num_rows() > 0) {
            $data = [
                'id_pengguna' => htmlspecialchars($this->input->post('id_pengguna'), true),
                'nama_pelanggan' => htmlspecialchars($this->input->post('nama_pelanggan'), true),
                'email_pelanggan' => htmlspecialchars($this->input->post('email_pelanggan'), true),
                'no_hp_pelanggan' => htmlspecialchars($this->input->post('no_hp_pelanggan'), true),
                'alamat_pelanggan' => htmlspecialchars($this->input->post('alamat_pelanggan'), true)
            ];

            $this->daftar_pelanggan_m->TambahData($data);

            $respon = [
                'status' => true,
                'message' => "Data berhasil diinputkan"
            ];
        }else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }

    public function ubah()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $cek_api_key = $this->api_m->CekApiKey($api_key);

        if ($cek_api_key->num_rows() > 0) {
            $data = [
                'id_pelanggan' => htmlspecialchars($this->input->post('id_pelanggan'), true),
                'id_pengguna' => htmlspecialchars($this->input->post('id_pengguna'), true),
                'nama_pelanggan' => htmlspecialchars($this->input->post('nama_pelanggan'), true),
                'email_pelanggan' => htmlspecialchars($this->input->post('email_pelanggan'), true),
                'no_hp_pelanggan' => htmlspecialchars($this->input->post('no_hp_pelanggan'), true),
                'alamat_pelanggan' => htmlspecialchars($this->input->post('alamat_pelanggan'), true)
            ];

            $this->daftar_pelanggan_m->UbahData($data);

            $respon = [
                'status' => true,
                'message' => "Data berhasil diubah"
            ];
        }else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }

    public function hapus()
    {
        $id_pelanggan = htmlspecialchars($this->input->post('id_pelanggan'), true);
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() > 0) {

            $this->daftar_pelanggan_m->HapusData($id_pelanggan);

            $respon = [
                'status' => true,
                'message' => "Data berhasil dihapus"
            ];

        }else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }

}

/* End of file Daftar_pelanggan.php */
