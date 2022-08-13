<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Barang_m', 'barang_m');
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() > 0) {
            $respon = [
                'status' => true,
                'message' => "Data berhasil didapatkan",
                'barang' => $this->barang_m->TampilData()->result()
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

/* End of file Barang.php */
