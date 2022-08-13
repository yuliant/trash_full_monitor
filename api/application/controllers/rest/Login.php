<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Login_m', 'login');
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $data = [
            'email' => htmlspecialchars($this->input->post('email'), true),
            'password' => htmlspecialchars($this->input->post('password'), true),
        ];

        if (!$api_key || !$data) {
            $respon = [
                'status' => false,
                'message' => "Parameter not fount"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() == 0) {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $query = $this->login->login($data);
        $row = $this->login->setLogin($data);

        if ($query->num_rows() > 0) {

            if (password_verify($data['password'], $query->row()->PASSWORD_PENGGUNA)) {
                if ($row->row()->ID_HAK_AKSES == '4') {
                    $respon = [
                        'status' => true,
                        'message' => "Data berhasil didapatkan",
                        'data' => $row->row()
                    ];
                } else {
                    $respon = [
                        'status' => false,
                        'message' => "Akun anda tidak memiliki akses untuk aplikasi ini."
                    ];
                }
            } else {
                $respon = [
                    'status' => false,
                    'message' => "Email dan password yang anda masukkan salah"
                ];
            }
        } else {
            $respon = [
                'status' => false,
                'message' => "Email yang anda masukkan belum terdaftar"
            ];
        }

        $json = json_encode($respon);
        echo $json;
    }
}

/* End of file Login   .php */
