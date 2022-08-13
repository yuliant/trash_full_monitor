<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjungan_c extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('gudang/Supplier_m', 'supplier_m');
		$this->load->model('gudang/Satuan_m', 'satuan_m');
		$this->load->model('gudang/Barang_m', 'barang_m');
	}

	public function index($id_kunjungan = null)
	{
		$idp = $this->session->userdata('idp');
		$data['title'] = "Daftar Kunjungan";
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
		$idps = $data['user']['ID_PERUSAHAAN'];
		if ($id_kunjungan != null) {
			$data['kunjungan'] = $this->db->query("
                SELECT * FROM kunjungan k
                JOIN pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA 
                WHERE k.ID_KUNJUNGAN = '$id_kunjungan' AND p.ATASAN_PENGGUNA = '$idp'")->row();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('supervisor/kunjungan/detail', $data);
			$this->load->view('templates/footer');
		} else {
			// $data['barang'] = $this->barang_m->TampilData()->result();
			$data['kunjungan'] = $this->db->query("
                SELECT * FROM kunjungan k
                JOIN pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA 
                WHERE ATASAN_PENGGUNA = '$idp'")->result();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('supervisor/kunjungan/all', $data);
			$this->load->view('templates/footer');
		}
	}

	private function _random($n)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}

	public function tambah()
	{
		$idp = $this->session->userdata('idp');
		$nama_kunjungan = $this->input->post('nama_kunjungan');
		$data['title'] = "Tambah Data Kunjungan";
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();
		if ($nama_kunjungan == null) {
			$data['kunjungan'] = $this->db->query("
                SELECT * FROM kunjungan k
                JOIN pengguna p ON p.ID_PENGGUNA = k.ID_PENGGUNA 
                WHERE ATASAN_PENGGUNA = '$idp'
                ")->result();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('supervisor/kunjungan/add', $data);
			$this->load->view('templates/footer');
		} else {
			$post = $this->input->post(null, TRUE);
			$id_pengguna = $data['user']['ID_PENGGUNA'];
			$nama_kunjungan = $this->input->post('nama_kunjungan');
			$tgl_kunjungan = $this->input->post('tgl_kunjungan');
			$id_pengguna = $this->input->post('nama_sales');
			$no_telp_kunjungan = $this->input->post('no_telp_kunjungan');
			$alamat_kunjungan = $this->input->post('alamat_kunjungan');

			$data = array(
				'ID_PENGGUNA' => $id_pengguna,
				'NAMA_KUNJUNGAN' => $nama_kunjungan,
				'TGL_KUNJUNGAN' => $tgl_kunjungan,
				'NO_TELP_KUNJUNGAN' => $no_telp_kunjungan,
				'ALAMAT_KUNJUNGAN' => $alamat_kunjungan,
				'KODE' => $this->_random(10)
			);

			$this->db->insert('kunjungan', $data);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data kunjungan berhasil ditambahkan</div>');
			redirect('supervisor/kunjungan');
		}
	}

	public function ubah($id_barang)
	{
		$data['title'] = "Ubah Data Barang";
		$data['user'] = $this->db->get_where('pengguna', ['EMAIL_PENGGUNA' => $this->session->userdata('email')])->row_array();


		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
		$this->form_validation->set_rules('stok_barang', 'Stok Barang', 'required|trim|numeric|max_length[11]');
		$this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');
		$this->form_validation->set_rules('harga_beli_barang', 'Harga Beli Barang', 'required|trim|numeric|max_length[11]');
		$this->form_validation->set_rules('harga_jual_barang', 'Harga Jual Barang', 'required|trim|numeric|max_length[11]');
		//message
		$this->form_validation->set_message('required', '%s masih kosong, silahkan diisi');
		$this->form_validation->set_message('numeric', '%s harus diisi dengan nominasi angka');
		$this->form_validation->set_message('valid_email', '%s harus diisi dengan email yang valid');
		$this->form_validation->set_message('max_length', '%s anda terlalu panjang');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('gudang/barang/edit', $data);
			$this->load->view('templates/footer');
		} else {
			$post = $this->input->post(null, TRUE);
			$id_pengguna = $data['user']['ID_PENGGUNA'];
			$this->barang_m->ubahData($id_pengguna, $id_barang, $post);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data barang berhasil diubah</div>');
			redirect('gudang/barang');
		}
	}

	public function hapus($id_kunjungan)
	{
		// $this->barang_m->hapusData($id_barang);
		$this->db->where('ID_KUNJUNGAN', $id_kunjungan);
		$this->db->delete('kunjungan');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data kunjungan berhasil dihapus</div>');
		redirect('supervisor/kunjungan');
	}
}

/* End of file Barang_c.php */
