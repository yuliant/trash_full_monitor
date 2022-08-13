<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct() //method untuk menerapkan seluruh fungsi didalamnya ke dalam seluruh method di controller
	{
		parent::__construct(); // syarat method
		is_logged_in();
	}

	public function index()
	{
		/*$data['title'] = 'Halaman Utama';
    $data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');*/
		redirect('User');
	}

	public function role()
	{
		$data['title'] = 'Hak Akses';
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		//query get table user_role = mengambil semua data dari user_role dan mengirimkannya ke variable role
		$data['role'] = $this->db->get('hak_akses')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role', $data);
		$this->load->view('templates/footer');
	}

	public function roleAccess($role_id)
	{
		$data['title'] = 'Hak Akses';
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		//query get table user_role = mengambil satu baris data user_role berserta id nya dari user_role dan mengirimkannya ke variable role
		$data['role'] = $this->db->get_where('hak_akses', ['ID_HAK_AKSES' => $role_id])->row_array();

		//query get table user_menu = mengambil semua data user_menu dan mengirimkannya ke variable menu
		$this->db->where('ID_MENU_PENGGUNA !=', 1); // semua data diambil kecuali data dengan id 1
		$data['menu'] = $this->db->get('menu_pengguna')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'ID_HAK_AKSES' => $role_id,
			'ID_MENU_PENGGUNA' => $menu_id
		];

		$result = $this->db->get_where('MENU_HAK_AKSES', $data);
		if ($result->num_rows() < 1) {
			$this->db->insert('MENU_HAK_AKSES', $data);
		} else {
			$this->db->delete('MENU_HAK_AKSES', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akses Terganti</div>');
	}

	public function addRole()
	{
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		//validation
		$this->form_validation->set_rules('role', 'Role', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'HAK_AKSES' => $this->input->post('role')
			];
			$this->db->insert('HAK_AKSES', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Hak Akses Berhasil Disimpan</div>');
			redirect('admin/role');
		}
	}

	public function deleteRole($id)
	{
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		$this->load->model('Admin_model', 'admin');
		$this->admin->deleteRole($id);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Hak Akses Berhasil Dihapus</div>');
		redirect('admin/role');
	}


	public function kelolaUser()
	{
		$data['title'] = 'Kelola Pengguna';
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		$data['kelolaUser'] = $this->db->query("
          SELECT * 
          FROM pengguna 
		  JOIN _perusahaan ON pengguna.ID_PERUSAHAAN = _perusahaan.ID_PERUSAHAAN
		  JOIN hak_akses ON pengguna.ID_HAK_AKSES = hak_akses.ID_HAK_AKSES
          WHERE pengguna.ID_HAK_AKSES != '1'")->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/kelola-user', $data);
		$this->load->view('templates/footer');
	}

	public function change_status_user($id, $is_active)
	{
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		if ($this->db->get_where('pengguna', ['ID_PENGGUNA' => $id, 'STATUS_AKTIF_PENGGUNA' => $is_active = 1])->row_array()) {
			$this->db->where('ID_PENGGUNA', $id);
			$this->db->update('pengguna', ['STATUS_AKTIF_PENGGUNA' => 0]);
		} else if ($this->db->get_where('pengguna', ['ID_PENGGUNA' => $id, 'STATUS_AKTIF_PENGGUNA' => $is_active = 0])->row_array()) {
			$this->db->where('ID_PENGGUNA', $id);
			$this->db->update('pengguna', ['STATUS_AKTIF_PENGGUNA' => 1]);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status Pengguna Berhasil Diubah</div>');
		redirect('admin/kelolaUser');
	}
	public function tambah_user()
	{
		$data['title'] = 'Tambah Data Pengguna';
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
		$data['jab'] = $this->db->get('hak_akses')->result_array();
		$data['perusahaan'] = $this->db->get('_perusahaan')->result_array();
		//validation
		$this->form_validation->set_rules("name", "Name", "required|trim");
		$this->form_validation->set_rules("email", "Email", "required|valid_email|trim|is_unique[pengguna.EMAIL_PENGGUNA]", [
			'is_unique' => 'This email has already registered'
		]);
		$this->form_validation->set_rules("new_pasword1", "Password", "required|trim|min_length[3]|matches[new_pasword2]", [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules("new_pasword2", "Password", "required|trim|min_length[3]|matches[new_pasword1]");
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/tambah-user', $data);
			$this->load->view('templates/footer');
		} else {
			$email = $this->input->post('email', true);
			$data = [
				'NAMA_PENGGUNA' => htmlspecialchars($this->input->post('name', true)),
				'EMAIL_PENGGUNA' => htmlspecialchars($email),
				'FOTO_PENGGUNA' => 'default.jpg',
				'PASSWORD_PENGGUNA' => password_hash($this->input->post('new_pasword1'), PASSWORD_DEFAULT),
				'ID_HAK_AKSES' => htmlspecialchars($this->input->post('hak_akses', true)),
				'ID_PERUSAHAAN' => htmlspecialchars($this->input->post('perusahaan', true)),
				'STATUS_AKTIF_PENGGUNA' => 1,
				'TGL_DAFTAR_PENGGUNA' => date('Y-m-d')
			];
			$this->db->insert('pengguna', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengguna Berhasil Disimpan</div>');
			redirect('admin/kelolaUser');
		}
	}

	public function delete_user($id)
	{
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();

		$this->load->model('Admin_model', 'admin');
		$this->admin->deleteUser($id);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Pengguna Berhasil Dihapus</div>');
		redirect('admin/kelolaUser');
	}
}
