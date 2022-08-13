<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pesan_ulang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/laporan/Laporan_pesan_ulang_m', 'laporan_pesan_ulang_m');
        $this->load->model('api/Api_m', 'api_m');
    }
    public function index()
    {
        $idpg = htmlspecialchars($this->input->post('id_pengguna'), true);
        $tgaw_no_convert = $this->input->post('tgaw');
        $tgak_no_convert = $this->input->post('tgak');
        $api_key = htmlspecialchars($this->input->post('API-KEY'), true);

        $tgaw = date("Y-m-d", strtotime($tgaw_no_convert));
        $tgak = date("Y-m-d", strtotime($tgak_no_convert));

        $cek_api_key = $this->api_m->CekApiKey($api_key);
        if ($cek_api_key->num_rows() > 0) {

            $data = $this->laporan_pesan_ulang_m->ambilData($idpg, $tgaw, $tgak);
            if (!$data->num_rows() > 0) {
                $respon = [
                    'status' => false,
                    'message' => "Data kosong"
                ];
            } else {
                $respon = [
                    'status' => true,
                    'message' => "Data berhasil didapatkan",
                    'laporan_pesan_ulang' => $data->result()
                ];
            }
        } else {
            $respon = [
                'status' => false,
                'message' => "Error API Key"
            ];
        }
        $json = json_encode($respon);
        echo $json;
    }

    public function cetak($dt = null)
    {
        $this->load->library('Pdf');
        $tgaw_no_conv = substr($dt, 0, 10);
        $tgak_no_conv = substr($dt, 10, 10);
        $tgaw = date("Y-m-d", strtotime($tgaw_no_conv));
        $tgak = date("Y-m-d", strtotime($tgak_no_conv));
        $id = substr($dt, 20);
        $tgl = date('Y-m-d');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$id'")->row();
        $pesanulang1 = $this->db->query(
            "
               SELECT * FROM pesan_ulang pu
            JOIN detail_pesan_ulang dpu ON dpu.ID_PESAN_ULANG = pu.ID_PESAN_ULANG
            JOIN pelanggan p ON p.ID_PELANGGAN = pu.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pu.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dpu.ID_BARANG
            WHERE pu.ID_PENGGUNA = '$id' AND pu.TGL_PESAN_ULANG BETWEEN '$tgaw' AND '$tgak'
            ORDER BY pu.TGL_PESAN_ULANG DESC
                "
        )->result();

        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
        $pdf->Cell(0, 7, 'Email : ' . $data['user']->EMAIL_PEMILIK . ', Telp/HP : ' . $data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '___________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_____________________________________________________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 7, 'LAPORAN PESAN ULANG', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(15, 6, 'Periode', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($tgaw) . ' - ' . date_indo($tgak), 0, 1, 'L');

        $pdf->Ln(3);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Sales', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Pelanggan', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(15, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Pembayaran', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Sub Total', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 0;
        $ttl = 0;

        foreach ($pesanulang1 as $pnj2) {
            $no++;

            if ($pnj2->HARGA_PESAN_ULANG > 0) {
                $sub = $pnj2->HARGA_PESAN_ULANG;
            } else {
                $sub = $pnj2->HARGA_JUAL_BARANG * $pnj2->JUMLAH_PESAN_ULANG;
            }

            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(15, 6, $pnj2->JUMLAH_PESAN_ULANG, 1, 0, 'C');
            $pdf->Cell(30, 6, $pnj2->STATUS_PEMBAYARAN_PESAN_ULANG, 1, 0, 'C');
            $pdf->Cell(30, 6, 'Rp. ' . number_format($sub), 1, 1, 'L');
            $ttl = $ttl + $sub;
        }

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(160, 6, 'Total ', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Rp. ' . number_format($ttl), 1, 1, 'L');

        $pdf->SetY(-65);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);

        $pdf->Output();
    }
}

/* End of file Laporan_pesan_ulang.php */
