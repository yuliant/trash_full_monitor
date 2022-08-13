<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubah_password extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/pengguna/Profil_m', 'profil_m');
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);
        $current_password = htmlspecialchars($this->input->post('current_password'), true);
        $new_pasword1 = htmlspecialchars($this->input->post('new_pasword1'), true);
        $new_pasword2 = htmlspecialchars($this->input->post('new_pasword2'), true);
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $data = $this->profil_m->ProfilSayaWithPassword($id_pengguna)->row();
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
        
        if ($new_pasword1 != $new_pasword2) {
            $respon = [
                'status' => false,
                'message' => "Password tidak sama dengan konfirmasi password"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        if (!password_verify($current_password, $data->PASSWORD_PENGGUNA)) {
            $respon = [
                'status' => false,
                'message' => "Password tidak sama"
            ];
        }else {
            if ($current_password == $new_pasword1) {
                $respon = [
                    'status' => false,
                    'message' => "Password baru tidak boleh sama dengan password lama"
                ];
            } else {
                //password yang benar
                $password_hash = password_hash($new_pasword1, PASSWORD_DEFAULT);

                //update password
                $this->db->set('PASSWORD_PENGGUNA', $password_hash);
                $this->db->where('ID_PENGGUNA ', $id_pengguna);
                $this->db->update('pengguna');

                $respon = [
                    'status' => true,
                    'message' => "Password berhasil diubah"
                ];
            }
        }

        $json = json_encode($respon);
        echo $json;

    }

}

/* End of file Ubah_password.php */
