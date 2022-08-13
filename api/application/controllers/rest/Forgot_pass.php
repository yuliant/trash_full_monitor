<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forgot_pass extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_m', 'api_m');
    }

    public function index()
    {
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);
        $email = $this->input->post('email');

        if (!$api_key || !$email) {
            $respon = [
                'status' => false,
                'message' => "Parameter not found"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }

        $user = $this->db->get_where('pengguna', [
            'EMAIL_PENGGUNA' => $email, 
            'STATUS_AKTIF_PENGGUNA' => 1,
            'ID_HAK_AKSES' => 4
            ])->row_array();
        //untuk mengecek apakah email yang dipost ada dan sudah diaktivasi di table user

        if ($user) {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'EMAIL' => $email,
                'TOKEN' => $token,
                'TGL_DIBUAT' => time()
            ];

            $this->db->insert('pengguna_token', $user_token);
            $this->_sendEmail($token, 'forgot', $email);

            $respon = [
                'status' => true,
                'message' => "Kode verifikasi berhasil dikirim, silahkan cek email anda"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }else {
            $respon = [
                'status' => true,
                'message' => "Data sales tidak ditemukan"
            ];
            $json = json_encode($respon);
            echo $json;
            die;
        }
    }

    private function _sendEmail($token, $type, $email)
    {
        $config = [
            'protocol'  => 'smtp',
            // 'smtp_host' => 'ssl://mail.mutiaract.com',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'coba16239@gmail.com',
            'smtp_pass' => 'coba12345',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config); // jika terjadi error di verifikasi smtp, tambahkan baris ini
        $this->email->set_mailtype("html");
        $this->email->from('coba16239@gmail.com', 'ILMea');
        $this->email->to($email);
        $mail = $email;
        $token_enc = urlencode($token);

        if ($type == 'verify') {
            $link = base_url() . 'auth/verify?email=' . $mail . '&token=' . $token_enc;
            $data = array(
                'link' => $link
            );
            $this->email->subject('Aktivasi akun');
            $body = $this->load->view('email/aktivasi.php', $data, TRUE);
            $this->email->message($body);
        } elseif ($type == 'forgot') {
            $link = base_url() . 'auth/resetpassword?email=' . $mail . '&token=' . $token_enc;
            $data = array(
                'link' => $link
            );
            $this->email->subject('Reset Password');
            $body = $this->load->view('email/lupa_password', $data, TRUE);
            $this->email->message($body);
        }

        if ($this->email->send()) {
            return true;
        } else {
            // echo $this->email->print_debugger();
            // die;
        }
    }
}

/* End of file Forgot_pass.php */
