<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pengembalian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/laporan/Laporan_pengembalian_m', 'laporan_pengembalian_m');
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

            $data = $this->laporan_pengembalian_m->ambilData($idpg, $tgaw, $tgak);
            if (!$data->num_rows() > 0) {
                $respon = [
                    'status' => false,
                    'message' => "Data kosong"
                ];
            } else {
                $respon = [
                    'status' => true,
                    'message' => "Data berhasil didapatkan",
                    'laporan_pengembalian' => $data->result()
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
        $tgaw_no_conv = substr($dt,0,10);
        $tgak_no_conv = substr($dt,10,10);
        $tgaw = date("Y-m-d", strtotime($tgaw_no_conv));
        $tgak = date("Y-m-d", strtotime($tgak_no_conv));
        $id = substr($dt,20);
        $tgl = date('Y-m-d');
        $data['user'] = $this->db->query("
                        SELECT * FROM pengguna p JOIN _perusahaan ps ON ps.ID_PERUSAHAAN = p.ID_PERUSAHAAN
                        WHERE p.ID_PENGGUNA = '$id'")->row();
        $pengembalian1 = $this->db->query(
                "
               SELECT * FROM penjualan pj
            JOIN detail_surat_jalan dsj ON dsj.ID_DETAIL_SURAT_JALAN = pj.ID_DETAIL_SURAT_JALAN
            JOIN pelanggan p ON p.ID_PELANGGAN = pj.ID_PELANGGAN
            JOIN pengguna pg ON pg.ID_PENGGUNA = pj.ID_PENGGUNA
            JOIN barang b ON b.ID_BARANG = dsj.ID_BARANG
            JOIN pengembalian pb ON pb.ID_PENJUALAN = pj.ID_PENJUALAN
            WHERE pj.ID_PENGGUNA = '$id' AND pb.TGL_PENGEMBALIAN BETWEEN '$tgaw' AND '$tgak'
                "
            )->result();
        
        //$tgls = date("Y-m-d");
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

         $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 7, $data['user']->NAMA_PERUSAHAAN, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(0, 7, 'Alamat : Jl. Raya Wates No.3, Kec. Tanggulangin, Kabupaten Sidoarjo', 0, 1, 'C');
        $pdf->Cell(0, 7, 'Email : '.$data['user']->EMAIL_PEMILIK.', Telp/HP : '.$data['user']->NO_HP_PEMILIK, 0, 1, 'C');
        $pdf->Cell(0, 1, '___________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Times', '', 7);
        $pdf->Cell(0, 1, '_____________________________________________________________________________________________________________________________________________', 0, 1, 'C');
        $pdf->Ln(8);
        
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 7, 'LAPORAN PENGEMBALIAN', 0, 1, 'C');
        $pdf->Cell(20, 7, '', 0, 1);

        //$pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(15, 6, 'Periode', 0, 0, 'L');
        $pdf->Cell(5, 6, ':', 0, 0, 'L');
        $pdf->Cell(30, 6, date_indo($tgaw).' - '.date_indo($tgak), 0, 1, 'L');

        $pdf->Ln(3);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Sales', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Pelanggan', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Keterangan', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Jumlah', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 0;
        $ttl = 0;
        foreach ($pengembalian1 as $pnj2) {
            $no++;

            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(35, 6, $pnj2->NAMA_PENGGUNA, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_PELANGGAN, 1, 0);
            $pdf->Cell(35, 6, $pnj2->NAMA_BARANG, 1, 0);
            $pdf->Cell(50, 6, $pnj2->KETERANGAN_PENGEMBALIAN, 1, 0,'C');
            $pdf->Cell(25, 6, $pnj2->JUMLAH_PENGEMBALIAN, 1, 1,'C');
            $ttl = $ttl + $pnj2->JUMLAH_PENGEMBALIAN;
        }
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(165, 6, 'Jumlah Keseluruhan ', 1, 0,'C');
        $pdf->Cell(25, 6, $ttl, 1, 1,'C');

        $pdf->SetY(-65);
        $pdf->SetFont('Times', '', 10);
        $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY());
        $pdf->SetY(-65);
        $pdf->SetX(0);
        $pdf->Ln(1);


        $pdf->Output();
    }
}

/* End of file Laporan_pengembalian.php */
