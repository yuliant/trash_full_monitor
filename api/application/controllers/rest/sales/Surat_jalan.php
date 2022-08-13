<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_jalan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/sales/Surat_jalan_m', 'surat_jalan_m');
		$this->load->model('api/Api_m', 'api_m');
	}

	public function index()
	{
		$idpg = htmlspecialchars($this->input->post('id_pengguna'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);
		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {
			$data = $this->surat_jalan_m->TampilData($idpg);
			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'surat_jalan' => $data->result()
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

	public function detail_surat_jalan()
	{
		$id_surat_jalan = htmlspecialchars($this->input->post('id_surat_jalan'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$detail_surat_jalan = $this->surat_jalan_m->SuratJalanById($id_surat_jalan);
			$detail_barang_surat_jalan = $this->surat_jalan_m->detailBarangSuratJalan($id_surat_jalan);
			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'detail_surat_jalan' => $detail_surat_jalan->row(),
				'detail_barang_surat_jalan' => $detail_barang_surat_jalan->result(),
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

	public function hapus_detail_surat_jalan()
	{
		$id_detail_surat_jalan = htmlspecialchars($this->input->post('id_detail_surat_jalan'), true);
		$id_barang = htmlspecialchars($this->input->post('id_barang'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$data = $this->surat_jalan_m->TampilDetailBarangSuratJalan($id_detail_surat_jalan)->row();

			//tambah stok barang
			$this->surat_jalan_m->UpdateStokBarang($id_barang, $data->JUMLAH_BAWA);
			//hapus detail barang
			$this->surat_jalan_m->HapusDetailBarang($id_detail_surat_jalan);

			$respon = [
				'status' => true,
				'message' => "Data berhasil dihapus"
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

	public function input_penjualan()
	{
		$tgip = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('tgl_penjualan'), true)));
		$plg = htmlspecialchars($this->input->post('id_pelanggan'), true);
		if ($plg == '') {
			$respon = [
				'status' => false,
				'message' => "Mohon tambahkan pelanggan terlebih dahulu."
			];
		} else {
			$id_detail_surat_jalan = htmlspecialchars($this->input->post('id_detail_surat_jalan'), true);
			$idpg = htmlspecialchars($this->input->post('id_pengguna'), true);
			$id_pelanggan = htmlspecialchars($this->input->post('id_pelanggan'), true);
			$tgl_penjualan = $tgip;
			$jenis_pembayaran = htmlspecialchars($this->input->post('jenis_pembayaran'), true);
			$jumlah_jual = htmlspecialchars($this->input->post('jumlah_jual'), true);
			$jumlah_bawa = htmlspecialchars($this->input->post('jumlah_bawa'), true);
			$harga_jual = htmlspecialchars($this->input->post('harga_penjualan'), true);
			$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

			$cek_api_key = $this->api_m->CekApiKey($api_key);
			if ($cek_api_key->num_rows() > 0) {

				$data = [
					'ID_DETAIL_SURAT_JALAN' => $id_detail_surat_jalan,
					'ID_PENGGUNA' => $idpg,
					'ID_PELANGGAN' => $id_pelanggan,
					'TGL_PENJUALAN' => $tgl_penjualan,
					'JUMLAH_PENJUALAN' => $jumlah_jual,
					'HARGA_PENJUALAN' => $harga_jual,
					'STATUS_PEMBAYARAN_PENJUALAN' => $jenis_pembayaran
				];
				$this->db->insert('penjualan', $data);

				$jmlsisa = $jumlah_bawa - $jumlah_jual;
				$this->db->where('ID_DETAIL_SURAT_JALAN', $id_detail_surat_jalan);
				$this->db->update('detail_surat_jalan', ['JUMLAH_SISA' => $jmlsisa]);

				$respon = [
					'status' => true,
					'message' => "Data berhasil diinputkan"
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

	public function tambah()
	{
		$idpg = htmlspecialchars($this->input->post('id_pengguna'), true);
		$tgsu = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('tgl_surat_jalan'), true)));
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$dariDB = $this->surat_jalan_m->noSJ();
			$nourut = substr($dariDB, 4, 6);
			$noSJ1 = $nourut + 1;
			$noSJ2 = "SRJ-" . sprintf("%06s", $noSJ1);

			$data = [
				'ID_PENGGUNA' => $idpg,
				'NO_SURAT_JALAN' => $noSJ2,
				'TGL_SURAT_JALAN' => $tgsu
			];
			$this->db->insert('surat_jalan', $data);

			$data = $this->surat_jalan_m->SuratJalanByNomor($noSJ2)->row();
			if ($data->STATUS_SURAT_JALAN == 0) {
				$status_data = "Belum diverifikasi";
			} elseif ($data->STATUS_SURAT_JALAN == 1) {
				$status_data = "Telah diverifikasi";
			} else {
				$status_data = "Verifikasi Ditolak";
			}

			$data_su = [
				'id_surat_jalan' => $data->ID_SURAT_JALAN,
				'no_surat_jalan' => $data->NO_SURAT_JALAN,
				'tgl_surat_jalan' => $data->TGL_SURAT_JALAN,
				'status_surat_jalan' => $status_data
			];

			$respon = [
				'status' => true,
				'message' => "Data berhasil diinputkan",
				'detail_surat_jalan' => $data_su
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

	public function tambah_barang_detail()
	{
		$id_surat_jalan = htmlspecialchars($this->input->post('id_surat_jalan'), true);
		$id_barang = htmlspecialchars($this->input->post('id_barang'), true);
		$jumlah_bawa = htmlspecialchars($this->input->post('jumlah_bawa'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$data = [
				'ID_SURAT_JALAN' => $id_surat_jalan,
				'ID_BARANG' => $id_barang,
				'JUMLAH_BAWA' => $jumlah_bawa,
				'JUMLAH_SISA' => $jumlah_bawa
			];
			$this->db->insert('detail_surat_jalan', $data);

			$stok_barang = $this->surat_jalan_m->data_barang($id_barang)->row();

			$jml_sisa_stok = $stok_barang->STOK_BARANG - $jumlah_bawa;
			$this->db->where('ID_BARANG', $id_barang);
			$this->db->update('barang', ['STOK_BARANG' => $jml_sisa_stok]);

			$respon = [
				'status' => true,
				'message' => "Data berhasil diinputkan"
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

	public function lihat_penjualan()
	{
		$id_surat_jalan = htmlspecialchars($this->input->post('id_surat_jalan'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$datapnj = $this->db->query("
                    SELECT * FROM detail_surat_jalan dsj 
                    JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                    JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                    JOIN penjualan p ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                    JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                    WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan'")->result();

			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'lihat_penjualan' => $datapnj,
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

	public function pengembalian()
	{
		$id_penjualan = htmlspecialchars($this->input->post('id_penjualan'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$datapnj = $this->db->query("
                SELECT * FROM detail_surat_jalan dsj 
                JOIN surat_jalan sj ON sj.ID_SURAT_JALAN = dsj.ID_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN penjualan p ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                JOIN pengembalian pmb ON pmb.ID_PENJUALAN = p.ID_PENJUALAN
                WHERE p.ID_PENJUALAN = '$id_penjualan'")->result();

			$respon = [
				'status' => true,
				'message' => "Data berhasil didapatkan",
				'lihat_pengembalian' => $datapnj,
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

	public function pengembalian_tambah()
	{
		$id_penjualan = htmlspecialchars($this->input->post('id_penjualan'), true);
		$tgl_pengembalian = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('tgl_pengembalian'), true)));
		$jumlah_kembali = htmlspecialchars($this->input->post('jumlah_kembali'), true);
		$ket_pengembalian = htmlspecialchars($this->input->post('ket_pengembalian'), true);
		$api_key = htmlspecialchars($this->input->post('API-KEY'), true);

		$cek_api_key = $this->api_m->CekApiKey($api_key);
		if ($cek_api_key->num_rows() > 0) {

			$data = [
				'ID_PENJUALAN' => $id_penjualan,
				'TGL_PENGEMBALIAN' => $tgl_pengembalian,
				'JUMLAH_PENGEMBALIAN' => $jumlah_kembali,
				'KETERANGAN_PENGEMBALIAN' => $ket_pengembalian
			];
			$this->db->insert('pengembalian', $data);

			$respon = [
				'status' => true,
				'message' => "Data berhasil diinputkan"
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
		$id_surat_jalan2 = $this->input->get('idsj');
		$idp = $this->input->get('idp');
		$tgl = date('Y-m-d');
		$data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$idp'")->row();
		$data['surat_jalan'] = $this->db->query(

			"
                SELECT * FROM surat_jalan sj 
                JOIN pengguna p ON p.ID_PENGGUNA = sj.ID_PENGGUNA
                WHERE sj.ID_SURAT_JALAN = '$id_surat_jalan2'
                "
		)->row();

		$data['detail_surat_jalan'] = $this->db->query(
			"
                SELECT * FROM detail_surat_jalan dsj 
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE dsj.ID_SURAT_JALAN = '$id_surat_jalan2'
                "
		)->result();

		$tgls = date("Y-m-d");
		error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

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
		$pdf->Cell(0, 7, 'SURAT JALAN', 0, 1, 'C');
		$pdf->Cell(15, 7, '', 0, 1);

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(30, 6, 'No Surat Jalan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(40, 6, $data['surat_jalan']->NO_SURAT_JALAN, 0, 0, 'L');

		$pdf->Cell(20, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['surat_jalan']->TGL_SURAT_JALAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['surat_jalan']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Ln(15);

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Harga', 1, 1, 'C');

		$pdf->SetFont('Arial', '', 10);

		$no = 0;
		$ttl = 0;
		$ttl2 = 0;

		foreach ($data['detail_surat_jalan'] as $detail) {
			$no++;
			$ttl2 = $detail->HARGA_JUAL_BARANG * $detail->JUMLAH_BAWA;
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $detail->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $detail->JUMLAH_BAWA, 1, 0, 'C');
			$pdf->Cell(20, 6, $detail->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl2), 1, 1, 'C');
			$ttl = $ttl + $ttl2;
		}

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(100, 6, 'Sub Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($tgls), 0, 1, 'C');

		$pdf->SetY(-59);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-59);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

		$pdf->SetY(-29);
		$pdf->SetFont('Arial', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-29);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '(................................)', 0, 1, 'C');

		$pdf->Output();
	}

	public function cetak_penjualan()
	{
		$this->load->library('Pdf');
		$id_penjualan2 = $this->input->get('idpj');
		$idp = $this->input->get('idp');
		$tgl = date('Y-m-d');
		$data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$idp'")->row();
		$data['penjualan'] = $this->db->query(
			"
                SELECT * FROM penjualan p 
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                WHERE p.ID_PENJUALAN = '$id_penjualan2'
                "
		)->row();
		$data['penjualan2'] = $this->db->query(
			"
                SELECT * FROM penjualan p 
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                WHERE p.ID_PENJUALAN = '$id_penjualan2'
                "
		)->result();

		error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

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

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(0, 7, 'NOTA PENJUALAN', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['penjualan']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['penjualan']->NO_HP_PELANGGAN, 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['penjualan']->STATUS_PEMBAYARAN_PENJUALAN, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Times', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['penjualan2'] as $pnj2) {
			$no++;
			if ($pnj2->HARGA_PENJUALAN > 0) {
				$sub = $pnj2->HARGA_PENJUALAN;
			} else {
				$sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENJUALAN;
			}
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $pnj2->JUMLAH_PENJUALAN, 1, 0, 'C');
			$pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Sales', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Times', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK PELANGGAN', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(40, 6, '(' . $data['user']->NAMA_PENGGUNA . ')', 0, 1, 'C');


		$pdf->AddPage();

		$pdf->SetFont('Times', 'B', 16);
		$pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
		$pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
		$pdf->SetFont('Times', '', 7);
		$pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
		$pdf->Ln(8);

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(0, 7, 'NOTA PENJUALAN', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['user']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['penjualan']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['penjualan']->NO_HP_PELANGGAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['penjualan']->STATUS_PEMBAYARAN_PENJUALAN, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Times', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['penjualan2'] as $pnj2) {
			$no++;
			if ($pnj2->HARGA_PENJUALAN > 0) {
				$sub = $pnj2->HARGA_PENJUALAN;
			} else {
				$sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENJUALAN;
			}
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $pnj2->JUMLAH_PENJUALAN, 1, 0, 'C');
			$pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($data['penjualan']->TGL_PENJUALAN), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Times', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK ARSIP', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(40, 6, '(......................................)', 0, 1, 'C');

		$pdf->Output();
	}

	public function cetak_pengembalian()
	{
		$this->load->library('Pdf');
		$id_pengembalian2 = $this->input->get('idpmb');
		$idp = $this->input->get('idp');
		$tgl = date('Y-m-d');
		$data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$idp'")->row();
		$data['pengembalian'] = $this->db->query(
			"
                SELECT * FROM pengembalian pb 
                JOIN penjualan p ON pb.ID_PENJUALAN = p.ID_PENJUALAN
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN pelanggan pl ON pl.ID_PELANGGAN = p.ID_PELANGGAN
                JOIN pengguna pg ON pg.ID_PENGGUNA = p.ID_PENGGUNA
                WHERE pb.ID_PENGEMBALIAN = '$id_pengembalian2'
                "
		)->row();
		$data['pengembalian2'] = $this->db->query(
			"
                SELECT * FROM pengembalian pb 
                JOIN penjualan p ON pb.ID_PENJUALAN = p.ID_PENJUALAN
                JOIN detail_surat_jalan dsj ON p.ID_DETAIL_SURAT_JALAN = dsj.ID_DETAIL_SURAT_JALAN
                JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
                JOIN satuan s ON s.ID_SATUAN = b.ID_SATUAN
                JOIN pengguna pg ON pg.ID_PENGGUNA = p.ID_PENGGUNA
                WHERE pb.ID_PENGEMBALIAN = '$id_pengembalian2'
                "
		)->result();

		//$tgls = date("Y-m-d");
		error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

		$pdf = new FPDF('P', 'mm', 'A5');
		$pdf->AddPage();

		$pdf->SetFont('Times', 'B', 16);
		$pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		// $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
		$pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
		$pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
		$pdf->SetFont('Times', '', 7);
		$pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
		$pdf->Ln(8);

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(130, 7, 'SURAT PENGEMBALIAN', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		//$pdf->Ln(20);
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NAMA_PENGGUNA, 0, 0, 'L');
		// $pdf->Cell(30, 6, $idp, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['pengembalian']->TGL_PENGEMBALIAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NO_HP_PELANGGAN, 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->STATUS_PEMBAYARAN_PENJUALAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Keterangan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->KETERANGAN_PENGEMBALIAN, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Times', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['pengembalian2'] as $pnj2) {
			$no++;
			if ($pnj2->HARGA_PENJUALAN > 0) {
				$sub = $pnj2->HARGA_PENJUALAN;
			} else {
				$sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENGEMBALIAN;
			}
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 0, 'C');
			$pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($tgl), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Sales', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Times', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK PELANGGAN', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(40, 6, '(' . $data['pengembalian']->NAMA_PENGGUNA . ')', 0, 1, 'C');

		$pdf->AddPage();

		$pdf->SetFont('Times', 'B', 16);
		$pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		// $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
		$pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
		$pdf->Cell(0, 1, '________________________________________________________________________', 0, 1, 'C');
		$pdf->SetFont('Times', '', 7);
		$pdf->Cell(0, 1, '_______________________________________________________________________________________________________', 0, 1, 'C');
		$pdf->Ln(8);

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(130, 7, 'SURAT PENGEMBALIAN', 0, 1, 'C');
		$pdf->Cell(20, 7, '', 0, 1);

		//$pdf->Ln(20);
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(30, 6, 'Nama Sales', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NAMA_PENGGUNA, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, date_indo($data['pengembalian']->TGL_PENGEMBALIAN), 0, 1, 'L');

		$pdf->Cell(30, 6, 'Nama Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NAMA_PELANGGAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'HP Pelanggan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->NO_HP_PELANGGAN, 0, 1, 'L');

		$pdf->Cell(30, 6, 'Pembayaran', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->STATUS_PEMBAYARAN_PENJUALAN, 0, 0, 'L');

		$pdf->Cell(30, 6, 'Keterangan', 0, 0, 'L');
		$pdf->Cell(5, 6, ':', 0, 0, 'L');
		$pdf->Cell(30, 6, $data['pengembalian']->KETERANGAN_PENGEMBALIAN, 0, 1, 'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Jumlah Barang', 1, 0, 'C');
		$pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

		$pdf->SetFont('Times', '', 10);
		$no = 0;
		$ttl = 0;
		foreach ($data['pengembalian2'] as $pnj2) {
			$no++;
			if ($pnj2->HARGA_PENJUALAN > 0) {
				$sub = $pnj2->HARGA_PENJUALAN;
			} else {
				$sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PENGEMBALIAN;
			}
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(40, 6, $pnj2->NAMA_BARANG, 1, 0);
			$pdf->Cell(30, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 0, 'C');
			$pdf->Cell(20, 6, $pnj2->NAMA_SATUAN, 1, 0, 'C');
			$pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'C');
			$ttl = $ttl + $sub;
		}
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 6, 'Total ', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'C');

		$pdf->SetY(-65);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-65);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, '' . date_indo($tgl), 0, 1, 'C');

		$pdf->SetY(-55);
		$pdf->SetFont('Times', '', 10);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-55);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(90, 6, '', 0, 0, 'C');
		$pdf->Cell(40, 6, 'Supervisor', 0, 1, 'C');

		$pdf->SetY(-30);
		$pdf->SetFont('Times', '', 8);
		$pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
		$pdf->SetY(-30);
		$pdf->SetX(0);
		$pdf->Ln(1);

		$pdf->Cell(50, 6, 'LEMBAR UNTUK ARSIP', 1, 0, 'C');
		$pdf->Cell(40, 6, '', 0, 0, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(40, 6, '(......................................)', 0, 1, 'C');

		$pdf->Output();
	}
}

/* End of file Surat_jala.php */
