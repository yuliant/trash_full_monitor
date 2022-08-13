<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
		$this->load->library('form_validation'); // untuk memvalidasi inputan
	}

	public function index()
	{
		if ($this->session->userdata('email')) { //penge checkan apabila sdh login tidak bisa ke halaman login kecuali logout dahulu
			redirect('user');
		}
		$this->form_validation->set_rules("email", "Email", "required|valid_email|trim");
		$this->form_validation->set_rules("password", "Password", "required|trim");
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Login';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			//validation success menggunakan method private
			$this->_login();
		}
	}
	private function _login()
	{
		$email = htmlspecialchars($this->input->post('email'));
		$password = htmlspecialchars($this->input->post('password'));

		$user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $email])->row_array();
		if ($user) { // jika usernya ada
			// jika usernya aktif
			if ($user['STATUS_AKTIF_PENGGUNA'] == 1) {
				// cek password
				if (password_verify($password, $user['PASSWORD_PENGGUNA'])) {
					$data = [
						'idp' => $user['ID_PENGGUNA'],
						'email' => $user['EMAIL_PENGGUNA'],
						'id_hak_akses' => $user['ID_HAK_AKSES']
					];
					
				if ($user['ID_HAK_AKSES'] == '1') {
				    $this->session->set_userdata($data);
						redirect('admin');
					} else if ($user['ID_HAK_AKSES'] == '2') {
				    $this->session->set_userdata($data);
						redirect('supervisor/dasbor');
					} else if ($user['ID_HAK_AKSES'] == '3') {
					    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum diaktivasi</div>');
						redirect('auth');
					} else if ($user['ID_HAK_AKSES'] == '4') {
					    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum diaktivasi</div>');
						redirect('auth');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password sallah</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum diaktivasi</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum terdaftar</div>');
			redirect('auth');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah berhasil keluar</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}

	public function forgotPassword()
	{
		$data['title'] = 'Lupa Password';

		$this->form_validation->set_rules("email", "Email", "required|valid_email|trim");
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array(); //untuk mengecek apakah email yang dipost ada dan sudah diaktivasi di table user
			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				//$this->_sendEmail($token, 'forgot'); //mengirim email untuk forgot password

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password</div>');
				redirect('auth/forgotPassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated</div>');
				redirect('auth/forgotPassword');
			}
		}
	}

	public function resetpassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get_where('pengguna_token', ['TOKEN' => $token])->row_array();
			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! wrong token</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! wrong email</div>');
			redirect('auth');
		}
	}

	public function changePassword()
	{
		$data['title'] = 'Ubah Password';

		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}

		$this->form_validation->set_rules("password1", "Password", "required|trim|min_length[3]|matches[password2]");
		$this->form_validation->set_rules("password2", "Repeat Password", "required|trim|min_length[3]|matches[password1]");
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('PASSWORD_PENGGUNA', $password);
			$this->db->where('EMAIL_PENGGUNA', $email);
			$this->db->update('pengguna');

			$this->session->unset_userdata('reset_email');
			$this->db->delete('pengguna_token', ['EMAIL' => $email]);

			echo "Password berhasil diganti, silahkan login kembali ke aplikasi ILMea anda";
			// redirect('auth');
		}
	}
}
