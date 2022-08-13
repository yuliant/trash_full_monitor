<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/home/Home_m', 'home');
		$this->load->model('api/Api_m', 'api_m');
	}

	private function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}

	public function index()
	{
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);
		$id_pengguna = htmlspecialchars($this->input->post('id_pengguna'), true);

		if (!$api_key || !$id_pengguna) {
			$respon = [
				'status' => false,
				'message' => "Parameter not found"
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
		} else {
			$data = [
				"tanggal" =>  $this->tgl_indo(date('Y-m-d')),
				"belum_dikunjungi" => $this->home->belumDikunjungi(date('Y-m-d'), $id_pengguna)->num_rows(),
				"telah_dikunjungi" => $this->home->telahDikunjungi(date('Y-m-d'), $id_pengguna)->num_rows(),
				"history_kunjungan_bulanan" =>  $this->home->historyBulanan(date('m'), $id_pengguna)->num_rows(),
			];

			$respon = [
				'status' => true,
				'message' => "Data berhasil di unduh",
				"home_data" => $data
			];
		}
		$json = json_encode($respon);
		echo $json;
		die;
	}
}

/* End of file Home.php */
