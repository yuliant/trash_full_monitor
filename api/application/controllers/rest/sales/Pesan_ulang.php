<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_ulang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/sales/Pesan_ulang_m', 'pesan_ulang_m');
		$this->load->model('api/Api_m', 'api_m');
	}

	public function index()
	{
		$idpg = htmlspecialchars($this->input->post('id_pengguna'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {
			$data = $this->pesan_ulang_m->ambilData($idpg);
			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'pesan_ulang' => $data->result()
			];
		} else {
			$respon = [
				'status' => false,
				'message' => "Error API Key"
			];
		}
		$json = json_encode($respon);
		echo $json;
	}

	public function detail()
	{
		$id_pesan_ulang = htmlspecialchars($this->input->post('id_pesan_ulang'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$data_detail = $this->pesan_ulang_m->ambilSatuDatabyIdPesanUlang($id_pesan_ulang);
			$data_detail_barang = $this->pesan_ulang_m->detailBarangPesanUlang($id_pesan_ulang);

			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'pesan_ulang_detail' => $data_detail,
				'detail_barang' => $data_detail_barang
			];
		} else {
			$respon = [
				'status' => false,
				'message' => "Error API Key"
			];
		}
		$json = json_encode($respon);
		echo $json;
	}

	public function tambah_data()
	{
		$plg = htmlspecialchars($this->input->post('id_pelanggan'), true);
		if ($plg == '') {
			$respon = [
				'status' => false,
				'message' => "Mohon tambahkan pelanggan terlebih dahulu."
			];
		} else {
			$tgpu = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('tgl_pesan_ulang'), true)));

			$data = [
				'ID_PENGGUNA' => htmlspecialchars($this->input->post('id_pengguna'), true),
				'ID_PELANGGAN' => htmlspecialchars($this->input->post('id_pelanggan'), true),
				'TGL_PESAN_ULANG' => $tgpu,
				'STATUS_PEMBAYARAN_PESAN_ULANG' => htmlspecialchars($this->input->post('jenis_pembayaran'), true)
			];
			$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

			$cek_api_key = $this->api_m->CekApiKey($api_key);
			if ($cek_api_key->num_rows() > 0) {

				$this->pesan_ulang_m->tambahDataPesanUlang($data);
				$dt = $this->pesan_ulang_m->dataterakhir($data['ID_PENGGUNA'])->row();
				$data_pu = [
					'id_pesan_ulang' => $dt->ID_PESAN_ULANG,
					'tgl_pesan_ulang' => $dt->TGL_PESAN_ULANG,
					'nama_pelanggan' => $dt->NAMA_PELANGGAN,
					'status_verifikasi' => $dt->STATUS_PESAN_ULANG,
				];

				$respon = [
					'status' => true,
					'message' => "Data pesan ulang berhasil diinputkan",
					'detail_pesan_ulang' => $data_pu
				];
			} else {
				$respon = [
					'status' => false,
					'message' => "Error API Key"
				];
			}
		}
		$json = json_encode($respon);
		echo $json;
	}

	public function tambah_data_detail()
	{
		$data = [
			'ID_PESAN_ULANG' => htmlspecialchars($this->input->post('id_pesan_ulang'), true),
			'ID_BARANG' => htmlspecialchars($this->input->post('id_barang'), true),
			'JUMLAH_PESAN_ULANG' => htmlspecialchars($this->input->post('jumlah_pesan_ulang'), true),
			'HARGA_PESAN_ULANG' => htmlspecialchars($this->input->post('harga_pesan_ulang'), true)
		];
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$this->pesan_ulang_m->tambahDetailPesanUlang($data);
			$respon = [
				'status' => true,
				'message' => "Data detail barang pesan ulang berhasil diinputkan"
			];
		} else {
			$respon = [
				'status' => false,
				'message' => "Error API Key"
			];
		}
		$json = json_encode($respon);
		echo $json;
	}
	public function cetak()
	{
		$this->load->library('Pdf');
		$id_pesan_ulang2 = $this->input->get('idps');
		$idp = $this->input->get('idp');
		$tgl = date('Y-m-d');
		// $data['user'] = $this->db->get_where('pengguna', ['ID_PENGGUNA' => $idp])->row_array();
		$data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$idp'")->row();
		$data['pesan_ulang'] = $this->db->query(
			"
                SELECT * FROM pesan_ulang pu 
                JOIN pengguna p ON p.ID_PENGGUNA = pu.ID_PENGGUNA
                JOIN pelanggan pl ON pl.ID_PELANGGAN = pu.ID_PELANGGAN
                WHERE pu.ID_PESAN_ULANG = '$id_pesan_ulang2'
                "
		)->row();
		$data['detail_pesan_ulang'] = $this->db->query(
			"
                SELECT * FROM detail_pesan_ulang dpu 
                JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE dpu.ID_PESAN_ULANG = '$id_pesan_ulang2'
                "
		)->result();
		$tgls = date("Y-m-d");
		error_reporting(0);

		$pdf = new FPDF('P', 'mm', 'A5');
		$pdf->AddPage();
		$pdf->SetFont('Times', 'B', 16);
		$pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
		$pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
		$pdf->SetFont('Times', '', 7);
		$pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
		$pdf->Ln(8);

		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 7, 'PESAN ULANG', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		//$pdf->Ln(20);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NO_HP_PELANGGAN, 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->STATUS_PEMBAYARAN_PESAN_ULANG, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Arial', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['detail_pesan_ulang'] as $dpu) {
			$no++;
			if ($dpu->HARGA_PESAN_ULANG > 0) {
				$sub = $dpu->HARGA_PESAN_ULANG;
			} else {
				$sub = $dpu->HARGA_JUAL_BARANG * $dpu->JUMLAH_PESAN_ULANG;
			}
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $dpu->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $dpu->JUMLAH_PESAN_ULANG, 1, 0, 'C');
			$pdf->Cell(20, 6, $dpu->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Sales', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Arial', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK PELANGGAN', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 6, '(' . $data['pesan_ulang']->NAMA_PENGGUNA . ')', 0, 1, 'C');

		$pdf->AddPage();

		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 7, 'PESAN ULANG', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		//$pdf->Ln(20);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->NO_HP_PELANGGAN, 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pesan_ulang']->STATUS_PEMBAYARAN_PESAN_ULANG, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Arial', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['detail_pesan_ulang'] as $dpu) {
			$no++;

			if ($dpu->HARGA_PESAN_ULANG > 0) {
				$sub = $dpu->HARGA_PESAN_ULANG;
			} else {
				$sub = $dpu->HARGA_JUAL_BARANG * $dpu->JUMLAH_PESAN_ULANG;
			}

			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $dpu->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $dpu->JUMLAH_PESAN_ULANG, 1, 0, 'C');
			$pdf->Cell(20, 6, $dpu->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($data['pesan_ulang']->TGL_PESAN_ULANG), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Arial', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK ARSIP', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(40, 6, '(......................................)', 0, 1, 'C');

		$pdf->Output();
	}
}

/* End of file Pesan_ulang.php */
