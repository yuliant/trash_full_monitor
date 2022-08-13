<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjungan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('order/Order_m', 'order_m');
	}

	public function valid()
	{
		$id_valid_kunjungan = $this->input->get('ik');
		$id_pengguna = $this->input->get('ip');
		$lat = $this->input->get('l');
		$long = $this->input->get('lg');

		if (!$id_valid_kunjungan || !$id_pengguna) {
			echo "404 not found";
			die;
		}

		$user = $this->db->get_where('kunjungan', [
			'ID_PENGGUNA' => $id_pengguna,
			'KODE' => $id_valid_kunjungan
		])->row_array();

		if ($user) {
			if ($user['BUKTI_KUNJUNGAN']) {
				echo "404 not found";
				die;
			}

			$data = [
				'title' => 'Detail Kunjungan',
				'user' => $user,
				'lat' => $lat,
				'long' => $long
			];

			$this->load->view('order/detail_kunjungan', $data);
		} else {
			echo "404 not found";
			die;
		}
	}

	public function save()
	{
		if (!$_POST['image']) {
			echo "Silahkan ambil foto terlebih dahulu";
			die;
		}

		$img = $_POST['image'];
		$folderPath = "assets/img/kunjungan/";

		$image_parts = explode(";base64,", $img);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];

		$image_base64 = base64_decode($image_parts[1]);
		$fileName = uniqid() . '.png';

		$file = $folderPath . $fileName;
		file_put_contents($file, $image_base64);

		$kode = $this->input->post('kode', true);
		$lat = $this->input->post('lat', true);
		$longitude = $this->input->post('long', true);
		$keterangan = $this->input->post('keterangan', true);

		$data = array(
			'LATITUDE_KUNJUNGAN' => $lat,
			'LONGITUDE_KUNJUNGAN' => $longitude,
			'KETERANGAN_KUNJUNGAN' => $keterangan,
			'BUKTI_KUNJUNGAN' => $fileName,
			'STATUS_KUNJUNGAN' => 1
		);

		$res = $this->order_m->update_kunjungan($data, $kode);
		if (json_encode($res) == 1) {
			redirect('order/kunjungan/validation');
		} else {
			echo "Input gagal";
		}
	}

	public function fastaccess()
	{
		$kode = $this->input->get('ik');
		$id_pengguna = $this->input->get('ip');
		$lat = $this->input->get('l');
		$long = $this->input->get('lg');

		if (!$kode || !$id_pengguna) {
			echo "404 not found";
			die;
		}

		$user = $this->db->get_where('pengguna', [
			'ID_PENGGUNA' => $id_pengguna,
			'KODE_PENGGUNA' => $kode
		])->num_rows();

		if ($user == 1) {

			$data = [
				'title' => 'Akses Cepat',
				'id_pengguna' => $id_pengguna,
				'lat' => $lat,
				'long' => $long
			];

			$this->load->view('order/akses_cepat', $data);
		} else {
			echo "404 not found";
			die;
		}
	}

	public function save_aksescepat()
	{
	    
	    date_default_timezone_set("Asia/Jakarta");
		if (!$_POST['image']) {
			echo "Silahkan ambil foto terlebih dahulu";
			die;
		}

		$img = $_POST['image'];
		$folderPath = "assets/img/kunjungan/";

		$image_parts = explode(";base64,", $img);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];

		$image_base64 = base64_decode($image_parts[1]);
		$fileName = uniqid() . '.png';

		$file = $folderPath . $fileName;
		file_put_contents($file, $image_base64);

		$id_pengguna = $this->input->post('id_pengguna', true);
		$tgl = date('Y-m-d:H-i-s');
		$lat = $this->input->post('lat', true);
		$longitude = $this->input->post('long', true);
		$nama_toko = $this->input->post('nama_toko', true);
		$alamat_toko = $this->input->post('alamat_toko', true);
		$telp_toko = $this->input->post('telp_toko', true);
		$keterangan = $this->input->post('keterangan', true);

		$data = array(
			'ID_PENGGUNA' => $id_pengguna,
			'NAMA_KUNJUNGAN' => $nama_toko,
			'ALAMAT_KUNJUNGAN' => $alamat_toko,
			'NO_TELP_KUNJUNGAN' => $telp_toko,
			'BUKTI_KUNJUNGAN' => $fileName,
			'KETERANGAN_KUNJUNGAN' => $keterangan,
			'TGL_KUNJUNGAN' => $tgl,
			'LATITUDE_KUNJUNGAN' => $lat,
			'LONGITUDE_KUNJUNGAN' => $longitude,
			'STATUS_KUNJUNGAN' => 1
		);

		$res = $this->order_m->insert_kunjungan($data);
		if (json_encode($res) == 1) {
		    redirect('order/kunjungan/validation');
		} else {
			echo "Input gagal";
		}
	}
	
	public function validation()
	{
	    $data = ['title' => 'Input sukses'];
		$this->load->view('order/pesan_sukses', $data);
	}

	public function sukses()
	{
		$data = ['title' => 'Input sukses'];
		$this->load->view('order/pesan_sukses', $data);
	}
}

/* End of file Kunjungan.php */
